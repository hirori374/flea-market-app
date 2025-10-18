<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }
    
    //会員登録、データベースへ保存、メール認証誘導画面へ遷移
    public function testUserRegister()
    {
        $response = $this->post('/register', [
            'name' => 'Taro',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
    //無効なメールアドレスで会員登録失敗
    public function testInvalidEmailFails()
    {
        $response = $this->post('/register', [
            'name' => 'Taro',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
    //メール認証誘導画面表示、メール認証サイトへ遷移
    public function testEmailAuthentication()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user);

        $response = $this->get('/email/verify');
        $response->assertStatus(200);
        $response->assertViewIs('auth.verify_email');
    }
    //メール認証完了、プロフィール設定画面へ遷移
    public function testEmailAuthenticationComplete()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/email/verify/'.$user->id.'/'.sha1($user->email));
        $response->assertRedirect('/mypage/profile');
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
