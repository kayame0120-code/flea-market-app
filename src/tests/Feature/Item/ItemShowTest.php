<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_information_is_available(): void
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 12000,
            'description' => 'テスト説明文',
            'condition' => 1,
            'img_url' => 'items/test.jpg',
        ]);
        $commenter = User::factory()->create(['name' => 'コメント太郎']);
        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commenter->id,
            'content' => 'いい商品ですね',
        ]);
        Like::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertViewHas('item', function ($viewItem) use ($item) {
            return $viewItem->id === $item->id
                && $viewItem->name === 'テスト商品'
                && $viewItem->brand === 'テストブランド'
                && (int) $viewItem->price === 12000
                && $viewItem->description === 'テスト説明文'
                && $viewItem->likes->count() === 1
                && $viewItem->comments->count() === 1
                && $viewItem->comments->first()->user->name === 'コメント太郎'
                && $viewItem->comments->first()->content === 'いい商品ですね';
        });
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥12,000');
        $response->assertSee('テスト説明文');
        $response->assertSee('良好');
        $response->assertSee('コメント太郎');
        $response->assertSee('いい商品ですね');
        $response->assertSee('storage/items/test.jpg', false);
    }

    public function test_multiple_selected_categories_are_shown(): void
    {
        $item = Item::factory()->create();
        $categoryA = Category::create(['name' => 'メンズ']);
        $categoryB = Category::create(['name' => 'ファッション']);
        $item->categories()->attach([$categoryA->id, $categoryB->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertViewHas('item', function ($viewItem) {
            $names = $viewItem->categories->pluck('name')->all();
            return in_array('メンズ', $names) && in_array('ファッション', $names);
        });
        $response->assertSee('メンズ');
        $response->assertSee('ファッション');
    }
}
