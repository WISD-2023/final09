<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 12);
        $products = Product::orderBy('id','DESC')->where('status',3)->paginate($perPage);
        $data = ['products' => $products];
        return view('index',$data);
    }
    public function detail()
    {
        $products = Product::orderby('id','ASC')->where('status',3)->get();
        $data = ['products' => $products];
        return view('detail',$data);
    }
}

