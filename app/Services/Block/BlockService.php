<?php


namespace App\Services\Block;

use App\Block;
use Illuminate\Support\Collection;

interface BlockService
{

    public function getAll():Collection;
    public function create(array $params): void;
    public function update(array $params, int $id):Block;
    public function delete(int $id): string;

}