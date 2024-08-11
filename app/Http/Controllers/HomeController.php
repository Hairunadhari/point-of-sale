<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    public function home(){
        $kategori = Kategori::all();
        return view('home',compact('kategori'));
    }

    public function cetak(Request $request){
        if ($request->order_name == null) {
            return back()->with(['warning'=>'Tidak bisa cetak bill dikarenakan menu bill kosong.']);
        }
        $data = [
            'order_name'=>$request->order_name,
            'order_qty'=>$request->order_qty,
            'order_price'=>$request->order_price,
            'total'=>$request->total,
        ];
        // dd($item);
        $pdf = PDF::loadView('cetak-pdf',compact('data'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('bill-'.now().'.pdf');
        // return view('cetak-pdf',compact('data'));
    }
}
