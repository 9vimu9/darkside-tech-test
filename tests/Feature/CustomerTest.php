<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A feature test to get customer data based on customer ID
     */
    public function test_get_customer_by_id()
    {
        $customer = Customer::factory()->create();

        return $this->get('/api/customers/'.$customer->id)
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

        return $this->post('/api/customers', $customerArray)
            ->assertStatus(201)
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

    public function test_store_when_input_name_is_not_avaialable()
    {
        $customerArray = [
            'email'=>time().'test@mail.com',
            'telephone_number'=>'0123456',
            'address'=>'test address'
        ];

        return $this->post('/api/customers', $customerArray,['accept'=>'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(
                ['message', 'errors']
            );
    }

    public function test_store_when_input_name_is_small()
    {
        $customerArray = [
            'name'=>'s1',
            'email'=>time().'test@mail.com',
            'telephone_number'=>'01234456',
            'address'=>'test address'
        ];

        return $this->post('/api/customers', $customerArray,['accept'=>'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(
                ['message', 'errors']
            );
    }

    /**
     * A feature test to update customer
     */
    public function test_update_customer()
    {
        $customer = Customer::factory()->create();
        $customerArray = [
            'id' => $customer->id,
            'name' => 'TEST NAME',
            'email' => time().'test@mail.com',
            'address' => 'test address',
            'telephone_number' => '123456',
        ];

        return $this->put('/api/customers/'.$customer->id, $customerArray)
            ->assertStatus(200)
            ->assertExactJson(['data' => $customerArray]);
    }

    /**
     * A feature test to remove customer based on customer ID
     */
    public function test_delete_customer_by_id()
    {
        $customer = Customer::factory()->create();

        return $this->delete('/api/customers/'.$customer->id)
            ->assertStatus(200)
            ->assertExactJson([]);
    }
}
