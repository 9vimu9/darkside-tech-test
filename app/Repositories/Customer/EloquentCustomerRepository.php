<?php

namespace App\Repositories\Customer;

use App\DTOs\CustomerDto;
use App\Exceptions\CustomerCannotBeRemovedException;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use app\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    public function all(): array
    {
        $customerArray = [];
        $customers = Customer::all();
        foreach ($customers as $customer) {
            $customerArray[] = $this->toCustomerDto($customer);
        }

        return $customerArray;
    }

    public function toCustomerDto(object $customer): CustomerDto
    {
        return new CustomerDto($customer->id,
            $customer->name,
            $customer->email,
            $customer->telephone_number,
            $customer->address
        );
    }

    public function create(array $inputs): CustomerDto
    {
        return $this->toCustomerDto(Customer::create($inputs));
    }

    public function findById(int $id): CustomerDto
    {
        return $this->toCustomerDto(Customer::findOrFail($id));
    }

    public function destroyById(int $id): bool
    {
        if (! Customer::findOrFail($id)->delete()) {
            throw new CustomerCannotBeRemovedException();
        }

        return true;
    }

    public function updateById(int $id, array $inputs): CustomerDto
    {
        $customer = Customer::findOrFail($id);
        $customer->update($inputs);

        return $this->toCustomerDto($customer);
    }
}
