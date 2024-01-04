<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A feature test to get customer data based on customer ID
     */
    public function test_get_customer_by_id()
    {
        $customer = Customer::factory()->create();

        return $this->get('/api/customers/' . $customer->id)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'telephone_number',
                        'address',
                    ],
                ]
            );
    }

    /**
     * A feature test to get all customers
     */
    public function test_get_all_customers()
    {
        Customer::factory()->times(4)->create();

        return $this->get('/api/customers')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => ['*' => [
                        'id',
                        'name',
                        'email',
                        'telephone_number',
                        'address',
                    ],
                    ]]
            );
    }

    /**
     * A feature test to save customer
     */
    public function test_store_customer()
    {
        $customer = Customer::factory()->make();
        $customerArray = $customer->toArray();
        $customerArray['id'] = Customer::latest()->first()->id + 1;

        return $this->post('/api/customers', $customerArray)
            ->assertStatus(201)
            ->assertExactJson(['data' => $customerArray]);
    }
}
