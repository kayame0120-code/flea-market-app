@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
@endsection

@section('content')
    <section class="item-detail">
        <div class="item-detail__container">
            <div class="item-detail__image">
                <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}"
                    alt="{{ $item->name }}">
            </div>
            <div class="item-detail__info">
                <div class="item-detail__name">
                    <h2>{{ $item->name }}</h2>
                    <p>{{ $item->brand }}</p>
                </div>
                <div class="item-detail__price">
                    <p>
                        <span class="item-detail__price-main">¥{{ number_format($item->price) }}</span>
                        <span class="item-detail__price-tax">（税込）</span>
                    </p>
                </div>
                <div class="item-detail__actions">
                    <div class="item-detail__like">
                        @auth
                            @if ($item->isLikedBy(auth()->user()))
                                <form action="/item/{{ $item->id }}/like" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit">
                                        <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね済み">
                                    </button>
                                </form>
                            @else
                                <form action="/item/{{ $item->id }}/like" method="POST">
                                    @csrf
                                    <button type="submit">
                                        <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                                    </button>
                                </form>
                            @endif
                        @endauth
                        @guest
                            <a href="/login">
                                <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                            </a>
                        @endguest
                        <span>{{ $item->likes->count() }}</span>
                    </div>
                    <div class="item-detail__comment-count">
                        @auth
                            <img src="{{ asset('images/speech_bubble.png') }}" alt="コメント">
                        @endauth
                        @guest
                            <a href="/login">
                                <img src="{{ asset('images/speech_bubble.png') }}" alt="コメント">
                            </a>
                        @endguest
                        <span>{{ $item->comments->count() }}</span>
                    </div>
                </div>
                <div class="item-detail__buy">
                    <a href="/purchase/{{ $item->id }}" class="btn-buy">購入手続きへ</a>
                </div>
                <div class="item-detail__description">
                    <h3>商品説明</h3>
                    <p>{{ $item->description }}</p>
                </div>
                <div class="item-detail__meta">
                    <h3>商品の情報</h3>
                    <div class="item-detail__categories">
                        <p>カテゴリー</p>
                        <ul class="item-detail__category-list">
                            @foreach ($item->categories as $category)
                                <li class="item-detail__category-tag">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="item-detail__condition">
                        <p>商品の状態</p>
                        <span>{{ $item->condition_label }}</span>
                    </div>
                </div>
                <div class="item-detail__comment-list">
                    <h3>コメント({{ $item->comments->count() }})</h3>
                    <ul>
                        @foreach ($item->comments as $comment)
                            <li class="item-detail__comment-item">
                                <div class="item-detail__comment-user">
                                    <span class="item-detail__comment-avatar"></span>
                                    <span>{{ $comment->user->name }}</span>
                                </div>
                                <div class="item-detail__comment-body">
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="item-detail__comment-form">
                    <h3>商品へのコメント</h3>
                    <form action="/item/{{ $item->id }}/comment" method="POST">
                        @auth
                            @csrf
                        @endauth
                        <textarea name="content"></textarea>
                        <div class="item-detail__comment-error">
                            @error('content')
                                <p class="item-detail__comment-error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="item-detail__comment-submit">
                            @auth
                                <button type="submit">コメントを送信する</button>
                            @endauth
                            @guest
                                <a href="/login" class="btn-comment-login">コメントを送信する</a>
                            @endguest
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
