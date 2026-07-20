<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_returned_for_guest(): void
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertViewHas('items', function ($items) {
            return $items->count() === 3;
        });
    }

    public function test_sold_items_are_marked_as_sold(): void
    {
        $item = Item::factory()->create();
        Purchase::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/');

        $response->assertViewHas('items', function ($items) use ($item) {
            $found = $items->firstWhere('id', $item->id);
            return $found && $found->isSold();
        });
        $response->assertSee('Sold');
    }

    public function test_own_items_are_excluded_for_logged_in_user(): void
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create(['user_id' => $user->id]);
        $otherItem = Item::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertViewHas('items', function ($items) use ($ownItem, $otherItem) {
            return !$items->contains('id', $ownItem->id)
                && $items->contains('id', $otherItem->id);
        });
    }
}
