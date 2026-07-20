@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
    <section class="mypage">
        <div class="mypage__container">
            <div class="mypage-header">
                <div class="mypage-header__icon"></div>
                <div class="mypage-header__info">
                    <p class="mypage-header__name">{{ $user->name }}</p>
                    <a href="/mypage/profile" class="mypage-header__edit-link">プロフィール編集</a>
                </div>
            </div>
            <nav aria-label="マイページの商品一覧切り替え">
                <ul class="mypage__tabs">
                    <li class="mypage__tab">
                        <a href="/mypage"
                            class="mypage__tab-link @if ($page !== 'buy') mypage__tab-link--active @endif">出品した商品</a>
                    </li>
                    <li class="mypage__tab">
                        <a href="/mypage?page=buy"
                            class="mypage__tab-link @if ($page === 'buy') mypage__tab-link--active @endif">購入した商品</a>
                    </li>
                </ul>
            </nav>
            <ul class="item-list">
                @foreach ($items as $item)
                    <li class="item-card">
                        <a href="/item/{{ $item->id }}">
                            <div class="item-card__image">
                                <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}"
                                    alt="{{ $item->name }}">
                                @if ($item->isSold())
                                    <div class="item-card__sold">Sold</div>
                                @endif
                            </div>
                            <div class="item-card__name">
                                <p>{{ $item->name }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
