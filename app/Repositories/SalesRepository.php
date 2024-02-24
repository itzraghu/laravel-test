<?php

namespace App\Repositories;

use App\Interfaces\SalesRepositoryInterface;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SalesService;

class SalesRepository implements SalesRepositoryInterface
{
    public function all($paginate = false, $limitPerPage = 10, $orderBy = 'DESC')
    {
        $records = Sale::orderBy('id', $orderBy);
        if ($paginate) {
            $records = $records->paginate($limitPerPage);
        } else {
            $records->get();
        }
        return $records;
    }
    public function get($id)
    {
        return Sale::findOrFail($id);
    }
    public function delete($id)
    {
        Sale::destroy($id);
    }
    public function create($request)
    {
        $shippinCost = Product::SHIPPING_COST;

        $saleService = app()->make(SalesService::class);
        $sellingPrice = $saleService->calculateSellingPrice(
            Product::findOrFail($request->product_id),
            $request->quantity,
            $request->unit_cost,
            $shippinCost
        );

        $request->merge([
            'shipping_cost' => $shippinCost,
            'selling_price' => $sellingPrice,
        ]);
        $request = $request->except('_token', 'method');
        return Sale::create($request);
    }
}
