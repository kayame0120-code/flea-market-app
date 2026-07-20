@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/create.css') }}">
@endsection

@section('content')
    <section class="purchase-create">
        <form class="purchase-create__form" action="/purchase/{{ $item->id }}" method="POST">
            @csrf
            <div class="purchase-create__main">
                <div class="purchase-create__item">
                    <div class="purchase-create__item-image">
                        <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="purchase-create__item-info">
                        <p class="purchase-create__item-name">{{ $item->name }}</p>
                        <p class="purchase-create__item-price">￥{{ number_format($item->price) }}</p>
                    </div>
                </div>
                <div class="purchase-create__payment">
                    <p class="purchase-create__label">支払い方法</p>
                    <select class="purchase-create__select" name="payment_method">
                        <option value="" selected disabled>選択してください</option>
                        @foreach ($paymentMethods as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <span class="purchase-create__error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="purchase-create__shipping">
                    <p class="purchase-create__label">配送先</p>
                    <a class="purchase-create__change-link" href="/purchase/address/{{ $item->id }}">変更する</a>
                    <div class="purchase-create__shipping-info">
                        <p>〒{{ $shippingAddress['postal_code'] }}</p>
                        <p>{{ $shippingAddress['address'] }}{{ $shippingAddress['building'] }}</p>
                    </div>
                </div>
            </div>
            <div class="purchase-create__summary">
                <table class="purchase-create__table">
                    <tr>
                        <th>商品代金</th>
                        <td>￥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td class="purchase-create__selected-payment"></td>
                    </tr>
                </table>
                <button class="purchase-create__submit" type="submit">購入する</button>
            </div>
        </form>
    </section>

    <script>
        (function() {
            var paymentLabels = @json($paymentMethods);
            var select = document.querySelector('.purchase-create__select');
            var display = document.querySelector('.purchase-create__selected-payment');

            function updateDisplay() {
                display.textContent = paymentLabels[select.value] || '';
            }

            select.addEventListener('change', updateDisplay);
            updateDisplay();
        })();
    </script>
@endsection