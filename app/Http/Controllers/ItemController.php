<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Store;
use App\Models\StoreBranch;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($storeId): Response
    {
        $items = Item::where(['store_id' => $storeId])->get();

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $items
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request): Response
    {
        $store = Store::find($request->input('store_id'));

        if ($store) {

            $imageUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'ePOS'
            ])->getSecurePath();

            $item = new Item;
            $item['UPC'] = $request->input('UPC');
            $item['image_url'] = $imageUrl;
            $item['name'] = $request->input('name');
            $item['price'] = 0;
            $item['cost'] = 0;
            $item['quantity'] = 0;
            $item['tax'] = 0;
            $item['discount'] = 0;
            $store->items()->save($item);

            return Response([
                'status' => 201,
                'message' => 'uploaded successfully',
                'data' => $item
            ], 201);
        }

        return Response([
            'status' => 404,
            'message' => 'not found',
            'data' => ''
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
