@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/items/address.css') }}">
@endsection

@section('content')
<div class="address__container">
    <h2 class="address-form__title">住所の変更</h2>
    <form action="/purchase/{{$item['id']}}/address" method="post" class="address-form">
        @csrf
        <div class="form-group">
            <div class="form-group__title">郵便番号</div>
            <input type="text" name="delivery_post_code" class="form-group__content--number" value="{{old('delivery_post_code',session('delivery_post_code', $user['post_code']))}}">
            <div class="form__error">
                @error('delivery_post_code')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">住所</div>
            <input type="text" name="delivery_address" class="form-group__content" value="{{old('delivery_address',session('delivery_address', $user['address']))}}">
            <div class="form__error">
                @error('delivery_address')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">建物名</div>
            <input type="text" name="delivery_building" class="form-group__content" value="{{old('delivery_building', session('delivery_building', $user['building']))}}">
        </div>
        <div class="address-form__button">
            <button class="address-form__button-submit">更新する</button>
        </div>
    </form>
</div>
@endsection