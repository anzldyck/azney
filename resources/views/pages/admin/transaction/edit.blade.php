@extends('layouts.admin')

@section('title')
    Transaction
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Edit Transaksi</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content Row -->
            <div class="card-shadow">
                <div class="card-body">
                    <form action="{{ route('transaction.update', $item->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="transaction_status">Transaction Status</label>
                            <select name="transaction_status" id="transaction_status" class="form-control" required>
                                <option value="{{ $item->transaction_status }}">Jangan Ubah {{ $item->transaction_status }}</option>
                                <option value="IN_CART">In Cart</option>
                                <option value="PENDING">Pending</option>
                                <option value="SUCCESS">Success</option>
                                <option value="CANCEL">Cancel</option>
                                <option value="FAILED">Failed</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
@endsection