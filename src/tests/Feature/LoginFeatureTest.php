<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginFeatureTest extends TestCase
{
    use RefreshDatabase;

    //ユーザーログイン成功、商品一覧画面へ遷移
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    //認証情報と一致しないパスワードでログイン失敗
    public function testInvalidPasswordFails()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password111',
        ]);

        $this->assertEquals(
            ['ログイン情報が登録されていません'],
            $response->getSession()->get('errors')->get('email')
        );
        $this->assertGuest();
    }
}
