@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify.css') }}">
@endsection

@section('content')
    <div class="verify">
        <p class="verify__text">登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p class="verify__text">メール認証を完了してください。</p>
        <a href="http://localhost:8025" target="_blank" rel="noopener noreferrer" class="verify__button">
            認証はこちらから
        </a>
        <form class="verify__resend-form" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify__resend">認証メールを再送する</button>
        </form>
    </div>
@endsection
