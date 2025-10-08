<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <title>coachtechフリマ</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
        </div>
    </header>
    <main>
        <div class="register__container">
            <h2 class="register-form__title">会員登録</h2>
            <form action="/register" method="post" class="register-form">
                @csrf
                <div class="form-group">
                    <div class="form-group__title">ユーザー名</div>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-group__content">
                    <div class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">メールアドレス</div>
                    <input type="email" name="email" value="{{ old('email') }} "class="form-group__content">
                    <div class="form__error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">パスワード</div>
                    <input type="password" name="password" class="form-group__content">
                    <div class="form__error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group__title">確認用パスワード</div>
                    <input type="password" name="password_confirmation" class="form-group__content">
                    <div class="form__error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="register-form__button">
                    <button class="register-form__button-submit">登録する</button>
                    <a href="/login" class="login-link">ログインはこちら</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>