<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('aduan.index') }}"
                   class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="font-bold text-xl text-slate-800">Detail Aduan</h1>
                    <p class="text-sm text-blue-600 font-mono mt-0.5">{{ $aduan->nomor_aduan }}</p>
                </div>
            </div>

            {{-- Badge status --}}
            @if($aduan->sudah_direspon)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                             bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Sudah Direspon
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                             bg-red-50 text-red-600 border border-red-200">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    Belum Direspon
                </span>
            @endif
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- ===== Kolom Kiri: Info Aduan (3/5) ===== --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Info Utama --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h2 class="font-bold text-slate-700 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Aduan
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Grid metadata --}}
                    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Tanggal Aduan</dt>
                            <dd class="font-semibold text-slate-800">
                                {{ \Carbon\Carbon::parse($aduan->tanggal_aduan)->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Petugas Input</dt>
                            <dd class="font-semibold text-slate-800">{{ $aduan->petugas->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Kanal</dt>
                            <dd>
                                @if($aduan->kanal)
                                    <span class="inline-block px-2.5 py-1 bg-indigo-50 text-indigo-700
                                                 border border-indigo-200 rounded-lg text-xs font-semibold">
                                        {{ $aduan->kanal }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Klasifikasi</dt>
                            <dd>
                                @if($aduan->klasifikasi)
                                    <span class="inline-block px-2.5 py-1 bg-violet-50 text-violet-700
                                                 border border-violet-200 rounded-lg text-xs font-semibold">
                                        {{ $aduan->klasifikasi }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </dd>
                        </div>
                    </div>

                    {{-- Pelapor --}}
                    <div class="pt-4 border-t border-slate-100">
                        <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Pelapor</dt>
                        <dd class="font-bold text-lg text-slate-800">{{ $aduan->nama_pelapor }}</dd>
                        @if($aduan->nama_akun)
                            <dd class="text-sm text-indigo-600 mt-0.5">{{ $aduan->nama_akun }}</dd>
                        @endif
                        @if($aduan->kontak_pelapor)
                            <dd class="text-sm text-slate-500 mt-0.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $aduan->kontak_pelapor }}
                            </dd>
                        @endif
                    </div>

                    {{-- Isi Aduan --}}
                    <div class="pt-4 border-t border-slate-100">
                        <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Isi Aduan</dt>
                        <dd class="text-slate-700 text-sm leading-relaxed bg-slate-50 p-4 rounded-xl
                                   border border-slate-100 whitespace-pre-wrap">{{ $aduan->isi_aduan }}</dd>
                    </div>
                </div>
            </div>

            {{-- Screenshot --}}
            @if($aduan->screenshot_path)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-bold text-slate-700 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Screenshot Aduan
                        </h2>
                    </div>
                    <div class="p-6">
                        <a href="{{ asset('storage/' . $aduan->screenshot_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $aduan->screenshot_path) }}"
                                 alt="Screenshot Aduan"
                                 class="max-h-80 rounded-xl border border-slate-200 hover:opacity-90 transition
                                        cursor-zoom-in shadow-sm">
                        </a>
                        <p class="text-xs text-slate-400 mt-2">Klik gambar untuk membuka di tab baru</p>
                    </div>
                </div>
            @endif

            {{-- Respon yang sudah tersimpan di aduan --}}
            @if($aduan->sudah_direspon && $aduan->isi_respon_awal)
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-emerald-200">
                        <h2 class="font-bold text-emerald-800 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Respon Tercatat
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $aduan->isi_respon_awal }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== Kolom Kanan: Panel Respon (2/5) ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-4">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50">
                    <h2 class="font-bold text-slate-700 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Riwayat Tanggapan
                    </h2>
                </div>

                <div class="p-6">
                    {{-- Daftar respon --}}
                    @if($aduan->respon->count() > 0)
                        <div class="space-y-3 mb-5 max-h-64 overflow-y-auto pr-1">
                            @foreach($aduan->respon as $respon)
                                <div class="p-3 rounded-xl border bg-blue-50 border-blue-200">
                                    <div class="flex justify-between items-start mb-1.5">
                                        <div>
                                            <span class="text-xs font-bold text-blue-800">
                                                {{ $respon->user->name ?? '—' }}
                                            </span>
                                            <span class="text-xs text-blue-500 ml-1">
                                                ({{ ucfirst($respon->user->role ?? '') }})
                                            </span>
                                        </div>
                                        <span class="text-xs text-slate-400 whitespace-nowrap ml-2">
                                            {{ \Carbon\Carbon::parse($respon->tanggal_respon)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-700 leading-relaxed">{{ $respon->isi_respon }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center gap-2 py-6 mb-5 text-slate-400">
                            <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-sm italic">Belum ada tanggapan dari Kepala Bidang.</p>
                        </div>
                    @endif

                    {{-- Form respon: hanya kepala_bidang --}}
                    @if(Auth::user()->role === 'kepala_bidang')
                        <form action="{{ route('aduan.respon.store', $aduan->id) }}" method="POST"
                              class="border-t border-slate-100 pt-4 space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tulis Tanggapan</label>
                                <textarea name="isi_respon" rows="4" required
                                          placeholder="Tulis tanggapan resmi di sini..."
                                          class="w-full border-slate-200 rounded-xl text-sm
                                                 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Update Status</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="sudah_direspon" value="1"
                                               {{ $aduan->sudah_direspon ? 'checked' : '' }}
                                               class="text-emerald-600 focus:ring-emerald-500">
                                        <span class="text-sm text-emerald-700 font-medium">Sudah Direspon</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="sudah_direspon" value="0"
                                               {{ !$aduan->sudah_direspon ? 'checked' : '' }}
                                               class="text-red-500 focus:ring-red-400">
                                        <span class="text-sm text-red-600 font-medium">Belum Direspon</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 text-white font-semibold py-2.5 px-4
                                           rounded-xl hover:bg-blue-700 transition text-sm shadow-sm">
                                Kirim Tanggapan
                            </button>
                        </form>
                    @else
                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-xs text-slate-400 text-center italic">
                                Hanya Kepala Bidang yang dapat memberikan tanggapan resmi.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
