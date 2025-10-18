<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    //ログアウト処理、ログイン画面へリダイレクト
    public function testUserLogout()
    {
        $user = User::factory()->create();
        $response =  $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);

        $response = $this->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
