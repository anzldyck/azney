@extends('layouts.success')

@section('title')
    Transaksi Sukses
@endsection

@section('content')
    <main>
        <div class="section-success d-flex align-items-center">
            <div class="col text-center">
                <img src="{{ url('frontend/images/testi.jpg') }}" height="180">
                <h1>Yeay Success</h1>
                <p>
                    We've sent you email for trip instruction
                    <br>
                    plase read it as well
                </p>
                <a href="{{ route('home') }}" class="btn btn-home-page mt-3 px-5">
                    Home Page
                </a>
            </div>
        </div>
    </main>
@endsection