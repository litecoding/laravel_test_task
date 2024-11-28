@extends('orders.layout')

@section('content')

    <div class="card mt-5">
        <h2 class="card-header">Add New Order</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('orders.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Name:</strong></label>
                    <input
                        type="text"
                        name="product_name"
                        class="form-control @error('product_name') is-invalid @enderror"
                        id="inputName"
                        placeholder="Product name">
                    @error('product_name')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputAmount" class="form-label"><strong>Amount:</strong></label>
                    <input
                        type="number"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/\D+/g, '')"
                        name="amount"
                        class="form-control @error('amount') is-invalid @enderror"
                        id="inputAmount"
                        placeholder="Amount">
                    @error('amount')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputStatus" class="form-label"><strong>Name:</strong></label>
                    <select name="status" >
                    @foreach (App\Enum\Status::values() as $key=>$value)
                        <option value="{{ $key }}" @selected(old('status') == $value)>
                            {{ $value }}
                        </option>
                    @endforeach
                    </select>
                    @error('status')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </form>

        </div>
    </div>
@endsection
