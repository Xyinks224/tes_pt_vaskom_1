<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::get();

        if ($request->search) {
            $products = Product::where('name', 'LIKE', "%$request->search%")->orwhere('price', 'LIKE', "%$request->search%")->get();
        }

        return $this->success('Products Found', $products, 200);
    }

    public function store(Request $request){
        $this->validateRequest($request);
        $input = $request->all();
        $product = Product::create([
                'name' => $input['name'],
                'price' => $input['price'],
                'image' => $input['image'],
        ]);

        return $this->success('Product '.$product->name.' has been created', $product, 201);
    }

    public function show($id){
        $product = Product::find($id);
        if(!$product){
            return $this->error('Product not found', 404);
        }
        return $this->success('Product Found', $product, 200);
    }

    public function update(Request $request, $id){
        $product = Product::find($id);
        if(!$product){
            return $this->error('Product not found', 404);
        }
        $this->validateRequest($request);
        $input = $request->all();
        $product->update($input);

        return $this->success('Product '.$product->name.' has been updated', $product, 200);
    }
    public function destroy($id){
        $product = Product::find($id);
        if(!$product){
            return $this->error('Product not found', 404);
        }
        $product->delete();
        return $this->success('Product '.$product->name.' has been deleted', $product, 200);
    }

    public function validateRequest(Request $request){
        $rules = [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required|numeric|min:1'
        ];
        $this->validate($request, $rules);
    }
}
