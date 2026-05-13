<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\{Category, Item};

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $categories = Category::all();
        return view("items.index", compact("items", "categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaBarang' => ['required','string','min:3', 'max:30'],
            'stokBarang' => ['required','integer','min:0', 'max:999'],
            'hargaBarang' => ['required','integer', 'min:500'],
            'gambarBarang' => ['required','file', 'mimes:png,jpg,jpeg,webp,svg'],
            'deskripsiBarang' => ['required'],
            'kategori' => ['required', 'exists:categories,id'],
        ]);

        $simpan = [
            'name' => $request->input('namaBarang'),
            'stock' => $request->input('stokBarang'),
            'price' => $request->input('hargaBarang'),
            'desc' => $request->input('deskripsiBarang'),
            'category_id' => $request->input('kategori'),
            'uuid' => Str::uuid7()
        ];

        if($request->hasFile('gambarBarang')){
            $gambar = $request->file('gambarBarang');
            $path = 'public/images/items';
            // nama file wajib unique : item_image_20260513103945456.png
            $nama = 'item_image_' . Carbon::now('Asia/Jakarta')->format('Ymdhis') . random_int(000, 999) . '.' . $gambar->getClientOriginalExtension();
            $simpan['image'] = $nama;

            // simpan ke storage
            $gambar->storeAs($path, $nama);
        }

        Item::create($simpan);

        return back()->with('success', 'Barang berhasil disimpan');

    }

    public function show($param)
    {
        $item = Item::where('uuid',$param)->firstOrFail();
        return view('items.show',compact('item'));
    }
}
