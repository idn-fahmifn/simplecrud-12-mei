@extends('template.template')

@section('title')
    Detail Kategori
@endsection

@section('sub-title')
    {{ $category->category_name }}
@endsection

@section('table-title')
    Barang yang ada pada kategori {{ $category->category_name }}
@endsection

@section('list-button')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Edit kategori
    </button>

    <form action="{{ route('category.destroy', $category->uuid) }}" method="post">
        @method('delete')
        <button type="submit" class="btn btn-secondary" onclick="return confirm('yakin mau dipulihkan')">
            Hapus kategori
        </button>
    </form>

    <form action="{{ route('category.force', $category->uuid) }}" method="post">
        @method('delete')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('hapus permanen tidak akan bisa memulihkan data. yakin an')">
            Hapus kategori
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

    <table class="table table-striped">
        <thead>
            <th>Nama Barang</th>
            <th>Stok Barang</th>
            <th>Pilihan</th>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>
                        <a href="{{ route('item.show', $item->uuid) }}" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('category.update', $category->uuid) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="namaKategori" id="namaKategori"
                                value="{{ old('namaKategori', $category->category_name) }}"
                                class="form-control @error('namaKategori') is-invalid @enderror">
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
