<x-admin-panel-layout>
    <x-slot name="header">Verifikasi Berkas Masuk</x-slot>

    <div class="space-y-6 w-full pb-12">
        {{-- Tombol Kembali --}}
        <div class="mb-2">
            <a href="{{ route('admin.permohonan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-red-600 font-bold transition-colors group">
                <div class="w-8 h-8 flex items-center justify-center bg-white rounded-lg border border-gray-200 group-hover:border-red-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        {{-- Action Bar --}}
        <div class="flex justify-between items-center bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 ml-4">
                <div>
                    <span class="text-sm font-black text-gray-400 uppercase tracking-widest">Tiket: {{ $permohonan->nomor_tiket }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mr-2">
                <div class="px-6 py-2 bg-gray-900 text-white rounded-xl text-[10px] font-black tracking-widest uppercase">Admin Verificator</div>
                <div class="px-6 py-2 {{ $permohonan->sisa_waktu <= 3 ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-xl text-[10px] font-black tracking-widest uppercase">
                    Sisa Waktu: {{ $permohonan->sisa_waktu }} Hari
                </div>
            </div>
        </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm text-sm">
            <p class="font-black mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Data Pemohon --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center border-b pb-3 uppercase text-xs tracking-wider">Data Pemohon</h3>
                <div class="space-y-5">
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase">Nama Lengkap</label>
                        <p class="font-bold text-gray-700">{{ $permohonan->nama_pemohon }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase">Pekerjaan</label>
                        <p class="font-bold text-gray-700">{{ $permohonan->pekerjaan }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase">NIK</label>
                        <p class="font-bold text-gray-700">{{ $permohonan->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase">Email</label>
                        <p class="font-bold text-gray-700">{{ $permohonan->email }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase">Tanggal Pengajuan</label>
                        <p class="font-bold text-gray-700">{{ $permohonan->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>

                    <hr class="border-gray-100">
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase block mb-2">Lampiran KTP</label>
                        @if($permohonan->foto_ktp)
                            <a href="{{ asset('uploads/ktp/' . $permohonan->foto_ktp) }}" target="_blank" class="block group">
                                <img src="{{ asset('uploads/ktp/' . $permohonan->foto_ktp) }}" 
                                     class="w-full rounded-2xl border-2 border-gray-100 hover:border-red-200 transition-all shadow-sm" 
                                     alt="KTP Pemohon">
                                <p class="text-[10px] text-blue-500 mt-2 font-bold italic text-center group-hover:underline">KLIK UNTUK MEMPERBESAR</p>
                            </a>
                        @else
                            <p class="text-xs text-red-500 italic font-bold">File KTP tidak ditemukan</p>
                        @endif
                    </div>

                    @if($permohonan->file_pendukung)
                    <hr class="border-gray-100 my-4">
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase block mb-2">File Pendukung</label>
                        <a href="{{ asset('uploads/permohonan/pendukung/' . $permohonan->file_pendukung) }}" target="_blank" class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-100 rounded-xl text-blue-600 font-bold hover:bg-blue-600 hover:text-white transition">
                            <i class="fa-solid fa-file-arrow-down"></i> Unduh File
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail & Aksi --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Detail Informasi --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="mb-8">
                    <label class="text-[10px] text-gray-400 font-bold uppercase mb-2 block tracking-widest">Informasi Yang Diminta</label>
                    <div class="p-6 bg-red-50 rounded-2xl border border-red-100 italic text-gray-800 text-lg leading-relaxed break-words">
                        "{{ $permohonan->rincian_informasi }}"
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Tujuan Penggunaan</label>
                        <p class="text-gray-700 font-bold italic break-words">{{ $permohonan->tujuan_penggunaan }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-400 font-bold uppercase block mb-1">Cara Memperoleh</label>
                        <p class="text-gray-700 font-bold italic">{{ $permohonan->cara_memperoleh }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabel Riwayat Disposisi OPD --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <h4 class="font-black text-gray-700 mb-4 text-xs uppercase tracking-widest border-b pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Riwayat Disposisi ke OPD
                </h4>

                @if($permohonan->opds->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                    <th class="px-4 py-3 text-left">Instansi OPD</th>
                                    <th class="px-4 py-3 text-left">Tgl. Disposisi</th>
                                    <th class="px-4 py-3 text-left">Tgl. Tanggapan</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($permohonan->opds as $opd)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 font-bold text-gray-800">{{ $opd->nama_opd }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        @if($opd->pivot->disposisi_at)
                                            <div class="font-bold">{{ \Carbon\Carbon::parse($opd->pivot->disposisi_at)->translatedFormat('l') }}</div>
                                            <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($opd->pivot->disposisi_at)->format('d/m/Y H:i') }}</div>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        @if($opd->pivot->tanggapi_at)
                                            <div class="font-bold">{{ \Carbon\Carbon::parse($opd->pivot->tanggapi_at)->translatedFormat('l') }}</div>
                                            <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($opd->pivot->tanggapi_at)->format('d/m/Y H:i') }}</div>
                                        @else
                                            <span class="text-xs text-orange-400 font-bold italic">Belum menanggapi</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($opd->pivot->status === 'ditanggapi')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black">✓ Ditanggapi</span>
                                        @else
                                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-[10px] font-black">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($opd->pivot->tanggapan)
                                <tr class="bg-green-50">
                                    <td colspan="4" class="px-4 py-2">
                                        <p class="text-[10px] text-green-600 font-black uppercase mb-1">Tanggapan dari {{ $opd->nama_opd }}:</p>
                                        <p class="text-xs text-gray-700 italic">{{ $opd->pivot->tanggapan }}</p>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <p class="text-xs font-bold italic">Belum ada disposisi ke OPD</p>
                    </div>
                @endif
            </div>

            {{-- Form Disposisi Multi-OPD --}}
            <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm">
                <h4 class="font-black text-blue-800 mb-4 text-xs uppercase tracking-widest border-b border-blue-100 pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Disposisi ke OPD
                </h4>

                @php
                    $disposisiIds = $permohonan->opds->pluck('id')->toJson();
                @endphp

                <form action="{{ route('admin.permohonan.disposisi', $permohonan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Search filter --}}
                    <input type="text" id="opdSearchShow" onkeyup="filterOpdShow()" placeholder="Cari OPD..."
                           class="w-full mb-3 rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">

                    <div id="opdCheckboxListShow" class="max-h-56 overflow-y-auto space-y-1 border border-gray-100 rounded-xl p-3 bg-gray-50">
                        @foreach($opds as $opd)
                        @php $alreadyDisposisi = $permohonan->opds->contains('id', $opd->id); @endphp
                        <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50 cursor-pointer transition opd-show-item" data-name="{{ strtolower($opd->nama_opd) }}">
                            <input type="checkbox" name="opd_ids[]" value="{{ $opd->id }}"
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   {{ $alreadyDisposisi ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 flex-1">{{ $opd->nama_opd }}</span>
                            @if($alreadyDisposisi)
                                @php $pivotOpd = $permohonan->opds->find($opd->id); @endphp
                                @if($pivotOpd && $pivotOpd->pivot->status === 'ditanggapi')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Ditanggapi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">
                                        Terkirim
                                    </span>
                                @endif
                            @endif
                        </label>
                        @endforeach
                    </div>

                    <div class="mt-3 flex justify-between items-center">
                        <div class="flex gap-3">
                            <button type="button" onclick="selectAllOpdShow()" class="text-xs text-blue-600 font-bold hover:underline">Pilih Semua</button>
                            <span class="text-gray-200">|</span>
                            <button type="button" onclick="deselectAllOpdShow()" class="text-xs text-red-500 font-bold hover:underline">Tidak Pilih Semua</button>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 shadow-md transition-all active:scale-95">
                            Simpan Disposisi
                        </button>
                    </div>
                </form>
            </div>

            {{-- Form Update Status --}}
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h4 class="font-black text-gray-700 mb-6 text-xs uppercase tracking-widest border-b pb-3">Verifikasi & Tanggapan PPID</h4>

                <form action="{{ route('admin.permohonan.update', $permohonan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">Pilih Status Verifikasi</label>
                        <select name="status" class="w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-0 p-4 text-sm font-bold bg-gray-50">
                            <option value="pending" {{ $permohonan->status == 'pending' ? 'selected' : '' }}>PENDING (MENUNGGU)</option>
                            <option value="diverifikasi" {{ $permohonan->status == 'diverifikasi' ? 'selected' : '' }}>DIVERIFIKASI (PROSES)</option>
                            <option value="selesai" {{ $permohonan->status == 'selesai' ? 'selected' : '' }}>SELESAI / KIRIM JAWABAN</option>
                            <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>DITOLAK</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">
                            Tanggapan / Jawaban Resmi
                            <span class="text-red-400 ml-1 normal-case font-normal">(Wajib diisi jika status Selesai atau Ditolak)</span>
                        </label>
                        <textarea name="tanggapan" rows="6"
                                  class="w-full rounded-3xl border-gray-200 focus:border-red-600 focus:ring-0 p-5 text-sm font-medium bg-gray-50 @error('tanggapan') border-red-400 @enderror"
                                  placeholder="Tuliskan jawaban permohonan atau alasan penolakan secara mendetail di sini...">{{ old('tanggapan', $permohonan->tanggapan) }}</textarea>
                        @error('tanggapan')
                            <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 shadow-xl shadow-red-200 transition-all active:scale-95">
                            Simpan Perubahan & Kirim
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function filterOpdShow() {
            const val = document.getElementById('opdSearchShow').value.toLowerCase();
            document.querySelectorAll('.opd-show-item').forEach(item => {
                item.style.display = item.dataset.name.includes(val) ? '' : 'none';
            });
        }
        function selectAllOpdShow() {
            document.querySelectorAll('#opdCheckboxListShow input[type=checkbox]').forEach(cb => cb.checked = true);
        }
        function deselectAllOpdShow() {
            document.querySelectorAll('#opdCheckboxListShow input[type=checkbox]').forEach(cb => cb.checked = false);
        }
    </script>
    </div>
</x-admin-panel-layout>