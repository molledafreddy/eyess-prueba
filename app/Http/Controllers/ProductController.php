<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;
use DB;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->inRandomOrder()->limit(10)->get();

        return response()->json(compact('products'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'max:255',
            'price' => 'required|numeric',
            'category_id' => "exists:categories,id",
        ]);

       if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        do {
           $random_id = mt_rand( 1000000000, 9999999999 );
        }while ( DB::table( 'products' )->where( 'id', $random_id )->exists() );
        
        $fields= $request->all();
        $fields['id'] = $random_id;
        $product = Product::create($fields);
        
        return response()->json(compact('product'), 200);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with('category')->first();

        return response()->json(compact('product'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'price' => 'required|numeric',
            'description' => 'max:255',
            'category_id' => "exists:categories,id",
        ]);

       if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }
        
        if ($request->has('name')) {
            $product->name =$request->name;}
        if ($request->has('price')) {
            $product->name =$request->price;}
        if ($request->has('email')) {
            $product->email = $request->email;}
        if ($request->has('description')) {
            $product->description = $request->description;}

        if (!$product->isDirty()) {
            return response()->json(['error'=> "Debe especificar al menos un valor diferente para actualizar"], 422);
        }

        return response()->json(compact('product'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->json(compact('product'), 200);
    }
}
