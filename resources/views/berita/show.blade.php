<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - {{ config('app.name', 'Sipesat') }}</title>
    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #1F6E43;
        }
        .article-header {
            background: linear-gradient(135deg, #1F6E43 0%, #144d2e 100%);
            padding: 80px 0 60px;
            color: white;
            text-align: center;
        }
        .article-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            margin-top: -40px;
            padding: 40px;
            background-color: white;
        }
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
        }
        .footer-custom {
            background-color: #fff;
            border-top: 1px solid #eaeaea;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('landing') }}"><i class="fa-solid fa-leaf text-white me-2"></i> SIPESAT</a>
            <div>
                <a href="{{ route('landing') }}" class="btn btn-outline-light rounded-pill px-4">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <!-- Header Berita -->
    <div class="article-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-success rounded-pill px-3 py-2 mb-3 fs-6">{{ ucwords($berita->kategori) }}</span>
                    <h1 class="fw-bold mb-4">{{ $berita->judul }}</h1>
                    <div class="d-flex justify-content-center align-items-center opacity-75">
                        <span class="me-4"><i class="fa-regular fa-calendar me-2"></i> {{ $berita->created_at->translatedFormat('d F Y') }}</span>
                        <span class="me-4"><i class="fa-solid fa-user me-2"></i> {{ $berita->penulis->name ?? 'Admin' }}</span>
                        <span><i class="fa-solid fa-eye me-2"></i> {{ $berita->views }}x dibaca</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Berita -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="article-card">
                    <img src="{{ $berita->thumbnail ? Storage::url($berita->thumbnail) : asset('images/no-image.png') }}" 
                         onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" 
                         alt="{{ $berita->judul }}" class="img-fluid rounded mb-4 w-100" style="max-height: 400px; object-fit: cover;">
                    
                    <div class="article-content">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Bagikan Artikel Ini</h5>
                            <div>
                                <button class="btn btn-light rounded-circle me-2" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}', '_blank')"><i class="fa-brands fa-facebook-f text-primary"></i></button>
                                <button class="btn btn-light rounded-circle me-2" onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}', '_blank')"><i class="fa-brands fa-twitter text-info"></i></button>
                                <button class="btn btn-light rounded-circle" onclick="window.open('https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}', '_blank')"><i class="fa-brands fa-whatsapp text-success"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-custom py-4 mt-auto">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} SIPESAT Magetan. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
