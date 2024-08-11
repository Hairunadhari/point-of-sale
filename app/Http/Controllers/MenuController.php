<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
    public function index(){
        $data = Menu::paginate(5);
        $kategori = Kategori::all();
        return view('menu',compact('data','kategori'));
    }

    public function submit(Request $request){
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/image', $gambar->hashName());
        Menu::create([
            'kategori_id'=>$request->kategori_id,
            'name'=>$request->name,
            'price'=>$request->price,
            'gambar'     => $gambar->hashName(),
        ]);
        return redirect('/menu')->with(['success'=>'Data berhasil ditambah.']);
    }

    public function update(Request $request, $id){
        $menu = Menu::find($id);
        $menuData = [
            'kategori_id'=>$request->kategori_id,
            'name'=>$request->name,
            'price'=>$request->price,
        ];

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');            
            $menuData['gambar'] = $gambar->hashName();
            $gambar->storeAs('public/image', $menuData['gambar']);
        }
        $menu->update($menuData);
        return redirect('/menu')->with(['success'=>'Data berhasil diupdate.']);
    }
    
    public function delete($id){
        $menu = Menu::find($id);
        $menu->delete();
        return redirect('/menu')->with(['success'=>'Data berhasil dihapus.']);
    }
}
