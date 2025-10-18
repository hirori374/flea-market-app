<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class SearchFeatureTest extends TestCase
{
    use RefreshDatabase;

    //商品検索
    public function testSearchItems()
    {
        $user = User::factory()->create();
        $names = ['testItem1', 'testItem2', 'テスト商品3'];
        $items = collect($names)->map(function ($name) {
            return Item::factory()->create(['name' => $name]);
        });

        $response = $this->get('/?keyword=testItem');
        $response->assertStatus(200);
        $response->assertSeeText('testItem1');
        $response->assertSeeText('testItem2');
        $response->assertDontSeeText('テスト商品3');
    }
    //商品検索、マイリストページでも検索結果維持
    public function testSearchItemsInMylist()
    {
        $user = User::factory()->create();
        $names = ['testItem1', 'testItem2', 'テスト商品3', 'testItem4'];
        $items = collect($names)->map(function ($name) {
            return Item::factory()->create(['name' => $name]);
        });
        //商品名testItem1、testItem2、テスト商品3をお気に入り登録
        $user->favoriteItems()->attach($items[0]->id);
        $user->favoriteItems()->attach($items[1]->id);
        $user->favoriteItems()->attach($items[2]->id);

        //商品名に'testItem'が含まれるかつお気に入り登録されている商品の表示
        $this->withSession(['keyword' => 'testItem']);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSeeText('testItem1');
        $response->assertSeeText('testItem2');
        $response->assertDontSeeText('テスト商品3');
        $response->assertDontSeeText('testItem4');
    }
}
