<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private $productRepository;
    private $salesRepository;

    public function __construct()
    {
        $this->productRepository = app()->make(ProductRepository::class);
        $this->salesRepository = app()->make(SalesRepository::class);
    }

    public function index()
    {
        $data = [];
        $data['products'] = $this->productRepository->all();
        $data['previous_sales'] = $this->salesRepository->all(true);
        $data['shipping_cost'] = Product::SHIPPING_COST;
        return view('coffee_sales', $data);
    }

    public function store(CreateSaleRequest $request)
    {
        $this->salesRepository->create($request);
        return redirect()->route('coffee.sales')->with('success', __('Sale recorded successfully.'));
    }
}
