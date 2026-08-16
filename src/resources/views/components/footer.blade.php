<footer class="border-t border-line bg-ivory-deep">
    <div class="mx-auto grid max-w-7xl gap-12 px-5 py-16 lg:grid-cols-12 lg:px-8 lg:py-20">
        <div class="lg:col-span-5">
            <p class="font-serif text-3xl tracking-[0.18em] text-charcoal">FITVENDOR</p>
            <p class="mt-5 max-w-sm text-sm leading-relaxed text-muted">
                Custom clothing crafted with thoughtful materials, precise sizing, and modern fitting technology.
            </p>
        </div>

        <div class="lg:col-span-3">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted">Explore</p>
            <ul class="mt-5 space-y-3 text-sm">
                <li><a class="hover:text-terracotta" href="{{ route('collection.index') }}">Collection</a></li>
                <li><a class="hover:text-terracotta" href="{{ route('materials.index') }}">Materials</a></li>
                <li><a class="hover:text-terracotta" href="{{ route('virtual-fitting') }}">Virtual Fitting</a></li>
                <li><a class="hover:text-terracotta" href="{{ route('about') }}">About</a></li>
            </ul>
        </div>

        <div class="lg:col-span-4">
            <p class="text-[11px] uppercase tracking-[0.24em] text-muted">Atelier</p>
            <p class="mt-5 text-sm leading-relaxed text-ink">{{ config('fitvendor.contact.location') }}</p>
            <p class="mt-2 text-sm text-ink">{{ config('fitvendor.contact.email') }}</p>
            <a class="mt-6 inline-block text-[11px] uppercase tracking-[0.22em] text-terracotta hover:text-terracotta-dark" href="{{ route('order.create') }}">
                Request a garment
            </a>
        </div>
    </div>

    <div class="border-t border-line">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-6 text-[11px] uppercase tracking-[0.18em] text-muted sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p>&copy; {{ date('Y') }} FitVendor</p>
            <p>Custom clothing, made to order</p>
        </div>
    </div>
</footer>
