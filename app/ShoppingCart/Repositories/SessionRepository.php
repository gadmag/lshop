<?php


namespace App\ShoppingCart\Repositories;


use App\ShoppingCart\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Session;
use Countable;

class SessionRepository implements RepositoryInterface, Countable
{


    public function set($key, $value)
    {
        Session::put($key, $value);
    }

    public function get($key)
    {
        if ($this->exists($key)) {
            return Session::get($key);
        }
        return null;
    }

    public function exists($key)
    {
        return Session::has($key);
    }

    public function all()
    {
        return Session::all();
    }

    public function unset($key)
    {
        if ($this->exists($key)) {
            Session::forget($key);
        }
    }


    public function count()
    {
        return count($this->all());
    }
}