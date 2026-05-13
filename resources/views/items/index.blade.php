@extends('template.template')

@section('title')
    Barang
@endsection

@section('sub-title')
    Data semua barang.
@endsection

@section('table-title')
    Tabel Barang
@endsection

@section('list-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Buat Baru
    </button>
    <a href="{{ route('item.trash') }}" class="btn btn-secondary">Riwayat</a>
@endsection

@section('table-content')
    <table class="table table-striped">
        <thead>
            <th>Nama Barang</th>
            <th>Stock</th>
            <th>Harga</th>
            <th>Pilihan</th>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>IDR. {{ number_format($item->price) }}</td>
                    <td>
                        <a href="{{ route('item.show', $item->uuid) }}" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="alert alert-light text-center" role="alert">
                            Data barang tidak ditemukan.
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group my-2">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" name="namaBarang" id="namaBarang" value="{{ old('namaBarang') }}"
                                class="form-control @error('namaBarang') is-invalid @enderror">
                            @error('namaBarang')
                                <div id="namaBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori"
                                class="form-control @error('kategori') is-invalid @enderror" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('kategori') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                @empty
                                    <option value="" disabled>Tidak ada kategori</option>
                                @endforelse
                            </select>
                            @error('kategori')
                                <div id="kategori" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="hargaBarang" class="form-label">Harga Barang</label>
                            <input type="number" name="hargaBarang" id="hargaBarang" value="{{ old('hargaBarang') }}"
                                class="form-control @error('hargaBarang') is-invalid @enderror">
                            @error('hargaBarang')
                                <div id="hargaBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="stokBarang" class="form-label">Stok Barang</label>
                            <input type="number" name="stokBarang" id="stokBarang" value="{{ old('stokBarang') }}"
                                class="form-control @error('stokBarang') is-invalid @enderror">
                            @error('stokBarang')
                                <div id="stokBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="gambarBarang" class="form-label">Stok Barang</label>
                            <input type="file" accept="image/*" name="gambarBarang" id="gambarBarang" value="{{ old('gambarBarang') }}"
                                class="form-control @error('gambarBarang') is-invalid @enderror">
                            @error('gambarBarang')
                                <div id="gambarBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="deskripsiBarang" class="form-label">Deskripsi Barang</label>
                            <textarea name="deskripsiBarang" id="deskripsiBarang" class="form-control @error('deskripsiBarang') is-invalid @enderror">{{ old('deskripsiBarang') }}</textarea>
                            @error('deskripsiBarang')
                                <div id="deskripsiBarang" class="invalid-feedback">
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
