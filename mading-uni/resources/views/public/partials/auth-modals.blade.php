{{-- ============================================================
     MODAL LOGIN
     ============================================================ --}}
<div x-show="loginOpen" x-cloak
     @keydown.escape.window="loginOpen = false"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">

    <div x-show="loginOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="loginOpen = false"
         class="absolute inset-0 bg-ink/60 backdrop-blur-sm"></div>

    <div x-show="loginOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.outside="loginOpen = false"
         class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">

        {{-- Header --}}
        <div class="relative bg-brand-gradient p-7 text-white overflow-hidden rounded-t-3xl">
            <div class="blob blob-brand w-40 h-40 -top-10 -right-10 opacity-60"></div>

            <button @click="loginOpen = false"
                    class="absolute top-4 right-4 p-2 rounded-lg text-white/80 hover:bg-white/20 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="relative z-10">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center mb-3">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                </div>
                <h2 class="text-2xl font-bold">Masuk</h2>
                <p class="text-white/80 text-sm mt-1">Selamat datang kembali di Mading Indonesia.</p>
            </div>
        </div>

        {{-- Form --}}
        <div class="p-7">
            @if($errors->any() && !request()->routeIs('register'))
                <div class="alert alert-error mb-5 text-sm">
                    <div class="flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="modal_login_email" class="label">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_login_email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               class="input pl-10"
                               placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label for="modal_login_password" class="label">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <i data-lucide="lock" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_login_password"
                               :type="show ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="current-password"
                               class="input pl-10 pr-10"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-soft hover:text-ink-muted">
                            <i data-lucide="eye" x-show="!show" class="w-4 h-4"></i>
                            <i data-lucide="eye-off" x-show="show" x-cloak class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="remember"
                           class="rounded border-surface-border text-brand-700 focus:ring-brand-500">
                    <span class="text-ink-muted">Ingat saya di perangkat ini</span>
                </label>

                <button type="submit" class="btn btn-primary w-full">
                    Masuk
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>

                <div class="text-center text-sm text-ink-muted pt-2 border-t border-surface-border">
                    Belum punya akun?
                    <button type="button" @click="loginOpen = false; registerOpen = true"
                            class="text-brand-700 font-semibold hover:underline">
                        Daftar sekarang
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- ============================================================
     MODAL REGISTER
     ============================================================ --}}
<div x-show="registerOpen" x-cloak
     @keydown.escape.window="registerOpen = false"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">

    <div x-show="registerOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="registerOpen = false"
         class="absolute inset-0 bg-ink/60 backdrop-blur-sm"></div>

    <div x-show="registerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.outside="registerOpen = false"
         class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">

        <div class="relative bg-brand-gradient p-7 text-white overflow-hidden rounded-t-3xl">
            <div class="blob blob-brand w-40 h-40 -top-10 -right-10 opacity-60"></div>

            <button @click="registerOpen = false"
                    class="absolute top-4 right-4 p-2 rounded-lg text-white/80 hover:bg-white/20 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="relative z-10">
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center mb-3">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <h2 class="text-2xl font-bold">Daftar</h2>
                <p class="text-white/80 text-sm mt-1">Gratis. Cuma butuh 30 detik.</p>
            </div>
        </div>

        <div class="p-7">
            @if($errors->any() && request()->routeIs('register'))
                <div class="alert alert-error mb-5 text-sm">
                    <div class="flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="modal_register_name" class="label">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_register_name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autocomplete="name"
                               class="input pl-10"
                               placeholder="Nama kamu">
                    </div>
                </div>

                <div>
                    <label for="modal_register_email" class="label">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_register_email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               class="input pl-10"
                               placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label for="modal_register_password" class="label">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <i data-lucide="lock" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_register_password"
                               :type="show ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="new-password"
                               class="input pl-10 pr-10"
                               placeholder="Minimal 8 karakter">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-soft hover:text-ink-muted">
                            <i data-lucide="eye" x-show="!show" class="w-4 h-4"></i>
                            <i data-lucide="eye-off" x-show="show" x-cloak class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p class="help-text">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label for="modal_register_password_confirmation" class="label">Konfirmasi Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-ink-soft absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input id="modal_register_password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="input pl-10"
                               placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    Buat Akun
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>

                <div class="text-center text-sm text-ink-muted pt-2 border-t border-surface-border">
                    Sudah punya akun?
                    <button type="button" @click="registerOpen = false; loginOpen = true"
                            class="text-brand-700 font-semibold hover:underline">
                        Masuk
                    </button>
                </div>

                <p class="text-xs text-center text-ink-muted">
                    Dengan mendaftar, kamu setuju dengan
                    <a href="#" class="text-brand-700 hover:underline">Syarat & Ketentuan</a>
                    kami.
                </p>
            </form>
        </div>

    </div>
</div>