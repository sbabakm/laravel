<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();

        if($keyword = request('search')) {
            $products = $products->where('title' , 'LIKE' , "%{$keyword}%")->orWhere('id', $keyword);
        }



        //$home = $home->latest()->paginate(12);
        $products = $products->orderBy('id','desc')->paginate(12);

        return view('admin.home.all' , compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'price' => ['required'],
            'inventory' => ['required'],
        ]);

        auth()->user()->products()->create($validate_data);

        return redirect(route('admin.home.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.home.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validate_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'price' => ['required'],
            'inventory' => ['required'],
        ]);

        $product->update($validate_data);

        return redirect(route('admin.home.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
