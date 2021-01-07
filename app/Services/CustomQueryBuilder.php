<?php


namespace App\Services;


class CustomQueryBuilder
{

    public function apply($query, $data)
    {

        if (isset($data['f'])) {
            foreach ($data['f'] as $filter) {
                $filter['match'] = isset($filter['filter_match']) ? $$filter['filter_match'] : 'end';
                $this->makeFilter($query, $filter);
            }
        }

        return $query;
    }

    protected function makeFilter($query, $filter)
    {
        if (strpos($filter['field'], '.') !== false) {
            list($relation, $filter['field']) = explode('.', $filter['field']);
            $filter['match'] = 'end';

            if ($filter['field'] == 'count') {

            } else {
                $query->whereHas($relation, function ($q) use ($filter) {
                    $this->{camel_case($filter['operator'])}($filter, $q);
                });
            }

        } else {
            $this->{camel_case($filter['operator'])}($filter, $query);
        }
    }

    public function equalTo($filter, $query)
    {
        return $query->where($filter['field'], '=', $filter['query_1']);
    }

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
}