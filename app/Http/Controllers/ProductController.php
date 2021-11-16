<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Products   = Product::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.products.products', compact('Products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.add-product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
        $errors = [];

        $validator   = $request->validate([
            'sku'       => 'required|max:50',
            'title'         => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'description'   => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'qty'       => 'required|numeric',
            'price'     => 'required|numeric',
        ]);

        $photoPath   = null;
        // Upload logo if selected
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $original_filename  = $request->file('photo')->getClientOriginalName();
            $fileSize   = $request->file('photo')->getSize();

            $ext = pathinfo($original_filename, PATHINFO_EXTENSION);
            if(!in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                $errors[]   = "Select a valid logo.";
            }
            if($fileSize > 500*1024) {
                $errors[]   = "File size more than 500kb not allowed.";
            }

            if(empty($errors)) {
                $photoPath = Storage::disk('public')->putFile('product-photos', $request->file('photo'));
            }
        }

        if(empty($photoPath)) {
            $photoPath  = null;
        }

        if(empty($errors)) {
            try {
                Product::create([
                    'sku'  => $request->sku,
                    'title'  => $request->title,
                    'description'  => $request->description,
                    'qty'  => $request->qty,
                    'price'  => $request->price,
                    'photo'  => $photoPath,
                ]);

                return json_encode([
                    "status"    => "success",
                    "message"   => "Product details saved."
                ]);
            } catch(Exception $e) {
                return json_encode([
                    "status"    => "error",
                    "message"   => "ERROR: ". $e->getMessage()
                ]);
            }
        } else {
            return json_encode([
                "status"    => "error",
                "message"   => "ERROR: ". implode(' ', $errors)
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $product_id
     * @return \Illuminate\Http\Response
     */
    public function single_product($product_id)
    {
        $product    = Product::findOrFail($product_id);
        return view('single-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $result = [];
        $errors = [];

        $validator   = $request->validate([
            'sku'       => 'required|max:50',
            'title'         => 'required|regex:/^[a-zA-Z0-9.\s]+$/',
            'description'   => 'required|regex:/^[a-zA-Z0-9.\s]+$/',
            'qty'       => 'required|numeric',
            'price'     => 'required|numeric',
        ]);

        $photoPath      = null;
        $oldPhotoPath   = $product->photo;

        // Upload logo if selected
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $original_filename  = $request->file('photo')->getClientOriginalName();
            $fileSize   = $request->file('photo')->getSize();

            $ext = pathinfo($original_filename, PATHINFO_EXTENSION);
            if(!in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                $errors[]   = "Select a valid logo.";
            }
            if($fileSize > 500*1024) {
                $errors[]   = "File size more than 500kb not allowed.";
            }

            if(empty($errors)) {
                $photoPath = Storage::disk('public')->putFile('product-photos', $request->file('photo'));
            }
        }

        if(empty($photoPath)) {
            $photoPath  = $oldPhotoPath;
        }

        if(empty($errors)) {
            try {
                $product->update([
                    'sku'  => $request->sku,
                    'title'  => $request->title,
                    'description'  => $request->description,
                    'qty'  => $request->qty,
                    'price'  => $request->price,
                    'photo'  => $photoPath,
                ]);

                if($photoPath !== $oldPhotoPath) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $redirect   = route('admin.products.index');
                return json_encode([
                    "status"    => "success",
                    "message"   => "Product details saved.",
                    "redirect"   => $redirect
                ]);
            } catch(Exception $e) {
                return json_encode([
                    "status"    => "error",
                    "message"   => "ERROR: ". $e->getMessage()
                ]);
            }
        } else {
            return json_encode([
                "status"    => "error",
                "message"   => "ERROR: ". implode(' ', $errors)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
