<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ], $overrides);
    }

    public function test_name_is_required(): void
    {
        $response = $this->post('/register', $this->validPayload(['name' => '']));

        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->post('/register', $this->validPayload(['email' => '']));

        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->post('/register', $this->validPayload([
            'password' => '',
            'password_confirmation' => '',
        ]));

        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_password_must_be_at_least_8_characters(): void
    {
        $response = $this->post('/register', $this->validPayload([
            'password' => 'abc1234',
            'password_confirmation' => 'abc1234',
        ]));

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post('/register', $this->validPayload([
            'password' => 'password123',
            'password_confirmation' => 'password999',
        ]));

        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);
    }

    public function test_valid_registration_creates_user_and_redirects_to_email_verification(): void
    {
        $response = $this->post('/register', $this->validPayload());

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/email/verify');
    }
}
