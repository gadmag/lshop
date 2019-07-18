<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Block;
use Illuminate\Support\Facades\DB;

class BlocksComposer
{

    protected $block;

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function compose(View $view)
    {
        return $view->with('blocks', $this->block->published()->weight());
    }
}