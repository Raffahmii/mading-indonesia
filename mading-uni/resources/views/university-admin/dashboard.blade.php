<x-layouts.university-admin>
    <x-slot name="title">Dashboard</x-slot>

    <div class="card">
        <div class="card-body">
            <h2 class="text-xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}!</h2>
            <p class="text-ink-muted">Dashboard admin {{ $theme->name }} sedang dibangun.</p>
            <div class="mt-4 flex gap-2">
                <button class="btn btn-university">Tombol University</button>
                <span class="badge badge-brand">Badge Brand</span>
            </div>
        </div>
    </div>
</x-layouts.university-admin>