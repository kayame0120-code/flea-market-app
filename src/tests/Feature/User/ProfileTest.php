<?php

namespace Tests\Feature\User;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_shows_required_user_and_item_information(): void
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'img_url' => 'profiles/test.jpg',
        ]);
        $ownItem = Item::factory()->create(['user_id' => $user->id]);
        $purchasedItem = Item::factory()->create();
        Purchase::factory()->create(['user_id' => $user->id, 'item_id' => $purchasedItem->id]);

        $sellResponse = $this->actingAs($user)->get('/mypage');
        $sellResponse->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id
                && $viewUser->name === 'テスト太郎'
                && $viewUser->img_url === 'profiles/test.jpg';
        });
        $sellResponse->assertViewHas('items', function ($items) use ($ownItem) {
            return $items->contains('id', $ownItem->id);
        });

        $buyResponse = $this->actingAs($user)->get('/mypage?page=buy');
        $buyResponse->assertViewHas('items', function ($items) use ($purchasedItem) {
            return $items->contains('id', $purchasedItem->id);
        });
    }
}
