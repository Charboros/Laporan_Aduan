<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('aduan.index') }}"
               class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="font-bold text-xl text-slate-800">Tambah Aduan Baru</h1>
                <p class="text-sm text-slate-500 mt-0.5">Isi formulir di bawah untuk mencatat aduan</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">Form Input Aduan</span>
                </div>
            </div>

            <div class="p-6">
                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <p class="font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Terdapat kesalahan input:
                        </p>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('aduan.store') }}" method="POST"
                      enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Baris 1: Kanal & Klasifikasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Kanal Aduan <span class="text-red-500">*</span>
                            </label>
                            <select name="kanal" required
                                    class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                           focus:border-blue-400 focus:ring-2 focus:ring-blue-100 bg-white">
                                <option value="">— Pilih Kanal —</option>
                                @foreach($listKanal as $k)
                                    <option value="{{ $k }}" {{ old('kanal') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Klasifikasi <span class="text-red-500">*</span>
                            </label>
                            <select name="klasifikasi" required
                                    class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                           focus:border-blue-400 focus:ring-2 focus:ring-blue-100 bg-white">
                                <option value="">— Pilih Klasifikasi —</option>
                                @foreach($listKlasifikasi as $kl)
                                    <option value="{{ $kl }}" {{ old('klasifikasi') == $kl ? 'selected' : '' }}>{{ $kl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Nama Pelapor & Nama Akun --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Nama Pelapor <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_pelapor"
                                   value="{{ old('nama_pelapor') }}" required
                                   placeholder="Nama lengkap pelapor"
                                   class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                          focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Nama Akun Sosmed
                            </label>
                            <input type="text" name="nama_akun"
                                   value="{{ old('nama_akun') }}"
                                   placeholder="Contoh: @namauser"
                                   class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                          focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>

                    {{-- Baris 3: Kontak & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kontak Pelapor</label>
                            <input type="text" name="kontak_pelapor"
                                   value="{{ old('kontak_pelapor') }}"
                                   placeholder="No. HP / Email"
                                   class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                          focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Tanggal Aduan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_aduan"
                                   value="{{ old('tanggal_aduan', date('Y-m-d')) }}" required
                                   class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                          focus:border-blue-400 focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>

                    {{-- Isi Aduan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Isi Aduan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi_aduan" rows="4" required
                                  placeholder="Tulis isi aduan secara lengkap..."
                                  class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                         focus:border-blue-400 focus:ring-2 focus:ring-blue-100">{{ old('isi_aduan') }}</textarea>
                    </div>

                    {{-- Screenshot --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Screenshot Aduan</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 hover:border-blue-300 transition-colors">
                            <input type="file" name="screenshot" accept="image/*"
                                   class="w-full text-sm text-slate-500
                                          file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                                          file:bg-blue-50 file:text-blue-700 file:font-medium
                                          hover:file:bg-blue-100 file:transition-colors cursor-pointer">
                            <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG, WEBP — Maks. 5 MB</p>
                        </div>
                    </div>

                    {{-- Status Respon --}}
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <h4 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Status Respon
                        </h4>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="sudah_direspon" id="sudah_direspon" value="1"
                                   {{ old('sudah_direspon') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500"
                                   onchange="document.getElementById('isiResponDiv').classList.toggle('hidden', !this.checked)">
                            <span class="text-sm text-slate-700 font-medium">Aduan sudah direspon</span>
                        </label>
                        <div id="isiResponDiv" class="{{ old('sudah_direspon') ? '' : 'hidden' }} mt-3">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Isi Respon</label>
                            <textarea name="isi_respon_awal" rows="3"
                                      placeholder="Tuliskan isi respon yang sudah diberikan..."
                                      class="w-full border-slate-200 rounded-xl shadow-sm text-sm
                                             focus:border-blue-400 focus:ring-2 focus:ring-blue-100">{{ old('isi_respon_awal') }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                        <a href="{{ route('aduan.index') }}"
                           class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200
                                  text-sm font-semibold transition">Batal</a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700
                                       text-sm font-semibold transition shadow-sm">
                            Simpan Aduan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
