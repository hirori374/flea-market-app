<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;

class DetailFeatureTest extends TestCase
{
    use RefreshDatabase;

    //商品詳細ページ表示
    public function testItemDetail()
    {
        //商品、カテゴリー、お気に入り登録ユーザー、コメント投稿ユーザー、コメント作成、いいね数、コメント数
        $item = Item::factory()->create();
        $category = Category::factory()->create();
        $item->categories()->attach($category->id);
        $favoritesUser = User::factory()->create();
        $favoritesUser->favoriteItems()->attach($item->id);
        $favoritesCount = $item->favoritesUsers()->count();
        $commentUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'content' => 'testComment'
        ]);
        $commentsCount = $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
        ])->count();

        $response = $this->get('/item/'.$item->id);
        $response->assertStatus(200);

        //商品データの表示確認
        $response->assertSee(number_format($item->price));
        foreach ($item->getAttributes() as $key => $value) {
            if (in_array($key, ['price', 'created_at', 'updated_at'])) {
                continue;
            }
            if (is_scalar($value)) {
                $response->assertSee(e((string)$value), false);
            }
        }
        $imagePath = Str::startsWith($item->image, ['http', '/storage'])? $item->image: asset('storage/' . $item->image);
        $response->assertSee($imagePath);
        //カテゴリー表示確認
        $response->assertSee($category->name);
        //いいね数・コメント数表示確認
        $response->assertSee((string)$favoritesCount);
        $response->assertSee((string)$commentsCount);
        //コメント内容・コメント投稿ユーザー情報の表示確認
        $response->assertSee($comment->content);$response->assertSee($commentUser->name);$iconPath = asset('storage/' . $commentUser->icon);
        $response->assertSee($iconPath);
    }
    //複数カテゴリ表示
    public function testItemDetailMultipleCategories()
    {
        $item = Item::factory()->create();
        $categories = Category::factory()->count(2)->create();
        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get('/item/'.$item->id);
        $response->assertStatus(200);

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
