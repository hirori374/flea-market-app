<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    //ログイン済みユーザーコメント投稿、コメント数増加
    public function testCommentPost()
    {
        $this->withoutMiddleware();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        $response =  $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);

        $response = $this->post('/comment/'. $item->id, [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'testComment',
        ]);
        $response->assertRedirect('/item/'. $item->id);
        $this->assertDatabaseHas('comments', [
            'content' => 'testComment',
        ]);
        $commentCount = $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
        ])->count();
        $this->assertEquals($commentCount, 1);
    }
    //未ログインユーザーコメント投稿失敗
    public function testCommentPostFail()
    {
        $item = Item::factory()->create();
        $response = $this->post('/comment/'. $item->id, [
            'item_id' => $item->id,
            'content' => 'testComment',
        ]);
        $response->assertRedirect('/login');
        $response->assertStatus(302);
        $this->assertDatabaseMissing('comments', [
            'content' => 'testComment',
        ]);
    }
}
