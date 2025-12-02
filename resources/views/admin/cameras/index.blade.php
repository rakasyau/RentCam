@extends('layouts.guest')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Daftar Inventaris Kamera</h3>
        <a href="{{ route('cameras.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kamera Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive"><table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Foto</th>
                        <th>Nama Kamera</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga / Hari</th>
                        <th>Stok</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cameras as $index => $camera)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$camera->image_path) }}" width="100" class="img-thumbnail">
                        </td>
                        <td>{{ $camera->name }}</td>
                        <td><span class="badge bg-secondary">{{ $camera->category }}</span></td>
                        <td>
                            <small class="text-muted">{{ Str::limit($camera->description, 50) }}</small>
                        </td>
                        <td>Rp {{ number_format($camera->price_per_day) }}</td>
                        <td class="{{ $camera->quantity == 0 ? 'text-danger fw-bold' : '' }}">
                            {{ $camera->quantity }} Unit
                        </td>
                        <td>
                            <a href="{{ route('cameras.edit', $camera->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <form action="{{ route('cameras.destroy', $camera->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kamera ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div></div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
    </div>
</div>
@endsection