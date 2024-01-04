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


}
