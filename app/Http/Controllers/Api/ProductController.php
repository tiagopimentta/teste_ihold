<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!$request->merchant_id){
            return response()->json("Merchant code does not found");
        }

        $dados_merchant = Merchant::find($request->merchant_id);//achou o id de usuario do merchant
        if(!$dados_merchant){
            return response()->json("Merchant code does not exist");
       }
        $verifica_admin = User::find($dados_merchant->admin_id);//achou se é admim ou nao

        if($verifica_admin->is_admin){
            $products = $request->all();
            Product::create($products);
            return response()->json("Registered Product With Successe");
       }else{
        return response()->json("You do not have permission to register a product");
       }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!$request->merchant_id){
            return response()->json("Merchant code does not found");
        }

        $dados_merchant = Merchant::find($request->merchant_id);//achou o id de usuario do merchant
        if(!$dados_merchant){
            return response()->json("Merchant code does not exist");
       }
        $verifica_admin = User::find($dados_merchant->admin_id);//achou se é admim ou nao

        if($verifica_admin->is_admin){
            $data = $request->only(['name','merchant_id','price','status']);
            $products = Product::find($id);
            $products->update($data);
        return response()->json("Altered Product With Successe");
        }else{
        return response()->json("You do not have permission to alter a product");
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if(!$request->merchant_id){
            return response()->json("Merchant code does not found");
        }

        $dados_merchant = Merchant::find($request->merchant_id);//achou o id de usuario do merchant
        if(!$dados_merchant){
            return response()->json("Merchant code does not exist");
       }
        $verifica_admin = User::find($dados_merchant->admin_id);//achou se é admim ou nao

        if($verifica_admin->is_admin){
            $products = Product::find($id);
            $products->delete();
            return response()->json("Deleted Product With Successe");
        }else{
            return response()->json("You do not have permission to delet a product");
        }
    }
}
