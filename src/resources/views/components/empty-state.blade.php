@props(['title' => 'Nothing here yet', 'message' => 'Please check back shortly.'])

<div class="border border-dashed border-line px-8 py-16 text-center">
    <p class="font-serif text-3xl text-charcoal">{{ $title }}</p>
    <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">{{ $message }}</p>
    {{ $slot }}
</div>
