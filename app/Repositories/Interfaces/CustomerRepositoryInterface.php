<?php

namespace App\Repositories\Interfaces;

use App\DTOs\CustomerDto;

interface CustomerRepositoryInterface
{
    public function all(): array;

    public function create(array $inputs): CustomerDto;

    public function updateById(int $id, array $inputs): CustomerDto;

    public function findById(int $id): CustomerDto;

    public function destroyById(int $id): bool;

    public function toCustomerDto(Object $customer):CustomerDto;
}
