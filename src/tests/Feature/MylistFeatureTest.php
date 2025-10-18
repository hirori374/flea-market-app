<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class MylistFeatureTest extends TestCase
{
    use RefreshDatabase;

    //マイリスト商品表示
    public function testMylistItems()
    {
        $user = User::factory()->create();
        $favoriteItem = Item::factory()->create(['name' => 'お気に入り商品']);
        $otherItem = Item::factory()->create(['name' => 'その他商品']);
        $user->favoriteItems()->attach($favoriteItem->id);
        $this->assertDatabaseHas('item_user_favorites', [
            'user_id' => $user->id,
            'item_id' => $favoriteItem->id,
        ]);
        $response =  $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertSeeText('お気に入り商品');
        $response->assertDontSeeText('その他商品');
    }
    //売り切れ商品表示（マイリストページ）
    public function testMylistPurchasedItems()
    {
        $user = User::factory()->create();
        $soldItem = Item::factory()->create(['name' => '売り切れ商品']);
        $availableItem = Item::factory()->create(['name' => '販売中商品']);
        $user->favoriteItems()->attach($soldItem->id);
        $user->favoriteItems()->attach($availableItem->id);

        Purchase::factory()->create([
            'item_id' => $soldItem->id,
        ]);

        $response =  $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $html = $response->getContent();

        //$soldItemのaタグ内に<span class="item__sold">Sold</span>が含まれることを確認
        preg_match('/<a href="\/item\/'.$soldItem->id.'" class="item__wrapper">.*?<\/a>/s', $html, $matches);
        $soldItemHtml = $matches[0] ?? '';

        $this->assertStringContainsString(
            '<span class="item__sold">Sold</span>',
            $soldItemHtml
        );

        //$availableItemのaタグ内に<span class="item__sold">Sold</span>が含まれないことを確認
        preg_match('/<a href="\/item\/'.$availableItem->id.'" class="item__wrapper">.*?<\/a>/s', $html, $matches);
        $availableItemHtml = $matches[0] ?? '';

        $this->assertStringNotContainsString('<span class="item__sold">Sold</span>', $availableItemHtml);
    }
    //未認証ユーザーのマイリスト商品表示なし
    public function testGestMylistItems()
    {
        $items = Item::factory()->count(3)->create([
            'name' => '商品',
        ]);
        $response =  $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSeeText('商品');
    }
}
