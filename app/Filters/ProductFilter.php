<?php


namespace App\Filters;



class ProductFilter extends QueryFilter
{
    protected $allowedFilters = [
         'material', 'color', 'productOptions.price', 'productOptions.color', 'productOptions.color_stone', 'catalogs.name'
    ];

    protected $orderable = [
        'title', 'productOptions.price', 'created_at', 'weight', 'total_selling'
    ];





}