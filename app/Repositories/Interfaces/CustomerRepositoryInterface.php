<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface CustomerRepositoryInterface
{
    public function all(): ResourceCollection;

    public function create(array $inputs): JsonResource;

    public function updateById(int $id, array $inputs): JsonResource;

    public function findById(int $id): JsonResource;

    public function destroyById(int $id): bool;
}
