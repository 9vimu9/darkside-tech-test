<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerController extends Controller
{
    public function index(CustomerRepositoryInterface $customerRepository)
    {
        return $customerRepository->all();
    }

    public function store(CustomerRepositoryInterface $customerRepository, CustomerStoreRequest $request)
    {
        return $customerRepository->create($request->all());
    }

    public function show(CustomerRepositoryInterface $customerRepository, int $id)
    {
        return $customerRepository->findById($id);
    }

    public function update(CustomerRepositoryInterface $customerRepository, CustomerUpdateRequest $request, int $id)
    {
        return $customerRepository->updateById($id, $request->all());
    }

    public function destroy(CustomerRepositoryInterface $customerRepository, int $id)
    {
        if ($customerRepository->destroyById($id)) {
            return [];
        }
        throw new \Exception();
    }
}
