<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AspirasiController extends Controller
{
    public function index (){
        $aspirasi = Aspirasi::withTrashed()->where('id_user', Auth::id())->with(['user', 'category', 'feedback.user' => function($query) {$query->withTrashed();}])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Aspirasi',
            'data'    => $aspirasi
        ], 200);
    }
    function create(Request $request){
        $request->validate([
            'title' => 'nullable',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
            'lokasi' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'in:Draft,Pending'
        ]);

        $fotopath = null;
        if($request-> hasFile('foto')){
            $fotopath = $request->file('foto')->store('aspirasi', 'public');
        }


        $aspirasi= Aspirasi::create([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotopath,
            'id_user' => Auth::id(),
            'lokasi' => $request->lokasi,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'massage' => 'Succes',
            'Aspirasi' => $aspirasi,
        ], 201);
    }

    function update(Request $request, string $id){
        $request->validate([
            'title' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
            'lokasi' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $draft = Aspirasi::where('id', $id)->first();

        $fotopath = $draft->foto;
        if($request-> hasFile('foto')){
            $fotopath = $request->file('foto')->store('aspirasi', 'public');
        }

        $draft->update([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotopath,
            'id_user' => Auth::id(),
            'lokasi' => $request->lokasi,
            'category_id' => $request->category_id ?? null,
            'status' => 'Pending'
        ]);

        return response()->json([
            'data berhasil dipublish',
            $draft
        ]);
    }

    function delete($id){
        $aspirasi = Aspirasi::find($id);

        $aspirasi->delete();

        return response()->json([
            'data terhapus'
        ]);
    }
    function forcedelete($id){
        $aspirasi = Aspirasi::onlyTrashed()->find($id);

        $aspirasi->forceDelete();
        return response()->json([
            'data terhapus'
        ]);
    }
    function destroy($id){
        $aspirasi = Aspirasi::where('status','Draft' )->find($id);
        $aspirasi->delete();
        $aspirasi->forceDelete();

        return response()->json([
            'data terhapus'
        ]);
    }


}