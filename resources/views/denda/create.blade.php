@extends('layouts.app')

@section('title', 'Tambah Denda')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Denda Baru</h5>
        <a href="{{ route('denda.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('denda.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_peminjaman" class="form-label">Peminjaman <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_peminjaman') is-invalid @enderror" 
                                id="id_peminjaman" name="id_peminjaman" required>
                            <option value="" selected disabled>Pilih Peminjaman</option>
                            @foreach($peminjaman as $item)
                                <option value="{{ $item->id_peminjaman }}" 
                                    {{ old('id_peminjaman') == $item->id_peminjaman ? 'selected' : '' }}
                                    data-tanggal-kembali="{{ $item->tanggal_kembali }}">
                                    {{ $item->kode_peminjaman }} - {{ $item->anggota->nama }} 
                                    ({{ $item->buku->judul_buku }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_peminjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_denda" class="form-label">Tanggal Denda <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_denda') is-invalid @enderror" 
                               id="tanggal_denda" name="tanggal_denda" value="{{ old('tanggal_denda', date('Y-m-d')) }}" 
                               required>
                        @error('tanggal_denda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah_hari" class="form-label">Jumlah Hari Terlambat</label>
                        <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" 
                               value="{{ old('jumlah_hari', 0) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_denda" class="form-label">Jumlah Denda (Rp)</label>
                        <input type="number" class="form-control" id="jumlah_denda" name="jumlah_denda" 
                               value="{{ old('jumlah_denda', 0) }}" readonly>
                        <small class="text-muted">Denda per hari: Rp 1.000</small>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="belum dibayar" {{ old('status') == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="sudah dibayar" {{ old('status') == 'sudah dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="reset" class="btn btn-secondary me-2">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // Hitung denda otomatis
    function hitungDenda() {
        const peminjaman = document.getElementById('id_peminjaman');
        const tanggalDenda = document.getElementById('tanggal_denda');
        
        if (peminjaman.value && tanggalDenda.value) {
            const tanggalKembali = new Date(peminjaman.options[peminjaman.selectedIndex].dataset.tanggalKembali);
            const tanggalPengembalian = new Date(tanggalDenda.value);
            
            // Hitung selisih hari
            const selisihHari = Math.max(0, Math.floor((tanggalPengembalian - tanggalKembali) / (1000 * 60 * 60 * 24)));
            document.getElementById('jumlah_hari').value = selisihHari;
            
            // Hitung denda (Rp 1.000 per hari)
            const denda = selisihHari * 1000;
            document.getElementById('jumlah_denda').value = denda;
        }
    }

    // Event listeners
    document.getElementById('id_peminjaman').addEventListener('change', hitungDenda);
    document.getElementById('tanggal_denda').addEventListener('change', hitungDenda);

    // Sweet Alert untuk sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection 