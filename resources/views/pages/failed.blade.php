@extends('layouts.success')

@section('title')
    Transaksi Failed
@endsection

@section('content')
    <main>
        <div class="section-success d-flex align-items-center">
            <div class="col text-center">
                <img src="{{ url('frontend/images/testi.jpg') }}" height="180">
                <h1>Oopss!</h1>
                <p>
                    Your Transaction is Failed
                    <br>
                    plase contact our representative if this problem occurs
                </p>
                <a href="{{ route('home') }}" class="btn btn-home-page mt-3 px-5">
                    Home Page
                </a>
            </div>
        </div>
    </main>
@endsection