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
@endsection
