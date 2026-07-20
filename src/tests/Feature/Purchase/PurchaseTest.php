<?php

namespace Tests\Feature\Purchase;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_pressing_purchase_button_completes_the_purchase(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 1,
        ]);
        $response->assertRedirect('/');
    }

    public function test_purchased_item_is_marked_as_sold_on_item_list(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $response = $this->get('/');
        $response->assertSee('Sold');
    }

    public function test_purchased_item_appears_in_profile_purchase_list(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertViewHas('items', function ($items) use ($item) {
            return $items->contains('id', $item->id);
        });
    }
}
