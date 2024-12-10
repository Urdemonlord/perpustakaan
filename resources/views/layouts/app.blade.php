<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan - @yield('title')</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .sidebar {
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
        }
        
        .sidebar .nav-link {
            color: white;
            padding: 15px 25px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background: #34495e;
            padding-left: 35px;
        }
        
        .sidebar .nav-link.active {
            background: #3498db;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .btn {
            border-radius: 5px;
            padding: 8px 20px;
        }
        
        .table thead th {
            background: #f8f9fa;
        }
        
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
        
        .navbar {
            margin-left: 250px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <h4>PERPUSTAKAAN</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                    <i class="fas fa-book me-2"></i> Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('kategori*') ? 'active' : '' }}" href="{{ url('/kategori') }}">
                    <i class="fas fa-tags me-2"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('anggota*') ? 'active' : '' }}" href="{{ url('/anggota') }}">
                    <i class="fas fa-users me-2"></i> Anggota
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('peminjaman*') ? 'active' : '' }}" href="{{ url('/peminjaman') }}">
                    <i class="fas fa-handshake me-2"></i> Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('denda*') ? 'active' : '' }}" href="{{ url('/denda') }}">
                    <i class="fas fa-money-bill me-2"></i> Denda
                </a>
            </li>
        </ul>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <h5 class="mb-0">@yield('title')</h5>
            <div class="ms-auto">
                <span class="text-muted me-3">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // DataTables initialization
        $(document).ready(function() {
            $('.datatable').DataTable();
        });

        // Delete confirmation
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Success message
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
    
    @yield('scripts')
</body>
</html> 