<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <title>coachtechフリマ</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
        </div>
    </header>
    <main>
        <div class="login__container">
            <h2 class="login-form__title">ログイン</h2>
            <form action="/login" method="post" class="login-form">
                @csrf
                <div class="form-group">
                    <div class="form-group__title">メールアドレス</div>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-group__content">
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
                <div class="login-form__button">
                    <button class="login-form__button-submit">ログインする</button>
                    <a href="/register" class="register-link">会員登録はこちら</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>