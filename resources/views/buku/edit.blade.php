<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
</head>
<body>
    <h1>Edit Buku</h1>
    
    <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="kode_buku">Kode Buku:</label>
            <input type="text" id="kode_buku" name="kode_buku" value="{{ $buku->kode_buku }}" required>
        </div>
        
        <div>
            <label for="judul_buku">Judul Buku:</label>
            <input type="text" id="judul_buku" name="judul_buku" value="{{ $buku->judul_buku }}" required>
        </div>
        
        <div>
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang" value="{{ $buku->pengarang }}" required>
        </div>
        
        <div>
            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="{{ $buku->penerbit }}" required>
        </div>
        
        <div>
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" required>
        </div>
        
        <div>
            <label for="jumlah_buku">Jumlah Buku:</label>
            <input type="number" id="jumlah_buku" name="jumlah_buku" value="{{ $buku->jumlah_buku }}" required>
        </div>
        
        <button type="submit">Update</button>
        <a href="{{ url('/buku') }}">Batal</a>
    </form>
</body>
</html> 