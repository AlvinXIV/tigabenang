@extends('layouts.customer')

@section('title', 'About')
@section('description', 'Kisah Clothiq — dedikasi kami dalam menghadirkan pakaian custom berkualitas tinggi dengan fitting presisi dan teknologi 3D.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="relative overflow-hidden border-b border-border bg-primary">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-accent/10 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-5xl px-5 py-16 lg:px-8 lg:py-24">
            <span class="section-badge text-accent [&::before]:bg-accent mb-6">About Clothiq</span>
            <h1 class="mt-2 max-w-3xl text-5xl font-extrabold leading-tight tracking-tight text-white md:text-6xl">
                An atelier for clothes<br>that actually fit.
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/70">
                Clothiq makes custom clothing for teams, communities, and individuals who want garments with intention — from first sketch to finished piece.
            </p>
        </div>
    </section>

    {{-- ── Story ────────────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Story</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-primary md:text-4xl">
                    Built between the cutting table and the screen.
                </h2>
                <p class="mt-6 text-sm leading-relaxed text-text-muted md:text-base">
                    We started as a clothing vendor that cared too much about fit to leave it to guesswork. Today Clothiq still cuts and sews to order — and uses a digital fitting studio so you can see a garment before production begins.
                </p>
            </div>
        </div>
    </section>

    {{-- ── What We Do ───────────────────────────────── --}}
    <section class="border-b border-border bg-surface-alt px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">What We Do</span>
            </div>
            <div class="grid gap-6 lg:col-span-9 sm:grid-cols-3">
                @foreach ([
                    ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'title' => 'Custom garments', 'desc' => 'Varsity, work jackets, windbreakers, jersey, and more — made from the collection you see here.'],
                    ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'title' => 'Material pairing', 'desc' => 'Choose from the materials available for each piece. We keep the catalog honest: names, not invented specs.'],
                    ['icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-1', 'title' => 'Digital fitting', 'desc' => 'A single figure, one garment at a time, so proportion is visible before you send a request.'],
                ] as $item)
                    <div class="rounded-xl border border-border bg-white p-6 hover:shadow-md hover:shadow-primary/5 transition-shadow">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-muted mb-4">
                            <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-text-base">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-text-muted">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Our Process ──────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Our Process</span>
            </div>
            <ol class="grid gap-6 lg:col-span-9 sm:grid-cols-2">
                @foreach ([
                    ['num' => '01', 'title' => 'Choose a garment', 'desc' => 'Browse the collection and open the piece that fits the brief.'],
                    ['num' => '02', 'title' => 'Select materials',  'desc' => 'Pick one or more bahan available for that product.'],
                    ['num' => '03', 'title' => 'Preview the fit',   'desc' => 'Use virtual fitting when a 3D file exists — or skip ahead to the request.'],
                    ['num' => '04', 'title' => 'Send a request',    'desc' => 'Tell us who you are, the sizes you need, and any design notes. No account required.'],
                ] as $step)
                    <li class="rounded-xl border border-border bg-white p-6">
                        <span class="text-2xl font-black text-primary/15">{{ $step['num'] }}</span>
                        <h3 class="mt-2 text-base font-bold text-text-base">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-text-muted">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ── Team ─────────────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Team</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-primary md:text-4xl">A small studio, close to the work.</h2>
                <p class="mt-6 text-sm leading-relaxed text-text-muted md:text-base">
                    Pattern, production, and digital fitting sit in the same conversation. When you send a request, a person on our team reads it — not a customer portal.
                </p>
            </div>
        </div>
    </section>

    {{-- ── Contact / CTA ───────────────────────────── --}}
    <section class="px-5 py-16 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Contact</span>
            </div>
            <div class="mt-6 lg:col-span-8 lg:mt-0">
                <p class="text-xl font-bold text-primary">{{ config('fitvendor.contact.location') }}</p>
                <a href="mailto:{{ config('fitvendor.contact.email') }}" class="mt-2 block text-sm text-text-muted hover:text-primary transition-colors">
                    {{ config('fitvendor.contact.email') }}
                </a>
                <a href="{{ route('order.create') }}" class="btn-primary mt-8 self-start">
                    Start a Request
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
