<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>coachtechフリマ</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
            <form action="{{route('index')}}" method="get" class="search-form">
                @csrf
                <input type="text" class="search-form__keyword" name="keyword" value="{{session('keyword') ?? old('keyword')}}"  placeholder="なにをお探しですか？">
            </form>
            @if (Auth::check())
            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li class="header__nav-item">
                        <form method="post" action="/logout">
                            @csrf
                            <button type="submit" class="logout__button">ログアウト</button>
                        </form>
                    </li>
                    <li class="header__nav-item"><a href="/mypage?page=sell" class="header__nav-link">マイページ</a></li>
                    <li class="header__nav-item"><a href="/sell" class="header__nav-link--sell">出品</a></li>
                </ul>
            </nav>
            @else
            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li class="header__nav-item">
                        <form method="get" action="/login">
                            @csrf
                            <button type="submit" class="login__button">ログイン</button>
                        </form>
                    </li>
                    <li class="header__nav-item"><a href="/login" class="header__nav-link">マイページ</a></li>
                    <li class="header__nav-item"><a href="/login" class="header__nav-link--sell">出品</a></li>
                </ul>
            </nav>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>