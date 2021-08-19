@extends('layouts.success')

@section('title')
    Transaksi Unfinished
@endsection

@section('content')
    <main>
        <div class="section-success d-flex align-items-center">
            <div class="col text-center">
                <img src="{{ url('frontend/images/testi.jpg') }}" height="180">
                <h1>Oops!</h1>
                <p>
                    Your transaction is Unfinished!
                </p>
                <a href="{{ route('home') }}" class="btn btn-home-page mt-3 px-5">
                    Home Page
                </a>
            </div>
        </div>
    </main>
@endsection