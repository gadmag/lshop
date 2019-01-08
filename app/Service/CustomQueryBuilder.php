<?php


namespace App\Service;


class CustomQueryBuilder
{

    public function apply($query, $data)
    {

        if (isset($data['f'])){
            foreach ($data['f'] as $filter) {
                $filter['match'] = isset($filter['filter_match'])? $ $data['filter_match']: 'end';
                $this->makeFilter($query, $filter);
            }
        }

        return $query;
    }

    protected function makeFilter($query, $filter)
    {
        $this->{camel_case($filter['operator'])}($filter, $query);
    }

    public function equalTo($filter, $query)
    {
        return $query->where($filter['field'], '=', $filter['query_1']);
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
        return $query->whereBetween($filter['field'],[
            $filter['query_1'],
            $filter['query_2']
        ]);
    }

    public function notBetween($filter, $query)
    {
        return $query->whereNotBetween($filter['field'],[
            $filter['query_1'],
            $filter['query_2']
        ]);
    }
}