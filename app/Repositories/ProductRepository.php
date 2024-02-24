<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }
    public function get($id)
    {
        return Product::findOrFail($id);
    }
    public function delete($id)
    {
        Product::destroy($id);
    }
    public function create($request)
    {
        $request = $request->except('_token', 'method');
        return Product::create($request);
    }
}
