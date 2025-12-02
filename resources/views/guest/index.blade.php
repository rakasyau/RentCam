@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <div class="container mt-4 mt-lg-5"> <div class="row mb-4 align-items-center g-3"> <div class="col-lg-6 text-center text-lg-start">
            <h2 class="fw-bold mb-0" style="color: var(--text-color);">Katalog Kamera</h2>
            <p class="text-muted mb-0 small">Temukan perlengkapan terbaik untukmu</p>
        </div>
        
        <div class="col-lg-6">
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group shadow-sm glass" style="border-radius: 50px; padding: 5px;">
                    <input type="text" name="search" 
                           class="form-control border-0 bg-transparent shadow-none ps-4" 
                           placeholder="Cari nama kamera..." 
                           value="{{ request('search') }}"
                           style="color: var(--text-color);">
                    
                    <button class="btn btn-primary rounded-pill px-4" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex gap-2 overflow-auto pb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
                
                <a href="{{ route('home') }}" 
                   class="btn {{ !request('category') ? 'btn-primary' : 'glass' }} rounded-pill px-4 flex-shrink-0"
                   style="{{ !request('category') ? '' : 'color: var(--text-color); border: 1px solid var(--glass-border);' }}">
                   <i class="fas fa-border-all me-2"></i>Semua
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat, 'search' => request('search')]) }}" 
                       class="btn {{ request('category') == $cat ? 'btn-primary' : 'glass' }} rounded-pill px-4 flex-shrink-0"
                       style="{{ request('category') == $cat ? '' : 'color: var(--text-color); border: 1px solid var(--glass-border);' }}">
                       {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

   
    @if($cameras->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-circle"></i> 
            Maaf, kamera dengan kata kunci <strong>"{{ request('search') }}"</strong> tidak ditemukan.
        </div>
    @endif
    <div class="row">
        @foreach($cameras as $cam)
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background-color: white;">
                    <img src="{{ asset('storage/'.$cam->image_path) }}" class="card-img-top" alt="{{ $cam->name }}" style="max-width: 50%; margin: auto; display: block;">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $cam->name }}</h5>
                    <span class="badge bg-secondary">{{ $cam->category }}</span>
                    <p class="card-text">{{ Str::limit($cam->description, 50) }}</p>
                    <p class="fw-bold">Rp {{ number_format($cam->price_per_day) }} / hari</p>
                    <p class="text-muted">Stok: {{ $cam->quantity }}</p>

                    @if($cam->quantity > 0)
                        <form action="{{ route('cart.add', $cam->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Tambahkan</button>
                        </form>
                    @else
                        <button class="btn btn-danger w-100" disabled>Habis</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if(session('cart'))
        <div class="fixed-bottom bg-light p-3 border-top">
            <div class="container d-flex justify-content-between">
                <h4 class="text-black">Item di Keranjang: {{ count(session('cart')) }}</h4>
                <a href="{{ route('cart.view') }}" class="btn btn-success">Lihat Detail & Booking</a>
            </div>
        </div>
    @endif
</div>
@endsection