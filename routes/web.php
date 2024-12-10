<?php

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Petugas;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Route untuk login
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->with('error', 'Username atau password salah!');
})->name('login.authenticate');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Tambahkan middleware auth untuk semua route yang perlu dilindungi
Route::middleware(['auth'])->group(function () {
    // Halaman utama dengan daftar buku
    Route::get('/', function () {
        $buku = Buku::all();
        return view('welcome', compact('buku'));
    });

    // Route CRUD Buku
    Route::get('/buku', function () {
        $buku = Buku::all();
        return view('welcome', compact('buku'));
    })->name('buku.index');

    Route::get('/buku/create', function () {
        return view('buku.create');
    })->name('buku.create');

    Route::post('/buku', function (Request $request) {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:buku,kode_buku',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric|min:1900|max:'.date('Y'),
            'jumlah_buku' => 'required|numeric|min:0',
        ]);

        Buku::create($validated);
        
        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil ditambahkan!');
    })->name('buku.store');

    Route::get('/buku/{id}/edit', function ($id) {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    })->name('buku.edit');

    Route::put('/buku/{id}', function ($id, Request $request) {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());
        return redirect('/');
    })->name('buku.update');

    Route::delete('/buku/{id}', function ($id) {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return redirect('/');
    })->name('buku.destroy');

    // Daftar Kategori
    Route::get('/kategori', function () {
        $kategori = Kategori::all(); // Ambil semua kategori
        return view('kategori.index', compact('kategori'));
    })->name('kategori.index');

    Route::get('/kategori/create', function () {
        return view('kategori.create');
    })->name('kategori.create');

    Route::post('/kategori', function (Request $request) {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
        ]);

        Kategori::create($validated);
        
        return redirect()->route('kategori.index')
                        ->with('success', 'Kategori berhasil ditambahkan!');
    })->name('kategori.store');

    Route::get('/kategori/{id}/edit', function ($id) {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    })->name('kategori.edit');

    Route::put('/kategori/{id}', function ($id, Request $request) {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());
        return redirect('/kategori');
    })->name('kategori.update');

    Route::delete('/kategori/{id}', function ($id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect('/kategori');
    })->name('kategori.destroy');

    // Daftar Anggota
    Route::get('/anggota', function () {
        $anggota = Anggota::all();
        return view('anggota.index', compact('anggota'));
    })->name('anggota.index');

    Route::get('/anggota/create', function () {
        return view('anggota.create');
    })->name('anggota.create');

    Route::post('/anggota', function (Request $request) {
        $validated = $request->validate([
            'kode_anggota' => 'required|unique:anggota,kode_anggota',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'no_telp' => 'required|regex:/^[0-9]{10,13}$/',
        ]);

        Anggota::create($validated);
        
        return redirect()->route('anggota.index')
                        ->with('success', 'Anggota berhasil ditambahkan!');
    })->name('anggota.store');

    Route::get('/anggota/{id}/edit', function ($id) {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    })->name('anggota.edit');

    Route::put('/anggota/{id}', function ($id, Request $request) {
        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->all());
        return redirect('/anggota');
    })->name('anggota.update');

    Route::delete('/anggota/{id}', function ($id) {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect('/anggota');
    })->name('anggota.destroy');

    // Daftar Peminjaman
    Route::get('/peminjaman', function () {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->get();
        return view('peminjaman.index', compact('peminjaman'));
    })->name('peminjaman.index');

    Route::get('/peminjaman/create', function () {
        $anggota = Anggota::all();
        $buku = Buku::all();
        return view('peminjaman.create', compact('anggota', 'buku'));
    })->name('peminjaman.create');

    Route::post('/peminjaman', function (Request $request) {
        $validated = $request->validate([
            'kode_peminjaman' => 'required|unique:peminjaman,kode_peminjaman',
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        // Cek ketersediaan buku
        $buku = Buku::find($request->id_buku);
        if ($buku->jumlah_buku < 1) {
            return back()->withInput()->withErrors(['id_buku' => 'Buku tidak tersedia']);
        }

        // Kurangi stok buku
        $buku->decrement('jumlah_buku');
        
        Peminjaman::create($validated);
        
        return redirect()->route('peminjaman.index')
                        ->with('success', 'Peminjaman berhasil ditambahkan!');
    })->name('peminjaman.store');

    Route::get('/peminjaman/{id}/edit', function ($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = Anggota::all();
        $buku = Buku::all();
        return view('peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    })->name('peminjaman.edit');

    Route::put('/peminjaman/{id}', function ($id, Request $request) {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());
        return redirect('/peminjaman');
    })->name('peminjaman.update');

    Route::delete('/peminjaman/{id}', function ($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect('/peminjaman');
    })->name('peminjaman.destroy');

    // Daftar Denda
    Route::get('/denda', function () {
        $denda = Denda::with('peminjaman')->get();
        return view('denda.index', compact('denda'));
    })->name('denda.index');

    Route::get('/denda/create', function () {
        $peminjaman = Peminjaman::all();
        return view('denda.create', compact('peminjaman'));
    })->name('denda.create');

    Route::post('/denda', function (Request $request) {
        $validated = $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_denda' => 'required|date',
            'jumlah_hari' => 'required|integer|min:0',
            'jumlah_denda' => 'required|integer|min:0',
            'status' => 'required|in:belum dibayar,sudah dibayar',
        ]);

        Denda::create($validated);
        
        // Update status peminjaman jika denda sudah dibayar
        if ($request->status == 'sudah dibayar') {
            $peminjaman = Peminjaman::find($request->id_peminjaman);
            $peminjaman->update(['status' => 'dikembalikan']);
            
            // Kembalikan stok buku
            $buku = Buku::find($peminjaman->id_buku);
            $buku->increment('jumlah_buku');
        }
        
        return redirect()->route('denda.index')
                        ->with('success', 'Denda berhasil ditambahkan!');
    })->name('denda.store');

    Route::get('/denda/{id}/edit', function ($id) {
        $denda = Denda::findOrFail($id);
        $peminjaman = Peminjaman::all();
        return view('denda.edit', compact('denda', 'peminjaman'));
    })->name('denda.edit');

    Route::put('/denda/{id}', function ($id, Request $request) {
        $denda = Denda::findOrFail($id);
        $denda->update($request->all());
        return redirect('/denda');
    })->name('denda.update');

    Route::delete('/denda/{id}', function ($id) {
        $denda = Denda::findOrFail($id);
        $denda->delete();
        return redirect('/denda');
    })->name('denda.destroy');
});

