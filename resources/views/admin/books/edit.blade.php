@extends('layouts.app')
@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-subtitle', $book->title)


@section('navbar-actions')
<a href="{{ route('admin.books.index') }}" class="flex items-center gap-2 text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-dark-border/20 hover:bg-slate-50 dark:hover:bg-white/5 transition uppercase tracking-widest text-[10px]">
    <i class="fas fa-arrow-left"></i> Kembali
</a>
@endsection

@section('content')
{{-- Using the same unified create template for consistency --}}
@include('admin.books.create', ['book' => $book])
@endsection
