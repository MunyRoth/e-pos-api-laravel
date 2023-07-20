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
        $items = Item::where(['store_id' => $storeId])
            ->where(['is_deleted' => 0])
            ->get();

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

            if (Item::where('UPC', $request['UPC'])->exists()) {
                return Response([
                    'status' => 409,
                    'message' => 'item exists',
                    'data' => ''
                ], 409);
            }

            $item = new Item;

            if ($request->hasFile('image')) {
                $imageUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'ePOS'
                ])->getSecurePath();

                $item['image_url'] = $imageUrl;
            } else {
                $item['image_url'] = "https://res.cloudinary.com/dlb5onqd6/image/upload/v1673491430/data/logo_ioru7h.png";
            }

            $item['UPC'] = $request->input('UPC');
            $item['name'] = $request->input('name');
            $item['price'] = 0;
            $item['cost'] = 0;
            $item['quantity'] = 0;
            $item['VAT'] = 0;
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
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): Response
    {
        $item = Item::find($id);

        if ($item) {
            $item->update([
                'is_deleted' => true
            ]);

            return Response([
                'status' => 200,
                'message' => 'deleted successfully',
                'data' => $item
            ], 200);
        }

        return Response([
            'status' => 404,
            'message' => 'not found',
            'data' => ''
        ], 404);
    }
}
