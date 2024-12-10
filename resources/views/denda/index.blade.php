@extends('layouts.app')

@section('title', 'Daftar Denda')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Denda</h5>
        <a href="{{ route('denda.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Denda
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjaman</th>
                    <th>Tanggal Denda</th>
                    <th>Jumlah Hari</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($denda as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->peminjaman->kode_peminjaman }}</td>
                    <td>{{ $item->tanggal_denda }}</td>
                    <td>{{ $item->jumlah_hari }} hari</td>
                    <td>Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'belum dibayar' ? 'danger' : 'success' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('denda.edit', $item->id_denda) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('denda.destroy', $item->id_denda) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-confirm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 