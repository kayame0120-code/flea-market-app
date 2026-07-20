@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/create.css') }}">
@endsection

@section('content')
    <section class="item-create">
        <div class="item-create__container">
            <h2>商品の出品</h2>
            <form action="/sell" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="item-create__image">
                    <label>商品画像</label>
                    <div class="item-create__image-box">
                        <input type="file" name="img_url" id="img_url">
                        <label for="img_url">画像を選択する</label>
                    </div>
                    <div class="item-create__error">
                        @error('img_url')
                            <p class="item-create__error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="item-create__detail">
                    <h3>商品の詳細</h3>
                    <div class="item-create__categories">
                        <label>カテゴリー</label>
                        <ul class="item-create__category-chips">
                            @foreach ($categories as $category)
                                <li>
                                    <input type="checkbox" name="category_id[]" id="category_{{ $category->id }}"
                                        value="{{ $category->id }}">
                                    <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                        <div class="item-create__error">
                            @error('category_id')
                                <p class="item-create__error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-create__condition">
                        <label>商品の状態</label>
                        <div class="custom-select" id="condition-select">
                            <button type="button" class="custom-select__trigger">
                                <span class="custom-select__trigger-text">選択してください</span>
                            </button>
                            <ul class="custom-select__options">
                                @foreach ($conditions as $value => $label)
                                    <li class="custom-select__option" data-value="{{ $value }}">{{ $label }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <input type="hidden" name="condition" id="condition-input" value="{{ old('condition') }}">
                        <div class="item-create__error">
                            @error('condition')
                                <p class="item-create__error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="item-create__info">
                    <h3>商品名と説明</h3>
                    <div class="item-create__field">
                        <div class="item-create__field-label">
                            <label>商品名</label>
                        </div>
                        <div class="item-create__field-input">
                            <input type="text" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="item-create__error">
                            @error('name')
                                <p class="item-create__error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-create__field">
                        <div class="item-create__field-label">
                            <label>ブランド名</label>
                        </div>
                        <div class="item-create__field-input">
                            <input type="text" name="brand" value="{{ old('brand') }}">
                        </div>
                    </div>
                    <div class="item-create__field">
                        <div class="item-create__field-label">
                            <label>商品の説明</label>
                        </div>
                        <div class="item-create__field-input">
                            <textarea name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="item-create__error">
                            @error('description')
                                <p class="item-create__error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="item-create__field">
                        <div class="item-create__field-label">
                            <label>販売価格</label>
                        </div>
                        <div class="item-create__field-input item-create__price-input">
                            <span>¥</span>
                            <input type="text" name="price" value="{{ old('price') }}">
                        </div>
                        <div class="item-create__error">
                            @error('price')
                                <p class="item-create__error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="item-create__submit">
                    <button type="submit">出品する</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        (function() {
            var conditionLabels = @json($conditions);
            var oldValue = "{{ old('condition') }}";

            var select = document.getElementById('condition-select');
            var trigger = select.querySelector('.custom-select__trigger');
            var triggerText = select.querySelector('.custom-select__trigger-text');
            var options = select.querySelectorAll('.custom-select__option');
            var hiddenInput = document.getElementById('condition-input');

            function markSelected(value) {
                options.forEach(function(option) {
                    var isSelected = option.getAttribute('data-value') === value;
                    option.classList.toggle('is-selected', isSelected);
                    var existingCheck = option.querySelector('.custom-select__check');
                    if (isSelected && !existingCheck) {
                        var check = document.createElement('span');
                        check.className = 'custom-select__check';
                        check.textContent = '✓';
                        option.prepend(check);
                    } else if (!isSelected && existingCheck) {
                        existingCheck.remove();
                    }
                });
            }

            if (oldValue && conditionLabels[oldValue]) {
                triggerText.textContent = conditionLabels[oldValue];
                markSelected(oldValue);
            }

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                select.classList.toggle('is-open');
            });

            options.forEach(function(option) {
                option.addEventListener('click', function() {
                    var value = option.getAttribute('data-value');
                    triggerText.textContent = conditionLabels[value];
                    hiddenInput.value = value;
                    markSelected(value);
                    select.classList.remove('is-open');
                });
            });

            document.addEventListener('click', function() {
                select.classList.remove('is-open');
            });
        })();
    </script>
@endsection