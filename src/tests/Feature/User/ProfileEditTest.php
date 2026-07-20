<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_screen_shows_current_values_as_defaults(): void
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'img_url' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト1-2-3',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertViewHas('user', function ($viewUser) {
            return $viewUser->name === 'テスト太郎'
                && $viewUser->img_url === 'profiles/test.jpg'
                && $viewUser->postal_code === '123-4567'
                && $viewUser->address === '東京都渋谷区テスト1-2-3';
        });
        $response->assertSee('value="テスト太郎"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都渋谷区テスト1-2-3"', false);
    }
}
