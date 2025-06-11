<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Api\Upload\UploadApi; // api truc tiep
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::with('category')->get());
    }

    public function store(Request $request)
    
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8000',
        ]);

        try {
            // $uploadedImage = Cloudinary::upload($request->file('image')->getRealPath(), [
            //     'folder' => 'cafe_items',
            //     'transformation' => [
            //         'width' => 300,
            //         'height' => 300,
            //         'crop' => 'fit',
            //     ],
            // ]);
            $publicId = Str::slug($request->name, '_');

            $uploadedImage = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'cafe_items',
                'public_id' => $publicId,
                'transformation' => [
                    'width' => 300,
                    'height' => 400,
                    'crop' => 'fit',
                ],
            ]);

            $imageUrl = $uploadedImage->getSecurePath();

            $item = Item::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'img' => $imageUrl,
            ]);

            return response()->json([
                'message' => 'Item created successfully',
                'item' => $item->load('category'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // return response()->json([
        //     'message' => 'Item updated successfully',
        //     'name' => $request->name,
        //     'price' => $request->price,
        //     'img' => $request->image,
        //     'cateid' => $request->category_id,
        //     'id' => $id,
        // ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000',
        ]);

        try {
            $item = Item::findOrFail($id);
            $publicId = Str::slug($request->name, '_');

            $imageUrl = $item->img;
            if ($request->hasFile('image')) {
                if ($item->img) {
                    $publicId = basename($item->img, '.' . pathinfo($item->img, PATHINFO_EXTENSION));
                    Cloudinary::destroy('cafe_items/' . $publicId);
                }
                $uploadedImage = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'cafe_items',
                    'public_id' => $publicId,
                    'transformation' => [
                        'width' => 300,
                        'height' => 400,
                        'crop' => 'fit',
                    ],
                ]);
                $imageUrl = $uploadedImage->getSecurePath();
            }

            $item->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'img' => $imageUrl,
            ]);

            return response()->json([
                'message' => 'Item updated successfully',
                'item' => $item->load('category'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);

            if ($item->img) {
                $publicId = basename($item->img, '.' . pathinfo($item->img, PATHINFO_EXTENSION));
                Cloudinary::destroy('cafe_items/' . $publicId);
            }

            $item->delete();

            return response()->json([
                'message' => 'Item deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}