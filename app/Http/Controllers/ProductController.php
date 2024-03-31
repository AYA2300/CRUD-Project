<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateeProductRequest;
use App\Models\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $product=Products::all();
        if( !$product->isEmpty()){

            return response()->json([
                'status'=>"Done",
                "products"=>$product,


            ]);
        }
        else{
            return response()->json([
                'status'=>"Failed",
                "products"=>"empty",]);

        }



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try{
            DB::beginTransaction();
            $product= Products::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'description'=>$request->description,
                'quantity'=>$request->quantity,
                'image'=>$request->file('image')->store('images'),


            ]);
            DB::commit();
            return response()->json([
                'status'=>"success",
                "message"=>"product created successfully",
                'productName'=>$product->name
            ]);

        }
        catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status'=>"Faild"],
                500 );


        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Products $id)
    {
        return response()->json([
            'status'=>"success",
            'products'=>$id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateeProductRequest $request, Products $id)
    {
        $newData=[];
        try{
           DB::beginTransaction();

         if (isset($request->name)){
            $newData['name']=$request->name;
         }
         if (isset($request->price)){
            $newData['price']=$request->price;
         }
         if (isset($request->description)){
            $newData['description']=$request->description;
         }

         if (isset($request->quantity)){
            $newData['quantity']=$request->quantity;
         }
           if (isset($request->image)){
            $newData['image']=$request->image;
         }



          DB::commit();
         $id->update($newData);
        return response()->json([
            'status'=>"success",
            "message"=>"product updated successfully"]);

        }

        catch(\Throwable $th){
            DB::rollBack();
            log::error($th);
            return response()->json([
               'status'=>"Failed"],500);


         }








    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $id)
    {
        $id->delete();
        return response()->json([
            "message"=>"product deleted successfully",



        ]);
    }
}
