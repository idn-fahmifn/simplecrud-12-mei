@extends('template.template')

@section('title')
    Kategori Barang
@endsection

@section('sub-title')
    Data semua kategori barang.
@endsection

@section('table-title')
    Tabel Kategori
@endsection

@section('list-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Buat Baru
    </button>
    <a href="{{ route('category.trash') }}" class="btn btn-secondary">Riwayat</a>
@endsection

@section('table-content')
    <table class="table table-striped">
        <thead>
            <th>Nama Kategori</th>
            <th>Jumlah Barang</th>
            <th>Pilihan</th>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>10</td>
                    <td>
                        <a href="{{ route('category.show', $category->uuid) }}" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="alert alert-light text-center" role="alert">
                            Data kategori tidak ditemukan.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('category.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="namaKategori" id="namaKategori" value="{{ old('namaKategori') }}" class="form-control @error('namaKategori') is-invalid @enderror">
                            @error('namaKategori')
                                <div id="namaKategori" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
