<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index() {
        $products = Product::query()->paginate(5);
        return successResponse($products);
    }

    public function store(StoreProductRequest $request) {
        if ($request->hasFile('image')) {
            $imageUrl = uploadFile('images/products', $request->image);
        }
        $product = Product::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageUrl
        ]);
        return successResponse($product);
    }

    public function update(UpdateProductRequest $request, Product $product) {
        if ($request->hasFile('image')) {
            $imageUrl = uploadFile('images/products', $request->image);
            $product->update(['image' => $imageUrl]);
        }
        $product->update([
           'name' => $request->name,
           'description' => $request->description ,
        ]);
        return successMessage('updated successfully');
    }

    public function delete(Product $product) {
        $product->delete();
        return successMessage('deleted successfully');
    }

    public function viewUserProducts(User $user) {
        $data = $user->products()->paginate(10);
        return successResponse($data);
    }

    public function assignProductToUser(Request $request, User $user) {
        $user->products()->syncWithoutDetaching($request->products);
        return successResponse($user->load('products'));
    }

}
