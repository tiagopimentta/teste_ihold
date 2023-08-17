<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchants;
use App\Models\User;

class MerchantsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $merchants = Merchants::all();
           return response()->json($merchants);
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
        $merchants = $request->all();
        Merchants::create($merchants);
        return response()->json("Registered Customer With Successe");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merchants = Merchants::find($id);
        return response()->json($merchants);
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
        $id = $id;
        $data = $request->only(['merchant_name','admin_id']);
        $merchants = Merchants::find($id);
        $merchants->update($data);
        return response()->json("Altered Customer With Successe");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merchants = Merchants::find($id);
        $merchants->delete();
        return response()->json("Deleted Customer With Successe");    
    }
}
