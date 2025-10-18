@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/items/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <div class="purchase__inner">
        <div class="purchase__wrapper">
            <div class="purchase__group--item">
                <div class="item__img">
                    <img src="{{ Str::startsWith($item->image, ['http', '/storage']) ? $item->image : asset('storage/' . $item->image) }}" alt="商品画像">
                </div>
                <div class="item-info">
                    <h3 class="item__name">{{$item['name']}}</h3>
                    <div class="item__price"><span>¥</span><p class="item__price--input">{{number_format($item['price'])}}</p></div>
                </div>
            </div>
            <div class="purchase__group">
                <form action="/purchase/payMethod/{{$item['id']}}" action="get" class="pay-method__form">
                    @csrf
                    <p class="group__title">支払い方法</p>
                    <div class="group__content">
                        <select name="pay_method" onchange="this.form.submit()">
                            <option value="">選択してください</option>
                            <option value="コンビニ払い" {{old('pay_method') ?? session('pay_method')=='コンビニ払い' ? 'selected' : ''}}>コンビニ払い</option>
                            <option value="カード払い" {{old('pay_method') ?? session('pay_method')=='カード払い' ? 'selected' : ''}}>カード払い</option>
                        </select>
                    </div>
                    <div class="form__error">
                        @error('pay_method')
                            {{ $message }}
                        @enderror
                    </div>
                </form>
            </div>
            <div class="purchase__group">
                <div class="purchase__sub-group">
                    <p class="group__title">配送先</p>
                    <a href="/purchase/address/{{$item['id']}}" class="address-change__link">変更する</a>
                </div>
                <div class="group__content">
                    <div class="group__sub-content">
                        <span>〒</span><span>{{session('delivery_post_code') ?? $user['post_code']}}</span>
                    </div>
                    <div class="group__sub-content">
                    <span>{{session('delivery_address') ?? $user['address']}}{{session('delivery_building') ?? $user['building']}}</span>
                    </div><div class="form__error">
                        @error('delivery_post_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <form action="/purchase/{{$item['id']}}" method="post" class="purchase-form">
            @csrf
            <div class="delivery-info__input">
                <input type="hidden" name="delivery_post_code" value="{{session('delivery_post_code') ?? $user['post_code']}}">
                <input type="hidden" name="delivery_address" value="{{session('delivery_address') ?? $user['address']}}">
                <input type="hidden" name="delivery_building" value="{{session('delivery_building') ?? $user['building']}}">
            </div>
            <div class="purchase__wrapper--table">
                <table class="purchase-table">
                    <tr class="table__item">
                        <td class="item__title">商品代金</td>
                        <td class="item__content"><span>¥</span><p>{{number_format($item['price'])}}</p></td>
                    </tr>
                    <tr class="table__item">
                        <td class="item__title">支払い方法</td>
                        <td class="item__content"><p>{{ session('pay_method') ?? '未選択'}}</p>
                        <input type="hidden" name="pay_method" value="{{session('pay_method') ?? ''}}"></td>
                    </tr>
                </table>
                <div class="purchase-form__button">
                    <button class="purchase-form__button-submit">購入する</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection