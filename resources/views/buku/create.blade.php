@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tambah Buku Baru</h5>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode_buku" class="form-label">Kode Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_buku') is-invalid @enderror" 
                               id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}" required>
                        @error('kode_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" 
                               id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required>
                        @error('judul_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pengarang" class="form-label">Pengarang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pengarang') is-invalid @enderror" 
                               id="pengarang" name="pengarang" value="{{ old('pengarang') }}" required>
                        @error('pengarang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('penerbit') is-invalid @enderror" 
                               id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" 
                               id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" 
                               min="1900" max="{{ date('Y') }}" required>
                        @error('tahun_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_buku" class="form-label">Jumlah Buku <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah_buku') is-invalid @enderror" 
                               id="jumlah_buku" name="jumlah_buku" value="{{ old('jumlah_buku') }}" 
                               min="0" required>
                        @error('jumlah_buku')
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

    // Tahun terbit tidak boleh lebih dari tahun sekarang
    document.getElementById('tahun_terbit').max = new Date().getFullYear();

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