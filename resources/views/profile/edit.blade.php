<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-white leading-tight">
                    {{ __('Profil Saya') }}
                </h2>
                <p class="text-sm text-blue-100 mt-0.5">Kelola informasi profil dan kata sandi Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <p class="font-semibold mb-1">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow-sm border border-slate-200 sm:rounded-2xl">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-slate-900">
                                {{ __('Informasi Profil') }}
                            </h2>
                            <p class="mt-1 text-sm text-slate-600">
                                {{ __("Perbarui informasi nama dan kata sandi akun Anda.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Nama Lengkap') }}</label>
                                <input id="name" name="name" type="text" class="w-full border-slate-200 rounded-xl text-sm mt-1 block" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Kata Sandi Baru') }}</label>
                                <input id="password" name="password" type="password" class="w-full border-slate-200 rounded-xl text-sm mt-1 block" autocomplete="new-password" placeholder="Biarkan kosong jika tidak ingin mengubah" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full border-slate-200 rounded-xl text-sm mt-1 block" autocomplete="new-password" />
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-medium text-sm transition">
                                    {{ __('Simpan Perubahan') }}
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
