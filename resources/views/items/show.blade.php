@extends('template.template')

@section('title')
    Detail Item
@endsection

@section('sub-title')
    {{ $item->name }}
@endsection

@section('table-title')
    Detail Spesifikasi {{ $item->name }}
@endsection

@section('list-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Edit Barang
    </button>

    <form action="{{ route('item.destroy', $item->uuid) }}" method="post">
        @method('delete')
        <button type="submit" class="btn btn-secondary"
            onclick="return confirm('yakin mau dihapus? Anda masih bisa memulihkannya')">
            Pindahkan ke sampah
        </button>
    </form>

    <form action="{{ route('item.force', $item->uuid) }}" method="post">
        @method('delete')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('hapus permanen tidak akan bisa memulihkan data. yakin anda akan melakukannya?')">
            Hapus permanen
        </button>
    </form>
@endsection

@section('table-content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- jika gagal --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terdapat kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Nama Barang</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <td>Kategori Barang</td>
                        <td>
                            {{ $item->category === null ? 'Kategori tidak ditemukan' : $item->category->category_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>Harga Barang</td>
                        <td>Rp. {{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td>{{ $item->stock }} unit</td>
                    </tr>
                    <tr>
                        <td>Tentang produk</td>
                        <td>{{ $item->desc }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('storage/images/items/' . $item->image) }}" alt="Gambar Produk" class="img-fluid"
                width="240">
        </div>
    </div>


    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('item.update', $item->uuid) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group my-2">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" name="namaBarang" id="namaBarang"
                                value="{{ old('namaBarang', $item->name) }}"
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
                                    <option value="{{ $item->category_id }}"
                                        {{ old('kategori', $item->category_id) == $category->id ? 'selected' : '' }}>
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
                            <input type="number" name="hargaBarang" id="hargaBarang"
                                value="{{ old('hargaBarang', $item->price) }}"
                                class="form-control @error('hargaBarang') is-invalid @enderror">
                            @error('hargaBarang')
                                <div id="hargaBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="stokBarang" class="form-label">Stok Barang</label>
                            <input type="number" name="stokBarang" id="stokBarang"
                                value="{{ old('stokBarang', $item->stock) }}"
                                class="form-control @error('stokBarang') is-invalid @enderror">
                            @error('stokBarang')
                                <div id="stokBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="gambarBarang" class="form-label">Gambar Barang</label>
                            <input type="file" accept="image/*" name="gambarBarang" id="gambarBarang"
                                value="{{ old('gambarBarang') }}"
                                class="form-control @error('gambarBarang') is-invalid @enderror">
                            @error('gambarBarang')
                                <div id="gambarBarang" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group my-2">
                            <label for="deskripsiBarang" class="form-label">Deskripsi Barang</label>
                            <textarea name="deskripsiBarang" id="deskripsiBarang"
                                class="form-control @error('deskripsiBarang') is-invalid @enderror">{{ old('deskripsiBarang', $item->desc) }}</textarea>
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
