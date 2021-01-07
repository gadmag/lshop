<?php


namespace App\Filters;


use App\Option;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

abstract class QueryFilter
{

    protected $request;

    protected $builder;

    protected $allowedFilters = [];

    protected $orderable = [];


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return mixed
     * @throws ValidationException
     */
    public function process(Builder $builder)
    {
        $this->builder = $builder;

        $validation = validator()->make($this->fields(), [
            //orders
            'sort' => 'sometimes|required|in:' . $this->orderableColumns(),
            'direction' => 'sometimes|required|in:asc,desc',
            'pagination' => 'sometimes|required|in:ok',
            'limit' => 'sometimes|required|integer|min:1',

            // filters
            'filter_match' => 'sometimes|required|in:and,or',
            'f' => 'sometimes|required|array',
            'f.*.field' => 'required|in:' . $this->whiteListFields(),
            'f.*.operator' => 'required_with:f.*.field|in:' . $this->allowedOperators(),
            'f.*.query_1' => 'required',
            'f.*.query_2' => 'required_if:f.*.operator,between,not_between'

        ]);

        if ($validation->fails()) {
            throw new ValidationException;
        }

        return $this->apply();
    }

    public function apply()
    {
        $fields = $this->fields();
        if (isset($fields['f'])) {
            foreach ($fields['f'] as $filter) {
                $filter['match'] = isset($filter['filter_match']) ? $$filter['filter_match'] : 'end';
                $this->makeFilter($filter);
            }
        }
        $this->makeOrder();
//        dd( $this->builder->getQuery());
        return $this->builder;
    }


    /**
     * Make filter model
     * @param array $filter
     */
    protected function makeFilter(array $filter): void
    {
        if (strpos($filter['field'], '.') !== false) {

            list($relation, $filter['field']) = explode('.', $filter['field']);
            $filter['match'] = 'end';

            if ($filter['field'] == 'count') {
                $this->{camel_case($filter['operator'])}($filter, $relation, $this->builder);
            } else {

                $this->builder->whereHas($relation, function ($q) use ($filter) {
                    $this->{camel_case($filter['operator'])}($filter, $q);
                });
            }

        } else {
            $this->{camel_case($filter['operator'])}($filter, $this->builder);
        }
    }

    protected function makeOrder()
    {
        list($column, $direction) = $this->parseOrderParams();
        if (is_null($column)) {
            return $this->builder;
        }
        $explodeRelation = $this->explodeRelationColumn($column);
        if (!empty($explodeRelation)) {
            list($relationName, $column) = $explodeRelation;
            try {

                $relation = $this->builder->getRelation($relationName);
                $this->queryJoinBuilder($relation);

            } catch (\BadMethodCallException $e) {
                throw new \Exception("Relation {$relationName} does not exist", 0, $e);
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
            $model = $relation->getRelated();
            return $this->builder->orderByRaw("{$model->getTable()}.{$column} {$direction}");
        }

        return $this->builder->orderBy($column, $direction);
    }


    /**
     * @param $filter
     * @return Builder
     */
    public function equalTo($filter, $query)
    {
        return $query->where($filter['field'], '=', $filter['query_1']);
    }

    /**
     * @param $filter
     * @return Builder
     */
    public function equalIn($filter, $query)
    {
        $list_id = explode(',', $filter['query_1']);
        return $query->whereIn($filter['field'], $list_id);
    }

    public function notEqualTo($filter, $query)
    {
        return $query->where($filter['field'], '<>', $filter['query_1']);
    }

    public function lessThan($filter, $query)
    {
        return $query->where($filter['field'], '<', $filter['query_1']);
    }

    public function greaterThan($filter, $query)
    {
        return $query->where($filter['field'], '>', $filter['query_1']);
    }

    public function between($filter, $query)
    {
        return $query->whereBetween($filter['field'], [
            $filter['query_1'],
            $filter['query_2']
        ]);
    }

    public function notBetween($filter, $query)
    {
        return $query->whereNotBetween($filter['field'], [
            $filter['query_1'],
            $filter['query_2']
        ]);
    }

    public function contains($filter, $query)
    {
        return $query->where($filter['column'], 'like', '%' . $filter['query_1'] . '%', $filter['match']);
    }


    protected function whiteListFields()
    {
        return implode(',', $this->allowedFilters);
    }

    protected function orderableColumns()
    {
        return implode(',', $this->orderable);
    }

    protected function allowedOperators()
    {
        return implode(',', [
            'equal_to',
            'equal_in',
            'not_equal_to',
            'less_than',
            'greater_than',
            'between',
            'not_between',
            'contains',
        ]);
    }

    /**
     * Get fields request
     * @return array
     */
    protected function fields(): array
    {
        return $this->request->all();
    }


    /**
     * Get order params for builder
     * @return array|null[]
     */
    private function parseOrderParams()
    {
        $column = Arr::get($this->fields(), 'sort');
        if (empty($column)) {
            return [null, null];
        }
        $direction = Arr::get($this->fields(), 'direction', 'asc');
        return [$column, $direction];
    }

    /**
     * Explodes relation and column params
     * @param string $column
     * @return array|string[]
     * @throws \Exception
     */
    private function explodeRelationColumn(string $column)
    {
        if (strpos($column, '.')) {
            $relationToColumn = explode('.', $column);
            if (count($relationToColumn) !== 2) {
                throw new \Exception('Invalid sort parameters');
            }
            return $relationToColumn;
        }

        return [];
    }

    private function queryJoinBuilder($relation)
    {
        $relatedTable = $relation->getRelated()->getTable();
        $parentTable = $relation->getParent()->getTable();
        if ($relation instanceof HasOne) {
            $relatedPrimaryKey = $relation->getQualifiedForeignKeyName();
            $parentPrimaryKey = $relation->getQualifiedParentKeyName();
        } elseif ($relation instanceof HasMany) {
            $relatedPrimaryKey = $relation->getQualifiedForeignKeyName();
            $parentPrimaryKey = $relation->getQualifiedParentKeyName();

        } elseif ($relation instanceof BelongsTo) {
            $relatedPrimaryKey = $relation->getQualifiedOwnerKeyName();
            $parentPrimaryKey = $relation->getQualifiedForeignKeyName();
        } else {
            throw new \Exception();
        }
        $this->formattingJoinQuery($parentTable, $relatedTable, $parentPrimaryKey, $relatedPrimaryKey, $relation instanceof HasMany);
    }

    private function formattingJoinQuery($parentTable, $relatedTable, $parentPrimaryKey, $relatedPrimaryKey, $isManyItems = false)
    {
        $this->builder->join($relatedTable, $parentPrimaryKey, '=', $relatedPrimaryKey);

        if ($isManyItems) {
            $this->builder->groupBy($parentPrimaryKey);
        }

    }
}