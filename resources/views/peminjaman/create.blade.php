@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Peminjaman Baru</h5>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_peminjaman" class="form-label">Kode Peminjaman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_peminjaman') is-invalid @enderror" 
                               id="kode_peminjaman" name="kode_peminjaman" value="{{ old('kode_peminjaman') }}" 
                               required autofocus>
                        @error('kode_peminjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_anggota" class="form-label">Anggota <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_anggota') is-invalid @enderror" 
                                id="id_anggota" name="id_anggota" required>
                            <option value="" selected disabled>Pilih Anggota</option>
                            @foreach($anggota as $item)
                                <option value="{{ $item->id_anggota }}" 
                                    {{ old('id_anggota') == $item->id_anggota ? 'selected' : '' }}>
                                    {{ $item->kode_anggota }} - {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_buku" class="form-label">Buku <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_buku') is-invalid @enderror" 
                                id="id_buku" name="id_buku" required>
                            <option value="" selected disabled>Pilih Buku</option>
                            @foreach($buku as $item)
                                <option value="{{ $item->id_buku }}" 
                                    {{ old('id_buku') == $item->id_buku ? 'selected' : '' }}
                                    {{ $item->jumlah_buku < 1 ? 'disabled' : '' }}>
                                    {{ $item->kode_buku }} - {{ $item->judul_buku }} 
                                    (Stok: {{ $item->jumlah_buku }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                               id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                               required>
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                               id="tanggal_kembali" name="tanggal_kembali" 
                               value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" 
                               required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ old('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
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

    // Validasi tanggal
    document.getElementById('tanggal_pinjam').addEventListener('change', function(e) {
        let tanggalPinjam = new Date(e.target.value);
        let tanggalKembali = new Date(tanggalPinjam);
        tanggalKembali.setDate(tanggalKembali.getDate() + 7);
        
        document.getElementById('tanggal_kembali').min = e.target.value;
        document.getElementById('tanggal_kembali').value = tanggalKembali.toISOString().split('T')[0];
    });

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