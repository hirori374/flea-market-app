<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/verify_email.css') }}">
    <title>coachtechフリマ</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo"><img src="{{ asset('img/logo.svg') }}" alt="ロゴ画像"></a>
        </div>
    </header>
    <main class="mail-auth__inner">
        <div class="send__message">
            <div>登録していただいたメールアドレスに認証メールを送付しました。</br>メール認証を完了させてください。</div>
        </div>
        <form action="http://localhost:8025/" method="get" class="auth-mail__button">
            @csrf
            <button class="auth-mail__button-submit">認証はこちらから</button>
        </form>
        <!-- メール認証サイトに遷移 -->
        <form action="/email/verification-notification" method="post"  class="mail-resend__button">
            @csrf
            <button class="mail-resend__button-submit">認証メールを再送する</button></form>
    </main>

</body>
</html>