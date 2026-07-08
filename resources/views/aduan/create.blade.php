<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Tambah Aduan Baru</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-3xl mx-auto">
        <div class="p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-300 rounded text-red-700 text-sm">
                    <p class="font-bold mb-1">Terdapat kesalahan input:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Baris 1: Kanal & Klasifikasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">
                            Kanal Aduan <span class="text-red-500">*</span>
                        </label>
                        <select name="kanal" required
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">-- Pilih Kanal --</option>
                            @foreach($listKanal as $k)
                                <option value="{{ $k }}" {{ old('kanal') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">
                            Klasifikasi <span class="text-red-500">*</span>
                        </label>
                        <select name="klasifikasi" required
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">-- Pilih Klasifikasi --</option>
                            @foreach($listKlasifikasi as $kl)
                                <option value="{{ $kl }}" {{ old('klasifikasi') == $kl ? 'selected' : '' }}>{{ $kl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Baris 2: Nama Pelapor & Nama Akun --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">
                            Nama Pelapor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required
                            placeholder="Nama lengkap pelapor"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Akun Sosmed</label>
                        <input type="text" name="nama_akun" value="{{ old('nama_akun') }}"
                            placeholder="Contoh: @namauser"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                {{-- Baris 3: Kontak & Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Kontak Pelapor</label>
                        <input type="text" name="kontak_pelapor" value="{{ old('kontak_pelapor') }}"
                            placeholder="No. HP / Email"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">
                            Tanggal Aduan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_aduan" value="{{ old('tanggal_aduan', date('Y-m-d')) }}" required
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                {{-- Isi Aduan --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Isi Aduan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi_aduan" rows="4" required
                        placeholder="Tulis isi aduan secara lengkap..."
                        class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('isi_aduan') }}</textarea>
                </div>

                {{-- Screenshot --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Screenshot Aduan</label>
                    <input type="file" name="screenshot" accept="image/*"
                        class="w-full border border-gray-300 rounded-md p-2 text-sm text-gray-600
                               file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0
                               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks: 5MB</p>
                </div>

                {{-- Status Respon --}}
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Status Respon</h4>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="sudah_direspon" id="sudah_direspon" value="1"
                            {{ old('sudah_direspon') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                            onchange="document.getElementById('isiResponDiv').classList.toggle('hidden', !this.checked)">
                        <span class="text-sm text-gray-700 font-medium">Sudah Direspon</span>
                    </label>
                    <div id="isiResponDiv" class="{{ old('sudah_direspon') ? '' : 'hidden' }} mt-3">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Isi Respon</label>
                        <textarea name="isi_respon_awal" rows="3"
                            placeholder="Tuliskan isi respon yang sudah diberikan..."
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('isi_respon_awal') }}</textarea>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('aduan.index') }}"
                       class="px-5 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-medium">Batal</a>
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">Simpan Aduan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
