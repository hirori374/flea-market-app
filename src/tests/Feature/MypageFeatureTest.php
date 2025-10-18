<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class MypageFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    //マイページ画面、出品した商品の表示確認
    public function testMyInformationAndSellItemDisplay()
    {
        $sellItem = Item::factory()->create([
            'name' => 'sellItem',
            'seller_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->get('/mypage?page=sell');
        $response->assertStatus(200);

        $iconPath = asset('storage/' . $this->user->icon);
        $response->assertSee($iconPath);
        $response->assertSee($this->user->name);
        $response->assertSee($sellItem->name);
    }
    //マイページ画面、購入した商品の表示確認
    public function testMyInformationAndBuyItemDisplay()
    {
        $buyItem = Item::factory()->create([
            'name' => 'buyItem',
        ]);
        $purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'item_id' => $buyItem->id,
            'pay_status' => 'paid',
        ]);

        $response = $this->actingAs($this->user)->get('/mypage?page=buy');
        $response->assertStatus(200);

        $iconPath = asset('storage/' . $this->user->icon);
        $response->assertSee($iconPath);
        $response->assertSee($this->user->name);
        $response->assertSee($buyItem->name);
    }
}
