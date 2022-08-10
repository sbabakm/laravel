<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
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
            $products->where('title' , 'LIKE' , "%{$keyword}%")->orWhere('id', $keyword);
        }



        //$products = $products->latest()->paginate(12);
        $products = $products->orderBy('id','desc')->paginate(12);

        //return $products;

        return view('admin.products.all' , compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->file('image'));
        //dd($request->file('image')->getExtension());
        //dd($request->file('image')->getClientOriginalExtension());
        //dd($request->file('image')->getClientOriginalName());
        //dd($request->file('image')->getClientMimeType());

        //$file = $request->file('image');
        //$file->move(public_path('imagesTest'), 'abcd.'.$file->getClientOriginalExtension());
        //$file->move(public_path('imagesTest'), $file->getClientOriginalName());

//        $request->validate([
//            'image' => 'required|image'
//            'image' => 'required|mimes:jpg,jpeg'
//            'image' => 'required|mimes:png,jpg,jpeg|max:10'
//        ]);


//        $file = $request->file('image');
//        $destinationPath = '/imagesTest/' . now()->year . '/' . now()->month . '/' . now()->day . '/' ;
//        $file->move( public_path($destinationPath) , $file->getClientOriginalName());


        $validate_data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'price' => ['required'],
            'inventory' => ['required'],
            'categories' => ['array'],
            'attributes' => ['array'],
            'image' => 'required|mimes:png,jpg,jpeg|max:1000'
        ]);

        $file = $request->file('image');
        $destinationPath = '/imagesTest/' . now()->year . '/' . now()->month . '/' . now()->day . '/' ;
        $file->move( public_path($destinationPath) , $file->getClientOriginalName());

        $validate_data['image'] = $destinationPath . $file->getClientOriginalName();

        $product = auth()->user()->products()->create($validate_data);

        $product->categories()->sync($validate_data['categories']);

        $attributes = collect($validate_data['attributes']);

        $attributes->each(function ($item) use ($product) {

            if(is_null($item['name']) || is_null($item['value']))
                return true;//continue

            $attr = Attribute::firstOrCreate([
                'name' => $item['name']
            ]);

            $value = $attr->values()->firstOrCreate([
                'value' => $item['value']
            ]);

            $product->attributes()->attach($attr->id , ['value_id' => $value->id]);

        });

        return redirect(route('admin.products.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //dd($product->attributes->toArray());
        //$temp = $product->attributes->toArray();
        //dd($temp);
        //dd($temp[0]['pivot']);

        return view('admin.products.edit', compact('product'));
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
            'categories' => ['array'],
            'attributes' => ['array']
        ]);

        $product->update($validate_data);
        $product->categories()->sync($validate_data['categories']);

        $attributes = collect($validate_data['attributes']);

        $product->attributes()->detach();

        $attributes->each(function ($item) use ($product) {

            if(is_null($item['name']) || is_null($item['value']))
                return true;//continue

            $attr = Attribute::firstOrCreate([
                'name' => $item['name']
            ]);

            $value = $attr->values()->firstOrCreate([
                'value' => $item['value']
            ]);

            $product->attributes()->attach($attr->id , ['value_id' => $value->id]);

        });

        return redirect(route('admin.products.index'));

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

    public function productValuesBaseCategoryID(Request $request){
        //dd($request->all());
        $category = Category::find($request['categoryID']);
        //dd($category->products);
        return response()->json([
            'data' => $category->products
        ]);
    }

}
