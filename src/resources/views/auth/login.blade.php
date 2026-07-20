@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection

@section('content')
    <section class="auth-page">
        <div class="auth-page__container">
            <div class="auth-form__content">
                <h2 class="auth-form__heading">ログイン</h2>
                <form class="auth-form" action="/login" method="POST">
                    @csrf
                    <div class="auth-form__card">
                        <div class="auth-form__group">
                            <label for="email">メールアドレス</label>
                            <input type="email" name="email" id="email" placeholder="test@example.com"
                                value="{{ old('email') }}">
                            <div class="auth-form__error">
                                @error('email')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="auth-form__group">
                            <label for="password">パスワード</label>
                            <input type="password" name="password" id="password" placeholder="coachtech1106">
                            <div class="auth-form__error">
                                @error('password')
                                    <p class="auth-form__error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="auth-form__button">
                        <button type="submit" class="btn btn-primary">ログインする</button>
                    </div>
                    <a href="/register">会員登録はこちら</a>
                </form>
            </div>
        </div>
    </section>
@endsection