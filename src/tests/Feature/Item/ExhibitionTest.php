<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_register_a_new_item(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $categoryA = Category::create(['name' => 'メンズ']);
        $categoryB = Category::create(['name' => 'ファッション']);

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト腕時計',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文',
            'price' => 15000,
            'condition' => 1,
            'img_url' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'category_id' => [$categoryA->id, $categoryB->id],
        ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト腕時計',
            'brand' => 'テストブランド',
            'description' => 'テスト説明文',
            'price' => 15000,
            'condition' => 1,
        ]);

        $item = Item::where('name', 'テスト腕時計')->firstOrFail();
        $this->assertEqualsCanonicalizing(
            [$categoryA->id, $categoryB->id],
            $item->categories->pluck('id')->all()
        );

        $response->assertRedirect('/');
    }
}
