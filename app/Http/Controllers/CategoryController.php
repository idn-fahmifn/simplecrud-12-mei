<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Category;




class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaKategori' => ['required','string','min:5', 'max:60'],
        ]);

        $simpan = [
            'category_name'=> $request->input('namaKategori'),
            'uuid' => Str::uuid7()
        ];

        Category::create($simpan);

        return back()->with('success', 'Data berhasil disimpan');
    }
    public function show($param)
    {
        $category = Category::where('uuid', $param)->firstOrFail();
        return view('categories.show', compact('category'));
    }
    public function update(Request $request, $param)
    {
        $category = Category::where('uuid', $param)->firstOrFail();

        $request->validate([
            'namaKategori' => ['required','string','min:5', 'max:60'],
        ]);
        
        $simpan = [
            'category_name'=> $request->input('namaKategori'),
            'uuid' => Str::uuid7()
        ];

        $category->update($simpan);
        return redirect()->route('category.show', $category->uuid)->with('success','Kategori berhasil diubah');
        
    }

    public function destroy($param)
    {
        $category = Category::where('uuid',$param)->firstOrFail();
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Kategori dihapus sementara');
    }

    // riwayat yang terhapus
    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('categories.trash', compact('categories'));
    }

    public function restore($param)
    {
        $category = Category::withTrashed()->where('uuid', $param)->firstOrFail();
        $category->restore();
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dipulihkan');
    }

    public function force($param)
    {
        $category = Category::withTrashed()->where('uuid', $param)->firstOrFail();
        $category->forceDelete();
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dipulihkan');
    }



}
