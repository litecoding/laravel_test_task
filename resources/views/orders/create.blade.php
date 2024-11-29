@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Створити нове замовлення</h2>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="mb-3">
                <label for="product_name" class="form-label">Назва продукту</label>
                <input type="text" name="product_name" id="product_name"
                       class="form-control @error('product_name') is-invalid @enderror"
                       value="{{ old('product_name') }}" required>
                @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Кількість</label>
                <input type="number" name="amount" id="amount"
                       class="form-control @error('amount') is-invalid @enderror"
                       value="{{ old('amount') }}" required>
                @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Статус</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach(\App\Enum\Status::cases() as $status)
                        <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                    @endforeach
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Створити</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
