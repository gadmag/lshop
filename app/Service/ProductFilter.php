<?php


namespace App\Service;

use Illuminate\Validation\ValidationException;

trait ProductFilter
{


    public function scopeAdvancedFilter($query)
    {

        return $this->process($query, request()->all())
            ->orderBy(
                request('order_by', 'created_at'),
                request('order_direction', 'desc')
            )
            ->paginate(request('limit', 12));
    }

    public function process($query, $data)
    {
        $validation = validator()->make($data, [
            //orders
            'order_by' => 'sometimes|required|in:' . $this->orderableColumns(),
            'order_direction' => 'sometimes|required|in:asc,desc',
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
            return dd($validation->messages()->all());

            throw new ValidationException;
        }

        return (new CustomQueryBuilder())->apply($query, $data);
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
            'not_equal_to',
            'less_than',
            'greater_than',
            'between',
            'not_between',
        ]);
    }
}