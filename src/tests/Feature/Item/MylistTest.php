<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_shown(): void
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create();
        $otherItem = Item::factory()->create();
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $likedItem->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertViewHas('items', function ($items) use ($likedItem, $otherItem) {
            return $items->contains('id', $likedItem->id)
                && !$items->contains('id', $otherItem->id);
        });
    }

    public function test_sold_liked_items_are_marked_as_sold(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);
        Purchase::factory()->create(['item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertViewHas('items', function ($items) use ($item) {
            $found = $items->firstWhere('id', $item->id);
            return $found && $found->isSold();
        });
        $response->assertSee('Sold');
    }

    public function test_guest_sees_nothing_on_mylist(): void
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/?tab=mylist');

        $response->assertViewHas('items', function ($items) {
            return $items->count() === 0;
        });
    }
}
