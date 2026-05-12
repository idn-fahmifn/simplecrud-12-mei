@extends('template.template')

@section('title')
    Riwayat Kategori
@endsection

@section('sub-title')
    Kategori terhapus sementara
@endsection

@section('table-title')
    Daftar kategori yang dihapus sementara
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
                    <td class="d-flex gap-2">
                        <form action="{{ route('category.restore', $category->uuid) }}" method="post">
                            @method('patch')
                            <button type="submit" onclick="return confirm('Pulihkan kategori ini?')"
                                class="btn btn-sm btn-secondary">Pulihkan</button>
                        </form>

                        <form action="{{ route('category.force', $category->uuid) }}" method="post">
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('hapus permanen tidak akan bisa memulihkan data. yakin anda akan melakukannya?')">
                                Hapus kategori
                            </button>
                        </form>
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
