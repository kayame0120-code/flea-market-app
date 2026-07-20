<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_submit_comment(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'content' => 'いい商品ですね',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'いい商品ですね',
        ]);
    }

    public function test_guest_cannot_submit_comment(): void
    {
        $item = Item::factory()->create();

        $response = $this->post('/item/' . $item->id . '/comment', [
            'content' => 'いい商品ですね',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'いい商品ですね',
        ]);
    }

    public function test_empty_comment_shows_validation_error(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_comment_over_255_characters_shows_validation_error(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}
