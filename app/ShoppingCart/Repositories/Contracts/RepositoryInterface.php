<?php


namespace App\ShoppingCart\Repositories\Contracts;


interface RepositoryInterface
{
    public function set($key, $value);
    public function get($id);
    public function unset($id);
}