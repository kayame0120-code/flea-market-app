<?php

namespace Tests\Feature\Purchase;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_updated_shipping_address_is_reflected_on_purchase_screen(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/address/' . $item->id, [
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区テスト1-2-3',
            'shipping_building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/purchase/' . $item->id);

        $response->assertViewHas('shippingAddress', function ($shippingAddress) {
            return $shippingAddress['postal_code'] === '123-4567'
                && $shippingAddress['address'] === '東京都渋谷区テスト1-2-3'
                && $shippingAddress['building'] === 'テストビル101';
        });
    }

    public function test_purchase_is_linked_to_the_updated_shipping_address(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/address/' . $item->id, [
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区テスト1-2-3',
            'shipping_building' => 'テストビル101',
        ]);

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区テスト1-2-3',
            'shipping_building' => 'テストビル101',
        ]);
    }
}
