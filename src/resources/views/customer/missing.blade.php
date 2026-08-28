@extends('layouts.customer')

@section('title', $title ?? 'Not found')

@section('content')
    <section class="px-5 py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Clothiq</p>
            <h1 class="mt-4 font-serif text-5xl text-charcoal">{{ $title }}</h1>
            <p class="mt-4 text-sm leading-relaxed text-muted">{{ $message }}</p>
            <a href="{{ route('collection.index') }}" class="mt-10 inline-flex border border-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] hover:border-terracotta hover:text-terracotta">
                Back to collection
            </a>
        </div>
    </section>
@endsection
