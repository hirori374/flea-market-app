@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item__content">
    <div class="items__tags">
        <a href="/" class="items__tag"><span class={{ request('tab') === 'mylist' ? '' : 'active' }}>おすすめ</span></a>
        <a href="/?tab=mylist" class="items__tag"><span class={{ request('tab') === 'mylist' ? 'active' : '' }}>マイリスト</span></a>
    </div>
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
</div>
@endsection