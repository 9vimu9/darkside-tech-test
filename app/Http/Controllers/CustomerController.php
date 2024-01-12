<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomerCannotBeRemovedException;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index(CustomerRepositoryInterface $customerRepository)
    {
        return CustomerResource::collection($customerRepository->all());
    }

    public function store(CustomerRepositoryInterface $customerRepository, CustomerStoreRequest $request): JsonResponse
    {
        $customerResource = new CustomerResource($customerRepository->create($request->all()));
        return $customerResource->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerRepositoryInterface $customerRepository, int $id): CustomerResource
    {
        return new CustomerResource($customerRepository->findById($id));
    }

    public function update(CustomerRepositoryInterface $customerRepository, CustomerUpdateRequest $request, int $id): CustomerResource
    {
        return new CustomerResource($customerRepository->updateById($id, $request->all()));
    }

    public function destroy(CustomerRepositoryInterface $customerRepository, int $id)
    {
        try {
            $customerRepository->destroyById($id);
            return \response()->noContent();
        } catch (CustomerCannotBeRemovedException $exception) {
            Log::debug("Customer cannot be removed", ['customer_id' => $id]);
            return \response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
