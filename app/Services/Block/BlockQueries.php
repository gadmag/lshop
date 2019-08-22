<?php


namespace App\Services\Block;

use App\Block;
use App\Http\Requests\Request;
use Illuminate\Support\Collection;

class BlockQueries implements BlockService
{


    public function getAll(): Collection

    {
        return Block::published()->weight()->get();
    }

    public function create(array $params): void
    {
        Block::create($params);
    }

    public function update(array $params, int $id): Block
    {
        $block = Block::findOrFail($id);
        $block->update($params);
        return $block;
    }

    public function delete(int $id): string
    {
        $block = Block::findOrFail($id);
        $blockTitle = $block->title;
        $block->delete();
        return $blockTitle;
    }
}