<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_pressing_like_icon_registers_like_and_increases_count(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/item/' . $item->id . '/like');

        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->get('/item/' . $item->id);
        $response->assertViewHas('item', fn($viewItem) => $viewItem->likes->count() === 1);
    }

    public function test_liked_state_is_reflected_for_the_user(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/item/' . $item->id . '/like');

        $this->assertTrue($item->fresh()->isLikedBy($user));
    }

    public function test_pressing_like_icon_again_removes_like_and_decreases_count(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $this->actingAs($user)->post('/item/' . $item->id . '/like');

        $this->actingAs($user)->delete('/item/' . $item->id . '/like');

        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->get('/item/' . $item->id);
        $response->assertViewHas('item', fn($viewItem) => $viewItem->likes->count() === 0);
    }
}
