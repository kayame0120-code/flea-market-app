<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_match_search_by_name(): void
    {
        $matching = Item::factory()->create(['name' => '腕時計ロレックス']);
        $notMatching = Item::factory()->create(['name' => 'スニーカー']);

        $response = $this->get('/?keyword=' . urlencode('腕時計'));

        $response->assertViewHas('items', function ($items) use ($matching, $notMatching) {
            return $items->contains('id', $matching->id)
                && !$items->contains('id', $notMatching->id);
        });
    }

    public function test_search_keyword_is_kept_while_filtering_mylist(): void
    {
        $user = User::factory()->create();
        $likedMatching = Item::factory()->create(['name' => '腕時計ロレックス']);
        $likedNotMatching = Item::factory()->create(['name' => 'スニーカー']);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $likedMatching->id]);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $likedNotMatching->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=' . urlencode('腕時計'));

        $response->assertViewHas('items', function ($items) use ($likedMatching, $likedNotMatching) {
            return $items->contains('id', $likedMatching->id)
                && !$items->contains('id', $likedNotMatching->id);
        });
    }
}
