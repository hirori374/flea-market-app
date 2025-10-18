<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PayMethodFeatureTest extends TestCase
{
    use RefreshDatabase;

    //支払い方法反映確認
    public function testPayMethodChange()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->followingRedirects()->get('/purchase/payMethod/'.$item->id.'?pay_method=カード払い');
        $response->assertSessionHas('pay_method', 'カード払い');
    }
}
