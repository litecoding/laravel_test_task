@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Список замовлень</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">Створити нове замовлення</a>

        @if($orders->count())
            <form method="GET" action="{{ url('/orders') }}" class="d-inline mb-3">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" name="product_name" class="form-control" placeholder="Назва продукту" value="{{ request('product_name') }}">
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="amount_min" class="form-control" placeholder="Мін. кількість" value="{{ request('amount_min') }}">
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="amount_max" class="form-control" placeholder="Макс. кількість" value="{{ request('amount_max') }}">
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="user_id" class="form-control" placeholder="ID користувача" value="{{ request('user_id') }}">
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Виберіть статус</option>
                            @foreach(\App\Enum\Status::cases() as $status)
                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                    {{ ucfirst($status->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Фільтрувати</button>
                    </div>
                </div>
            </form>
            <br>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Назва продукту</th>
                    <th>Кількість</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ ucfirst($order->status->value) }}</td>
                        <td>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm">Редагувати</a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?')">
                                    Видалити
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $orders->links('pagination::bootstrap-5') }}
        @else
            <p class="text-muted">Немає замовлень.</p>
        @endif
    </div>
@endsection
