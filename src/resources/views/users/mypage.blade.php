@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/users/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__info">
        <div class="user">
            <p class="user__icon"><img src="{{ asset('storage/' . $user['icon']) }}" alt="アイコン"></p>
            <p class="user__name">{{Auth::user()->name}}</p>
        </div>
        <form action="/mypage/profile" class="profile-form">
            @csrf
            <button class="profile-form__button-submit">プロフィールを編集</button>
        </form>
    </div>
    <div class="mypage__items">
        <div class="items__tags">
            <a href="/mypage?page=sell" class="items__tag"><span class={{ request('page') === 'sell' ? 'active' : '' }}>出品した商品</span></a>
        <a href="/mypage?page=buy" class="items__tag"><span class={{ request('page') === 'buy' ? 'active' : '' }}>購入した商品</span></a>
        </div>
        @if( $page != null )
        <div class="items__list">
            @foreach ($items as $item)
                @php
                    $isSold = \App\Models\Purchase::where('item_id', $item->id)->exists();
                @endphp
                <a href="/item/{{$item['id']}}" class="item__wrapper">
                    <div class="item__img">
                        <img src="{{ Str::startsWith($item->image, ['http', '/storage']) ? $item->image : asset('storage/' . $item->image) }}" alt="商品画像">
                        @if($isSold)
                            <span class="item__sold">Sold</span>
                        @endif
                    </div>
                    <p class="item__name">{{$item['name']}}</p>
                </a>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection