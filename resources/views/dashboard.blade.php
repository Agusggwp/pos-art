@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-200">
            <div class="p-8 text-center">
                <!-- Header with Icon -->
                <div class="mx-auto flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h1>
                <p class="text-lg text-gray-600 mb-6">Dashboard POS Laravel</p>

                <!-- User Info -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">Halo, {{ Auth::user()->name }}!</h4>
                    <p class="text-sm text-gray-600 mb-3">Role Anda:</p>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        {{ auth()->user()->isAdmin() ? 'bg-indigo-600 text-white' : 'bg-gray-600 text-white' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>

                <!-- Admin Controls -->
                @if(auth()->user()->isAdmin())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <a href="{{ route('products.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-center text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="w-8 h-8 mx-auto mb-3 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 6m0 0l-8-6m8 6V7"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Kelola Produk</h3>
                            <p class="text-sm opacity-90">Stok & Detail</p>
                        </a>

                        <a href="{{ route('categories.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-center text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="w-8 h-8 mx-auto mb-3 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Kelola Kategori</h3>
                            <p class="text-sm opacity-90">Organisasi & Grup</p>
                        </a>

                        <a href="{{ route('sales.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 p-6 text-center text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="w-8 h-8 mx-auto mb-3 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <h3 class="text-lg font-semibold">Lihat Penjualan</h3>
                            <p class="text-sm opacity-90">Riwayat & Laporan</p>
                        </a>
                    </div>
                @endif

                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-green-800">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <!-- POS Button -->
                <a href="{{ route('pos.index') }}" class="group relative overflow-hidden w-full inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Mulai POS</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection