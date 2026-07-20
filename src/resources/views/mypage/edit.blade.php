@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/edit.css') }}">
@endsection

@section('content')
    <section class="mypage-edit">
        <div class="mypage-edit__container">
            <h2 class="mypage-edit__heading">プロフィール設定</h2>
            <form class="mypage-edit__form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mypage-edit__field">
                    <label for="img_url" class="mypage-edit__icon-label">画像を選択する</label>
                    <input type="file" id="img_url" name="img_url" class="mypage-edit__icon-input" hidden>
                </div>
                <div class="mypage-edit__field">
                    <label for="name">ユーザー名</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    <div class="mypage-edit__error">
                        @error('name')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mypage-edit__field">
                    <label for="postal_code">郵便番号</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    <div class="mypage-edit__error">
                        @error('postal_code')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mypage-edit__field">
                    <label for="address">住所</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
                    <div class="mypage-edit__error">
                        @error('address')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mypage-edit__field">
                    <label for="building">建物名</label>
                    <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
                    <div class="mypage-edit__error">
                        @error('building')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="mypage-edit__submit">更新する</button>
            </form>
        </div>
    </section>
@endsection
