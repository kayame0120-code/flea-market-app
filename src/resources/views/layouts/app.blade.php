<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <h1 class="header__logo">
            <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
        </h1>
        <form action="/" method="GET" class="header__search">
            <input type="hidden" name="tab" value="{{ request('tab') }}">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
        </form>
        <nav class="header-nav">
            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            @endauth
            @guest
                <a href="/login">ログイン</a>
            @endguest
            <a href="/mypage">マイページ</a>
            <a href="/sell" class="btn-sell">出品</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>