<?php

namespace App\Repositories\Customer;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use app\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    public function all(): ResourceCollection
    {
        return CustomerResource::collection(Customer::all());
    }

    public function create(array $inputs): JsonResource
    {
        return new CustomerResource(
            Customer::create($inputs)
        );
    }

    public function destroyById(int $id): bool
    {
        return Customer::findOrFail($id)->delete();
    }

    public function updateById(int $id, array $inputs): JsonResource
    {
        $customer = Customer::findOrFail($id);
        $customer->update($inputs);
        return new CustomerResource($customer);
    }

    public function findById(int $id): JsonResource
    {
        return new CustomerResource(
            Customer::findOrFail($id)
        );
    }
}
