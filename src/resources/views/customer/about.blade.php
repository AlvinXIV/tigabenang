@extends('layouts.customer')

@section('title', 'About')
@section('description', 'The story of FitVendor — custom clothing, precise sizing, and digital fitting.')

@section('content')
    <section class="border-b border-line px-5 py-16 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-4xl">
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">About FitVendor</p>
            <h1 class="mt-4 font-serif text-5xl leading-tight text-charcoal md:text-7xl">An atelier for clothes that actually fit.</h1>
            <p class="mt-8 max-w-2xl text-base leading-relaxed text-muted">
                FitVendor makes custom clothing for teams, communities, and individuals who want garments with intention — from first sketch to finished piece.
            </p>
        </div>
    </section>

    <section class="border-b border-line px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted lg:col-span-3">Story</p>
            <div class="lg:col-span-8">
                <h2 class="font-serif text-4xl text-charcoal">Built between the cutting table and the screen.</h2>
                <p class="mt-6 text-sm leading-relaxed text-muted md:text-base">
                    We started as a clothing vendor that cared too much about fit to leave it to guesswork. Today FitVendor still cuts and sews to order — and uses a digital fitting studio so you can see a garment before production begins.
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-line px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted lg:col-span-3">What We Do</p>
            <div class="grid gap-8 lg:col-span-9 sm:grid-cols-3">
                <div>
                    <p class="font-serif text-2xl">Custom garments</p>
                    <p class="mt-3 text-sm leading-relaxed text-muted">Varsity, work jackets, windbreakers, jersey, and more — made from the collection you see here.</p>
                </div>
                <div>
                    <p class="font-serif text-2xl">Material pairing</p>
                    <p class="mt-3 text-sm leading-relaxed text-muted">Choose from the materials available for each piece. We keep the catalog honest: names, not invented specs.</p>
                </div>
                <div>
                    <p class="font-serif text-2xl">Digital fitting</p>
                    <p class="mt-3 text-sm leading-relaxed text-muted">A single figure, one garment at a time, so proportion is visible before you send a request.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-line px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted lg:col-span-3">Our Process</p>
            <ol class="grid gap-8 lg:col-span-9 sm:grid-cols-2">
                <li>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-terracotta">01</p>
                    <p class="mt-2 font-serif text-2xl">Choose a garment</p>
                    <p class="mt-2 text-sm text-muted">Browse the collection and open the piece that fits the brief.</p>
                </li>
                <li>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-terracotta">02</p>
                    <p class="mt-2 font-serif text-2xl">Select materials</p>
                    <p class="mt-2 text-sm text-muted">Pick one or more bahan available for that product.</p>
                </li>
                <li>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-terracotta">03</p>
                    <p class="mt-2 font-serif text-2xl">Preview the fit</p>
                    <p class="mt-2 text-sm text-muted">Use virtual fitting when a 3D file exists — or skip ahead to the request.</p>
                </li>
                <li>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-terracotta">04</p>
                    <p class="mt-2 font-serif text-2xl">Send a request</p>
                    <p class="mt-2 text-sm text-muted">Tell us who you are, the sizes you need, and any design notes. No account required.</p>
                </li>
            </ol>
        </div>
    </section>

    <section class="border-b border-line px-5 py-16 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-12">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted lg:col-span-3">Team</p>
            <div class="lg:col-span-8">
                <h2 class="font-serif text-4xl text-charcoal">A small studio, close to the work.</h2>
                <p class="mt-6 text-sm leading-relaxed text-muted md:text-base">
                    Pattern, production, and digital fitting sit in the same conversation. When you send a request, a person on our team reads it — not a customer portal.
                </p>
            </div>
        </div>
    </section>

    <section class="px-5 py-16 lg:px-8 lg:py-24">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted lg:col-span-3">Contact</p>
            <div class="mt-6 lg:col-span-8 lg:mt-0">
                <p class="font-serif text-3xl text-charcoal">{{ config('fitvendor.contact.location') }}</p>
                <p class="mt-4 text-sm text-ink">{{ config('fitvendor.contact.email') }}</p>
                <a href="{{ route('order.create') }}" class="mt-8 inline-flex bg-charcoal px-6 py-3 text-[11px] uppercase tracking-[0.22em] text-ivory hover:bg-terracotta">
                    Start a request
                </a>
            </div>
        </div>
    </section>
@endsection
