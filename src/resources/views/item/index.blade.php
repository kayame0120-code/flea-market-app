@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')
    <section class="item-index">
        <div class="item-index__container">
            <h2 class="u-visually-hidden">商品一覧</h2>
            <ul class="item-index__tabs">
                <li class="item-index__tab">
                    <a href="/?keyword={{ urlencode(request('keyword')) }}"
                        class="item-index__tab-link @if ($tab !== 'mylist') item-index__tab-link--active @endif">おすすめ</a>
                </li>
                <li class="item-index__tab">
                    <a href="/?tab=mylist&keyword={{ urlencode(request('keyword')) }}"
                        class="item-index__tab-link @if ($tab === 'mylist') item-index__tab-link--active @endif">マイリスト</a>
                </li>
            </ul>
            <ul class="item-list">
                @foreach ($items as $item)
                    <li class="item-card">
                        <a href="/item/{{ $item->id }}">
                            <div class="item-card__image">
                                <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}"
                                    alt="{{ $item->name }}">
                                @if ($item->isSold())
                                    <div class="item-card__sold">
                                        <span class="item-card__sold-badge">Sold</span>
                                    </div>
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