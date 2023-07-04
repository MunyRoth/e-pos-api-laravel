<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $stores =  Auth::guard('api')->user()->stores;

        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $stores
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request, Store $store): Response
    {
        $user =  Auth::guard('api')->user();

        $logoUrl = Cloudinary::upload($request->file('logo')->getRealPath(), [
            'folder' => 'ePOS'
        ])->getSecurePath();

        $store->logo_url = $logoUrl;
        $store->name_km = $request->name_km;
        $store->save();

        $store->users()->sync($user->id);

        return Response([
            'status' => 201,
            'message' => 'uploaded successfully',
            'data' => $store
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store): Response
    {
        return Response([
            'status' => 200,
            'message' => 'got successfully',
            'data' => $store
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        // update logo
        if (!empty($request->logo_url))
        {
            // Delete the old image file.
            $logoUrl = $store->logo_url;
            preg_match("/\/v(\d+)\/(\w+)\/(\w+)/",$logoUrl,$recordMatch);
            $id = $recordMatch[2].'/'.$recordMatch[3];
            Cloudinary::destroy($id);

            //upload new file
            $logoUrl = Cloudinary::upload($request->file('logo_url')->getRealPath(), [
                'folder' => 'ePOS'
            ])->getSecurePath();

            //update in table
            $store->update([
                'logo_url' => $logoUrl
            ]);
        }

        if ($request->name_km != '') {
            $store->update([
                'name_km' => $request->name_km
            ]);
        }

        if ($request->name_en != '') {
            $store->update([
                'name_en' => $request->name_en
            ]);
        }

        if ($request->website != '') {
            $store->update([
                'website' => $request->website
            ]);
        }

        if ($request->email != '') {
            $store->update([
                'email' => $request->email
            ]);
        }

        if ($request->phone != '') {
            $store->update([
                'phone' => $request->phone
            ]);
        }

        return Response([
            'status' => 200,
            'message' => 'updated successfully',
            'data' => $store
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store): Response
    {
        // delete logo
        $logoUrl = $store->logo_url;
        preg_match("/\/v(\d+)\/(\w+)\/(\w+)/",$logoUrl,$recordMatch);
        $id = $recordMatch[2].'/'.$recordMatch[3];
        Cloudinary::destroy($id);

        $store->delete();

        return Response([
            'status' => 200,
            'message' => 'deleted successfully',
            'data' => ''
        ], 200);
    }
}
