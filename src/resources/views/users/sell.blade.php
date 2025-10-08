@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/users/sell.css') }}">
@endsection

@section('content')
    <div class="sell-form__container">
        <h2 class="sell-form__title">商品の出品</h2>
        <form action="/sell" method="post" class="sell-form" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <div class="form-group__title">商品画像</div>
                <div class="form-group__content--img">
                    <label for="image" class="form-group__input--file">
                    <input type="file" name="image" id="image">
                    <span class="file-custom__button">画像を選択する</span>
                    </label>
                </div>
                <div class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-groups">
                <h3 class="form-groups__title">商品の詳細</h3>
                <div class="form-group">
                    <div class="form-group__title">カテゴリー</div>
                    <div class="form-group__content--category">
                        @foreach ($categories as $category)
                        <input type="checkbox" name="category[]" id="{{ $category['id'] }}" class="form-group__input--checkbox" value="{{ $category['id'] }}" {{ is_array(old('category')) && in_array($category->id, old('category')) ? 'checked' : '' }}><label for="{{ $category['id'] }}" class="form-group__label--checkbox">{{ $category['name']}}</label>
                        @endforeach
                    </div>
                    <div class="form__error">
                        @error('category')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">商品の状態</div>
                    <div class="form-group__content">
                        <select name="condition" class="form-group__input--select">
                            <option value="">選択してください</option>
                            <option value="良好" {{old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                            <option value="目立った傷や汚れなし" {{old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                            <option value="やや傷や汚れあり" {{old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                            <option value="状態が悪い" {{old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                        </select>
                    </div>
                    <div class="form__error">
                        @error('condition')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-groups">
                <h3 class="form-groups__title">商品名と説明</h3>
                <div class="form-group">
                    <div class="form-group__title">商品名</div>
                    <div class="form-group__content"><input type="text" name="name" class="form-group__input--text" value="{{old('name')}}"></div>
                    <div class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">ブランド名</div>
                    <div class="form-group__content"><input type="text" name="brand" class="form-group__input--text" value="{{old('brand')}}"></div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">商品の説明</div>
                    <div class="form-group__content"><textarea name="description" rows="6" class="form-group__input--textarea">{{old('description')}}</textarea></div>
                    <div class="form__error">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">商品価格</div>
                    <div class="form-group__content--number"><span class="unit">¥</span><input type="number" name="price" class="form-group__input--number" value="{{old('price')}}"></div>
                    <div class="form__error">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="sell-form__button">
                <input type="hidden" name="seller_id" value="{{Auth::user()->id}}">
                <button class="sell-form__button-submit">出品する</button>
            </div>
        </form>
    </div>
@endsection