<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Detail Aduan — <span class="text-blue-700">{{ $aduan->nomor_aduan }}</span>
            </h2>
            <a href="{{ route('aduan.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ===== Informasi Aduan (3/5 lebar) ===== --}}
        <div class="lg:col-span-3 space-y-4">

            {{-- Info Utama --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-blue-800">Informasi Aduan</h3>
                    {{-- Badge status respon --}}
                    @if($aduan->sudah_direspon)
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full border border-green-200 font-semibold">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Sudah Direspon
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full border border-red-200 font-semibold">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            Belum Direspon
                        </span>
                    @endif
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider">Tanggal Aduan</dt>
                            <dd class="mt-1 font-semibold">{{ \Carbon\Carbon::parse($aduan->tanggal_aduan)->isoFormat('D MMMM Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider">Petugas Input</dt>
                            <dd class="mt-1 font-semibold">{{ $aduan->petugas->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider">Kanal</dt>
                            <dd class="mt-1">
                                @if($aduan->kanal)
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded font-semibold">{{ $aduan->kanal }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider">Klasifikasi</dt>
                            <dd class="mt-1">
                                @if($aduan->klasifikasi)
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded font-semibold">{{ $aduan->klasifikasi }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Nama Pelapor</dt>
                        <dd class="font-bold text-lg text-gray-800">{{ $aduan->nama_pelapor }}</dd>
                        @if($aduan->nama_akun)
                            <dd class="text-sm text-indigo-600 mt-0.5">{{ $aduan->nama_akun }}</dd>
                        @endif
                        @if($aduan->kontak_pelapor)
                            <dd class="text-sm text-gray-500 mt-0.5">{{ $aduan->kontak_pelapor }}</dd>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2">Isi Aduan</dt>
                        <dd class="text-gray-700 text-sm leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100">{{ $aduan->isi_aduan }}</dd>
                    </div>
                </div>
            </div>

            {{-- Screenshot --}}
            @if($aduan->screenshot_path)
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-blue-800">Screenshot Aduan</h3>
                </div>
                <div class="p-6">
                    <a href="{{ asset('storage/' . $aduan->screenshot_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $aduan->screenshot_path) }}"
                            alt="Screenshot Aduan"
                            class="max-h-80 rounded-lg border border-gray-200 hover:opacity-90 transition cursor-zoom-in w-auto">
                    </a>
                    <p class="text-xs text-gray-400 mt-2">Klik gambar untuk buka di tab baru</p>
                </div>
            </div>
            @endif

            {{-- Respon yang sudah tersimpan di aduan --}}
            @if($aduan->sudah_direspon && $aduan->isi_respon_awal)
            <div class="bg-green-50 border border-green-200 shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-green-200">
                    <h3 class="font-bold text-green-800">Respon Tercatat</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $aduan->isi_respon_awal }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- ===== Panel Respon (2/5 lebar) ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden sticky top-4">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-blue-800">Riwayat Tanggapan</h3>
                </div>
                <div class="p-6">

                    {{-- Daftar respon lama --}}
                    @if($aduan->respon->count() > 0)
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto pr-1">
                            @foreach($aduan->respon as $respon)
                            <div class="p-3 rounded-lg border bg-blue-50 border-blue-200">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-xs font-bold text-blue-800">
                                        {{ $respon->user->name ?? '-' }}
                                        <span class="font-normal text-blue-600">({{ ucfirst($respon->user->role ?? '') }})</span>
                                    </span>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($respon->tanggal_respon)->format('d M Y') }}</span>
                                </div>
                                <p class="text-xs text-gray-700 leading-relaxed">{{ $respon->isi_respon }}</p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic mb-6">Belum ada tanggapan dari Kepala Bidang.</p>
                    @endif

                    {{-- Form respon: HANYA untuk kepala_bidang --}}
                    @if(Auth::user()->role === 'kepala_bidang')
                        <form action="{{ route('aduan.respon.store', $aduan->id) }}" method="POST" class="border-t pt-4">
                            @csrf
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Tulis Tanggapan</label>
                            <textarea name="isi_respon" rows="4" required
                                placeholder="Tulis tanggapan resmi di sini..."
                                class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 mb-3"></textarea>

                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Update Status Respon</label>
                            <div class="flex gap-3 mb-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sudah_direspon" value="1"
                                        {{ $aduan->sudah_direspon ? 'checked' : '' }}
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="text-sm text-green-700 font-medium">Sudah Direspon</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sudah_direspon" value="0"
                                        {{ !$aduan->sudah_direspon ? 'checked' : '' }}
                                        class="text-red-600 focus:ring-red-500">
                                    <span class="text-sm text-red-700 font-medium">Belum Direspon</span>
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-bold py-2.5 px-4 rounded-lg hover:bg-blue-700 transition text-sm">
                                Kirim Tanggapan
                            </button>
                        </form>
                    @else
                        <div class="border-t pt-4">
                            <p class="text-xs text-gray-400 text-center italic">Hanya Kepala Bidang yang dapat memberikan tanggapan resmi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
