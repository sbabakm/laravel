<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function getValues(Request $request){
        $attr = Attribute::where('name', $request['name'])->first();
        //dd($attr->values->toArray());
        //return $attr->values;
        return response()->json([
            'data' => $attr->values->pluck('value')
        ]);
    }
}
