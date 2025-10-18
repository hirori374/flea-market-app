<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class SellFeatureTest extends TestCase
{
    use RefreshDatabase;

    //商品出品、データ保存の確認
    public function testSellItem()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::factory()->create(['id' => 1]);

        $image = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'testItem',
            'price' => 5000,
            'condition' => '良好',
            'description' => 'testDescription',
            'seller_id' => $user->id,
            'category' => [$category->id],
            'image' => $image,
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('items', ['name' => 'testItem']);
        $this->assertDatabaseHas('item_category', [
            'item_id' => Item::first()->id,
            'category_id' => $category->id,
        ]);
    }
}
