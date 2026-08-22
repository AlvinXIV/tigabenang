@extends('layouts.customer')

@section('title', 'Materials')
@section('description', 'The FitVendor material library — names from the atelier, presented as an editorial catalog.')

@section('content')
    <section class="border-b border-line px-5 py-14 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-12">
            <div class="lg:col-span-7">
                <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">Materials</p>
                <h1 class="mt-3 font-serif text-5xl text-charcoal md:text-6xl">A Library of Touch</h1>
            </div>
            <p class="mt-6 max-w-md text-sm leading-relaxed text-muted lg:col-span-5 lg:mt-12">
                Each name below comes from the atelier’s material records. Composition, weight, and care notes are not stored in the current catalog — they remain a conversation with our team.
            </p>
        </div>
    </section>

    <section class="px-5 py-14 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-7xl">
            @if ($materials->isNotEmpty())
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($materials as $index => $bahan)
                        <x-material-item :bahan="$bahan" :lazy="$index > 1" />
                    @endforeach
                </div>
                <p class="mt-12 text-center text-[11px] uppercase tracking-[0.2em] text-muted">
                    Optional images: public/images/materials/{slug}.jpg
                </p>
            @else
                <x-empty-state title="Material library is empty" message="Bahan records will appear here once they are added." />
            @endif
        </div>
    </section>
@endsection
