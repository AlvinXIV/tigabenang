@extends('layouts.customer')

@section('title', 'Materials')
@section('description', 'The Clothiq material library — names from the atelier, presented as an editorial catalog.')

@section('content')

    <section class="border-b border-border bg-primary">
        <div class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-14">
            <span class="section-badge text-accent [&::before]:bg-accent mb-5">Materials</span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl">A Library of Touch</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/70">
                Each name below comes from the atelier's material records. Composition, weight, and care notes are not stored in the current catalog — they remain a conversation with our team.
            </p>
        </div>
    </section>

    <section class="px-5 py-10 lg:px-8">
        <div class="catalog-shell">
            @if ($materials->isNotEmpty())
                <div class="catalog-grid catalog-grid--3">
                    @foreach ($materials as $index => $bahan)
                        <x-material-item :bahan="$bahan" :lazy="$index > 2" />
                    @endforeach
                </div>
            @else
                <x-empty-state title="Material library is empty" message="Bahan records will appear here once they are added." />
            @endif
        </div>
    </section>

@endsection
