<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBranch;
use App\Http\Requests\StoreStoreBranchRequest;
use App\Http\Requests\UpdateStoreBranchRequest;
use Illuminate\Http\Response;

class StoreBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($storeId): Response
    {
        $branches = StoreBranch::where(['store_id' => $storeId])->get();

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $branches
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreBranchRequest $request): Response
    {
        $store = Store::find($request->input('store_id'));

        if ($store) {
            $branch = new StoreBranch;
            $branch['address_km'] = $request->input('address_km');
            $store->branches()->save($branch);

            return Response([
                'status' => 201,
                'message' => 'uploaded successfully',
                'data' => $branch
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
    public function show(StoreBranch $storeBranch): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $storeBranch
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreBranchRequest $request, StoreBranch $storeBranch): Response
    {
        if ($request->has('address_km')) {
            $storeBranch->update([
                'address_km' => $request->input('address_km')
            ]);
        }

        if ($request->has('address_en')) {
            $storeBranch->update([
                'address_en' => $request->input('address_en')
            ]);
        }

        if ($request->has('location')) {
            $storeBranch->update([
                'location' => $request->input('location')
            ]);
        }

        return Response([
            'status' => 200,
            'message' => 'updated successfully',
            'data' => $storeBranch
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreBranch $storeBranch): Response
    {
        $storeBranch->delete();

        return Response([
            'status' => 200,
            'message' => 'deleted successfully',
            'data' => ''
        ], 200);
    }
}
