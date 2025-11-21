@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
                    <p>Role: <span class="badge bg-{{ auth()->user()->isAdmin() ? 'primary' : 'secondary' }}">{{ ucfirst(Auth::user()->role) }}</span></p>
                    @if(auth()->user()->isAdmin())
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('products.index') }}" class="btn btn-primary w-100 mb-2">Kelola Produk</a></div>
                            <div class="col-md-4"><a href="{{ route('categories.index') }}" class="btn btn-info w-100 mb-2">Kelola Kategori</a></div>
                            <div class="col-md-4"><a href="{{ route('sales.index') }}" class="btn btn-warning w-100 mb-2">Lihat Penjualan</a></div>
                        </div>
                    @endif
                    <a href="{{ route('pos.index') }}" class="btn btn-success w-100">Mulai POS</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection