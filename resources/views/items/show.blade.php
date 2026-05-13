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
        <button type="submit" class="btn btn-secondary" onclick="return confirm('yakin mau dipulihkan')">
            Hapus Barang
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
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Nama Barang</td>
                        <td>{{ $item->name }}</td>
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
            <img src="{{ asset('storage/images/items/' . $item->image) }}" alt="Gambar Produk" class="img-fluid" width="240">
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



            </div>
        </div>
    </div>
@endsection
