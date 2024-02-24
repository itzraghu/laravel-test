<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Repositories\SalesRepository;
use App\Services\SalesService;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider salesDataProvider
     */
    public function testCalculateSellingPrice($quantity, $unitCost, $expected): void
    {
        $product =  Product::factory()->create([
            'name' => 'Gold Coffee',
            'profit_margin_percent' => 25,
            'unit_cost' => 10
        ]);

        $request = new Request();
        $request->merge([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_cost' => $unitCost
        ]);

        $saleService = app()->make(SalesService::class);
        $sellingPrice = $saleService->calculateSellingPrice(
            Product::findOrFail($product->id),
            $request->quantity,
            $request->unit_cost,
            Product::SHIPPING_COST,
        );

        $this->assertEquals($expected, round($sellingPrice, 2));
    }

    public static function salesDataProvider()
    {
        return [
            [1, 10, 23.33],
            [1, 2, 12.67],
        ];
    }

    public function testRecordNewSale(): void
    {
        $product = Product::factory()->create();
        $this->assertModelExists($product);

        $salesRepository = app()->make(SalesRepository::class);
        $request = new Request();
        $request->merge([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $salesRepository->create(
            $request
        );

        $this->assertDatabaseHas(Sale::class, [
            'product_id' => $product->id,
        ]);
    }
}
