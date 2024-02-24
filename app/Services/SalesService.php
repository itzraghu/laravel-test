<?php

namespace App\Services;

use App\Models\Product;

class SalesService
{
    public function calculateSellingPrice(Product $product, $quantity, $unitCost, $shippingCost)
    {
        $profitMargin = $product->profit_margin_percent / 100;
        $sellingPrice = (($quantity * $unitCost) / (1 - $profitMargin)) + $shippingCost;

        return $sellingPrice;
    }
}
