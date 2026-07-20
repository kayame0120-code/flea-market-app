@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection

@section('content')
    <section class="auth-page">
        <div class="auth-page__container">
            <div class="auth-form__content">
                <h2 class="auth-form__heading">会員登録</h2>
                <form class="auth-form" action="/register" method="POST">
                    @csrf
                    <div class="auth-form__card">
                        <div class="auth-form__group">
                            <label for="name">ユーザー名</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}">
                            <div class="auth-form__error">
                                @error('name')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="auth-form__group">
                            <label for="email">メールアドレス</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}">
                            <div class="auth-form__error">
                                @error('email')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="auth-form__group">
                            <label for="password">パスワード</label>
                            <input type="password" name="password" id="password">
                            <div class="auth-form__error">
                                @error('password')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="auth-form__group">
                            <label for="password_confirmation">確認用パスワード</label>
                            <input type="password" name="password_confirmation" id="password_confirmation">
                            <div class="auth-form__error">
                                @error('password_confirmation')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="auth-form__button">
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                    <a href="/login">ログインはこちら</a>
                </form>
            </div>
        </div>
    </section>
@endsection