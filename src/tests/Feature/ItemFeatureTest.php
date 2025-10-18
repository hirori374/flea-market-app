<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ItemFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    //全商品表示
    public function testAllItems()
    {
        $items = Item::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }
    //売り切れ商品表示
    public function testPurchasedItemsSoldDisplay()
    {
        $soldItem = Item::factory()->create(['name' => '売り切れ商品']);
        $availableItem = Item::factory()->create(['name' => '販売中商品']);

        Purchase::factory()->create([
            'item_id' => $soldItem->id,
        ]);

        $response = $this->get('/');
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
    //自分の出品商品非表示
    public function testUserSellItems()
    {
        $user = User::factory()->create();

        $sellItem = Item::factory()->create(['name' => '自分の出品商品', 'seller_id' => $user->id]);
        $otherItem = Item::factory()->create(['name' => '他の人の出品商品', 'seller_id' => $user->id + 1]);

        $response =  $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText('自分の出品商品');
        $response->assertSeeText('他の人の出品商品');
    }
}