@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h1 class="text-2xl font-bold mb-2">Daftar</h1>
    <p class="text-ink-muted text-sm mb-6">Untuk daftar, silakan gunakan modal di halaman utama.</p>

    <a href="{{ route('public.home') }}" class="btn btn-primary w-full">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke Beranda
    </a>
@endsection