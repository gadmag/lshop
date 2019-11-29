<?php


namespace App\Http\ViewComposers;

use App\Services\Block\BlockService;
use Illuminate\View\View;

class BlocksComposer
{

    protected $block;

    public function __construct(BlockService $blockQueries)
    {
        $this->block = $blockQueries;
    }

    public function compose(View $view)
    {
        return $view->with('blocks', $this->block->getAll());
    }
}