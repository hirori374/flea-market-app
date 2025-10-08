@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/users/profile.css') }}">
@endsection

@section('content')
<div class="profile__container">
    <h2 class="profile-form__title">プロフィール設定</h2>
    <form action="{{ route('profile.update') }}" method="post" class="profile-form" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
        <div class="form-group">
            <div class="user-icon">
                <img src="{{ asset('storage/' . $user['icon']) }}" alt="icon" class="user-icon__img">
                <div class="form-group__content--icon">
                    <label for="icon" class="icon__button">
                        <input type="file" name="icon" id="icon">
                        <span>画像を選択する</span>
                    </label>
                </div>
            </div>
            <div class="form__error">
                @error('icon')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">ユーザー名</div>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-group__content">
            <div class="form__error">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">郵便番号</div>
            <input type="text" name="post_code" value="{{ old('post_code', $user->post_code) }} "class="form-group__content">
            <div class="form__error">
                @error('post_code')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">住所</div>
            <input type="text" name="address" value="{{ old('address', $user->address) }} "class="form-group__content">
            <div class="form__error">
                @error('address')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__title">建物名</div>
            <input type="text" name="building" value="{{ old('building', $user->building) }} "class="form-group__content">
        </div>
        <div class="profile-form__button">
            <button class="profile-form__button-submit">更新する</button>
        </div>
    </form>
</div>
@endsection