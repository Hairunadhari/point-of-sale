<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(){
        $data = Kategori::paginate(5);
        return view('kategori',compact('data'));
    }

    public function submit(Request $request){
        Kategori::create([
            'kategori'=>$request->kategori
        ]);
        return redirect('/kategori')->with(['success'=>'Data berhasil ditambah.']);
    }

    public function update(Request $request, $id){
        $kategori = Kategori::find($id);
        $kategori->update([
            'kategori'=>$request->kategori
        ]);
        return redirect('/kategori')->with(['success'=>'Data berhasil diupdate.']);
    }
    
    public function delete($id){
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect('/kategori')->with(['success'=>'Data berhasil dihapus.']);
    }
}
