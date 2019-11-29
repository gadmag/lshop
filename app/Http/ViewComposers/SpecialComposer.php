<?php


namespace App\Http\ViewComposers;

use App\Services\Product\BaseQueries;
use Illuminate\View\View;

class SpecialComposer
{

    protected $query;

    public function __construct(BaseQueries $query)
    {
        $this->query = $query;
    }

    public function compose(View $view)
    {
        return $view->with('specials', $this->query->getSpecialProducts());
    }
}