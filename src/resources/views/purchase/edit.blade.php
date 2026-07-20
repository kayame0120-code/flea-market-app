@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/edit.css') }}">
@endsection

@section('content')
    <section class="purchase-edit">
        <div class="purchase-edit__container">
            <h2 class="purchase-edit__heading">住所の変更</h2>
            <form class="purchase-edit__form" action="/purchase/address/{{ $item_id }}" method="POST">
                @csrf
                <div class="purchase-edit__field">
                    <label class="purchase-edit__label" for="shipping_postal_code">郵便番号</label>
                    <input class="purchase-edit__input" type="text" id="shipping_postal_code" name="shipping_postal_code"
                        value="{{ old('shipping_postal_code', $shippingAddress['postal_code']) }}">
                    @error('shipping_postal_code')
                        <span class="purchase-edit__error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="purchase-edit__field">
                    <label class="purchase-edit__label" for="shipping_address">住所</label>
                    <input class="purchase-edit__input" type="text" id="shipping_address" name="shipping_address"
                        value="{{ old('shipping_address', $shippingAddress['address']) }}">
                    @error('shipping_address')
                        <span class="purchase-edit__error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="purchase-edit__field">
                    <label class="purchase-edit__label" for="shipping_building">建物名</label>
                    <input class="purchase-edit__input" type="text" id="shipping_building" name="shipping_building"
                        value="{{ old('shipping_building', $shippingAddress['building']) }}">
                    @error('shipping_building')
                        <span class="purchase-edit__error">{{ $message }}</span>
                    @enderror
                </div>
                <button class="purchase-edit__submit" type="submit">更新する</button>
            </form>
        </div>
    </section>
@endsection