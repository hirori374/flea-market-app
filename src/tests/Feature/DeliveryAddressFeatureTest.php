<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class DeliveryAddressFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'post_code' => '000-0000',
            'address' => '東京都新宿区',
            'building' => '新宿マンション101',
        ]);
        $this->item = Item::factory()->create();
    }

    //送付先住所変更、購入画面に反映
    public function testDeliveryAddressChange()
    {
        $response = $this->actingAs($this->user)->followingRedirects()->post('/purchase/'.$this->item->id. '/address', [
            'delivery_post_code' => '123-4567',
            'delivery_address' => '大阪府大阪市',
            'delivery_building' => '梅田ビル202',
        ]);
        $response->assertSessionHas([
            'delivery_post_code' => '123-4567',
            'delivery_address' => '大阪府大阪市',
            'delivery_building' => '梅田ビル202',
        ]);
    }
    //送付先変更後、購入→商品と送付先の紐付け確認
    public function testDeliveryAddressLinkedToPurchase()
    {
        $response = $this->actingAs($this->user)->post('/purchase/'.$this->item->id. '/address', [
            'delivery_post_code' => '123-4567',
            'delivery_address' => '大阪府大阪市',
            'delivery_building' => '梅田ビル202',
        ]);
        $response = $this->actingAs($this->user)->post('/purchase/'.$this->item->id, [
            'delivery_post_code' => session('delivery_post_code'),
            'delivery_address' => session('delivery_address'),
            'delivery_building' => session('delivery_building'),
            'pay_method' => 'カード払い',
            'pay_status' => 'pending',
        ]);
        $this->assertDatabaseHas('purchases', [
            'item_id' => $this->item->id,
            'user_id' => $this->user->id,
            'delivery_post_code' => '123-4567',
            'delivery_address' => '大阪府大阪市',
            'delivery_building' => '梅田ビル202',
        ]);
        $this->assertDatabaseMissing('purchases', [
            'item_id' => $this->item->id,
            'user_id' => $this->user->id,
            'delivery_post_code' => '000-0000',
            'delivery_address' => '東京都新宿区',
            'delivery_building' => '新宿マンション101',
        ]);
    }
}
