<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ProfileFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    //プロフィール変更画面、初期値表示確認
    public function testProfileInformationDisplay()
    {
        $response = $this->actingAs($this->user)->get('/mypage/profile');
        $response->assertStatus(200);

        $iconPath = asset('storage/' . $this->user->icon);
        $response->assertSee($iconPath);
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->post_code);
        $response->assertSee($this->user->address);
        $response->assertSee($this->user->building);
    }
}
