<?php

namespace Tests\Unit\Models\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\ProductVariation;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_hash_password_when_creating()
    {
        $user = factory(User::class)->create([
         'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }

    public function test_it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

       $user->cart()->attach(
        factory(ProductVariation::class)->create()
       ); 
       $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }
    public function test_it_has_a_quantity_for_each_cart_product()
    {
        $user = factory(User::class)->create();

       $user->cart()->attach(
          factory(ProductVariation::class)->create(),[
           'quantity' => $quantity = 5
          ]
       ); 
       $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }

    public function test_it_has_many_addresses()
    {
        $user = factory(User::class)->create();

       $user->addresses()->save(
        factory(Address::class)->make()
       ); 
       $this->assertInstanceOf(Address::class, $user->addresses->first());
    }

    public function test_it_has_many_orders()
    {
        $user = factory(User::class)->create();

        factory(Order::class)->create([
          'user_id' => $user->id
        ]);

        $this->assertInstanceOf(Order::class, $user->orders->first());
    }

    public function test_it_has_many_payment_methods()
    {
        $user = factory(User::class)->create();

        factory(PaymentMethod::class)->create([
          'user_id' => $user->id
        ]);

        $this->assertInstanceOf(PaymentMethod::class, $user->paymentMethods->first());
    }
}
