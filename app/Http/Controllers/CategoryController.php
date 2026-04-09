<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index(){
        $category= Category::all();

        return response()->json([$category]);
    }
    function store(Request $request){
        $request->validate([
            'nama_kategori'=> 'required|unique:categories.nama_kategori',
        ]);

        $category = Category::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json([
            'messege' => 'data telah ditambahkan',
            'data' => $category
        ]);
    }
    function update(Request $request,$id){
        $request->validate([
            'nama_kategori'=> 'required|unique:categories.nama_kategori',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        return response()->json([
            'messege' => 'data telah diubah',
            'data' => $category
        ]);
    }
    function delete($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'messege' => 'data telah dihapus',
            'data' => $category
        ]);
    }


}
