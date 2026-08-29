@extends('layouts.customer')

@section('title', 'About')
@section('description', 'Kisah Clothiq — dedikasi kami dalam menghadirkan pakaian custom berkualitas tinggi dengan fitting presisi dan teknologi 3D.')

@section('content')

    {{-- ── Header ───────────────────────────────────── --}}
    <section class="relative overflow-hidden border-b border-border bg-primary" style="background-color:#172A39;border-color:#DCD6D0;">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full blur-3xl" style="background:rgba(234,226,216,0.08);"></div>
            <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full blur-3xl" style="background:rgba(233,228,224,0.06);"></div>
        </div>
        <div class="relative mx-auto max-w-5xl px-5 py-11 lg:px-8 lg:py-15">
            <span class="section-badge mb-3.5" style="color:#EAE2D8;">
                <span style="width:1.35rem;height:2.5px;background:#EAE2D8;border-radius:2px;display:inline-block;"></span>
                About Clothiq
            </span>
            <h1 class="mt-2 max-w-3xl text-4xl font-extrabold leading-tight tracking-tight text-white md:text-5xl">
                An atelier for clothes<br>that actually fit.
            </h1>
            <p class="mt-3.5 max-w-2xl text-sm leading-relaxed text-white/75">
                Clothiq makes custom clothing for teams, communities, and individuals who want garments with intention — from first sketch to finished piece.
            </p>
        </div>
    </section>

    {{-- ── Story ────────────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8" style="border-color:#DCD6D0;background:#FFFFFF;">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Story</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-primary md:text-4xl" style="color:#172A39;">
                    Built between the cutting table and the screen.
                </h2>
                <p class="mt-6 text-sm leading-relaxed md:text-base" style="color:#6E7575;">
                    We started as a clothing vendor that cared too much about fit to leave it to guesswork. Today Clothiq still cuts and sews to order — and uses a digital fitting studio so you can see a garment before production begins.
                </p>
            </div>
        </div>
    </section>

    {{-- ── What We Do ───────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8" style="background:#FAF8F5;border-color:#DCD6D0;">
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
                    <div class="rounded-2xl border bg-white p-7 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md" style="border-color:#DCD6D0;">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl mb-5" style="background:#EAEFF4;">
                            <svg class="h-6 w-6" style="color:#172A39;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold" style="color:#172A39;">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed" style="color:#6E7575;">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Our Process ──────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8" style="background:#FFFFFF;border-color:#DCD6D0;">
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
                    <li class="rounded-2xl border bg-white p-7" style="border-color:#DCD6D0;">
                        <span class="text-3xl font-black" style="color:#172A39;">{{ $step['num'] }}</span>
                        <h3 class="mt-2 text-base font-bold" style="color:#172A39;">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed" style="color:#6E7575;">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ── Team ─────────────────────────────────────── --}}
    <section class="border-b border-border px-5 py-16 lg:px-8" style="background:#FAF8F5;border-color:#DCD6D0;">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Team</span>
            </div>
            <div class="lg:col-span-8">
                <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl" style="color:#172A39;">A small studio, close to the work.</h2>
                <p class="mt-6 text-sm leading-relaxed md:text-base" style="color:#6E7575;">
                    Pattern, production, and digital fitting sit in the same conversation. When you send a request, a person on our team reads it — not a customer portal.
                </p>
            </div>
        </div>
    </section>

    {{-- ── Contact / CTA ───────────────────────────── --}}
    <section class="px-5 py-16 lg:px-8 lg:py-24" style="background:#FFFFFF;">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12">
            <div class="lg:col-span-3">
                <span class="section-badge">Contact</span>
            </div>
            <div class="mt-6 lg:col-span-8 lg:mt-0">
                <p class="text-xl font-extrabold" style="color:#172A39;">{{ config('fitvendor.contact.location') }}</p>
                <a href="mailto:{{ config('fitvendor.contact.email') }}" class="mt-2 block text-sm font-semibold hover:underline" style="color:#172A39;">
                    {{ config('fitvendor.contact.email') }}
                </a>
                <a href="{{ route('order.create') }}" class="btn-primary mt-8 inline-flex" style="padding:0.875rem 2rem;font-size:0.875rem;font-weight:800;border-radius:9999px;box-shadow:0 4px 16px rgba(23,42,57,0.25);">
                    Start a Request
                </a>
            </div>
        </div>
    </section>

@endsection
