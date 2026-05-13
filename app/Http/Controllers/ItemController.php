<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\{Category, Item};

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaBarang' => ['required', 'string', 'min:3', 'max:30'],
            'stokBarang' => ['required', 'integer', 'min:0', 'max:999'],
            'hargaBarang' => ['required', 'integer', 'min:500'],
            'gambarBarang' => ['required', 'file', 'mimes:png,jpg,jpeg,webp,svg'],
            'deskripsiBarang' => ['required'],
            'kategori' => ['required', 'exists:categories,id'],
        ]);

        $simpan = [
            'name' => $request->input('namaBarang'),
            'stock' => $request->input('stokBarang'),
            'price' => $request->input('hargaBarang'),
            'desc' => $request->input('deskripsiBarang'),
            'category_id' => $request->input('kategori'),
            'uuid' => Str::uuid7(),
        ];

        if ($request->hasFile('gambarBarang')) {
            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'item_image_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        Item::create($simpan);

        return back()->with('success', 'Barang berhasil disimpan');

    }

    public function show($param)
    {
        $item = Item::where('uuid', $param)->firstOrFail();
        $categories = Category::all();

        return view('items.show', compact('item', 'categories'));
    }

    public function update(Request $request, $param)
    {

        $data = Item::where('uuid', $param)->firstOrFail();

        $request->validate([
            'namaBarang' => ['required', 'string', 'min:3', 'max:30'],
            'stokBarang' => ['required', 'integer', 'min:0', 'max:999'],
            'hargaBarang' => ['required', 'integer', 'min:500'],
            'gambarBarang' => ['file', 'mimes:png,jpg,jpeg,webp,svg'],
            'deskripsiBarang' => ['required'],
            'kategori' => ['required', 'exists:categories,id'],
        ]);

        $simpan = [
            'name' => $request->input('namaBarang'),
            'stock' => $request->input('stokBarang'),
            'price' => $request->input('hargaBarang'),
            'desc' => $request->input('deskripsiBarang'),
            'category_id' => $request->input('kategori'),
            'uuid' => Str::uuid7(),
        ];

        if ($request->hasFile('gambarBarang')) {

            $path_lama = 'public/images/items/'.$data->image;

            if ($data->image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'item_image_'.Carbon::now('Asia/Jakarta')->format('Ymdhis').random_int(000, 999).'.'.$gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        $data->update($simpan);

        return redirect()->route('item.show', $data->uuid)->with('success', 'Barang berhasil diedit');

    }

    public function destroy($param)
    {
        $item = Item::where('uuid', $param)->firstOrFail();
        $item->delete();

        return redirect()->route('item.index')->with('success', 'Barang dihapus sementara');
    }

    // riwayat yang terhapus
    public function trash()
    {
        $items = Item::onlyTrashed()->get();

        return view('items.trash', compact('items'));
    }

    public function restore($param)
    {
        $item = Item::withTrashed()->where('uuid', $param)->firstOrFail();
        $item->restore();

        return redirect()->route('item.index')->with('success', 'Barang berhasil dipulihkan');
    }

    public function force($param)
    {
        $item = Item::withTrashed()->where('uuid', $param)->firstOrFail();
        $path_lama = 'public/images/items/'.$item->image;

        if ($item->image && Storage::exists($path_lama)) {
            Storage::delete($path_lama);
        }
        $item->forceDelete();

        return redirect()->route('item.index')->with('success', 'Barang berhasil dihapus permanen');
    }
}
