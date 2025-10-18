<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class FavoriteFeatureTest extends TestCase
{
    use RefreshDatabase;

    //認証済みユーザーお気に入り登録、いいね数増加
    public function testFavoriteItemStore()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get('/item/'.$item->id. '/favorite');
        $response->assertRedirect('/item/'. $item->id);
        $response->assertStatus(302);

        $this->assertDatabaseHas('item_user_favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
        $favoritesCount = $this->assertDatabaseHas('item_user_favorites', [
            'item_id' => $item->id,
        ])->count();
        $this->assertEquals($favoritesCount, 1);
    }
    //認証済みユーザーお気に入り登録、アイコン色変化
    public function testFavoriteItemIconChange()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->followingRedirects()->get('/item/'.$item->id. '/favorite');
        $html = $response->getContent();

        $this->assertStringContainsString('class="icon-favorite--active"', $html);

    }
    //認証済みユーザーお気に入り解除、いいね数減少
    public function testFavoriteItemDelete()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->favoriteItems()->attach($item->id);

        $response = $this->actingAs($user)->get('/item/'.$item->id. '/favorite/delete');
        $response->assertRedirect('/item/'. $item->id);
        $response->assertStatus(302);

        $this->assertDatabaseMissing('item_user_favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseCount('item_user_favorites',0);
    }
}
