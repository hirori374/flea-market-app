<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    //認証済みユーザー商品購入
    public function testPurchaseItem()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post('/purchase/'.$item->id, [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'delivery_post_code' => '123-4567',
            'delivery_address' => '東京都渋谷区12-34',
            'pay_method' => 'カード払い',
        ]);
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }
    //商品一覧で購入商品Sold表示
    public function testPurchaseItemsDisplaySold()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post('/purchase/'.$item->id, [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'delivery_post_code' => '123-4567',
            'delivery_address' => '東京都渋谷区12-34',
            'pay_method' => 'カード払い',
        ]);

        $response = $this->get('/');
        $html = $response->getContent();

        preg_match('/<a href="\/item\/'.$item->id.'" class="item__wrapper">.*?<\/a>/s', $html, $matches);
        $soldItemHtml = $matches[0] ?? '';

        $this->assertStringContainsString(
            '<span class="item__sold">Sold</span>',
            $soldItemHtml
        );
    }
    //プロフィール/購入した商品で購入商品表示
    public function testPurchaseItemIsPurchasedItems()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post('/purchase/'.$item->id, [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'delivery_post_code' => '123-4567',
            'delivery_address' => '東京都渋谷区12-34',
            'pay_method' => 'カード払い',
        ]);

        $response = $this->get('/mypage?page=buy');
        $response->assertSee($item->name);
    }
}
