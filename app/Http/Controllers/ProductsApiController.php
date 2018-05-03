<?php

namespace App\Http\Controllers;

use App\Services\ProductStore;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{

    protected $rules = [
        'product_name' => 'required',
        'quantity_in_stock' => 'required|int',
        'price_per_item' => 'required|numeric',
    ];

    public function index(ProductStore $store)
    {
        return $store->all();
    }

    public function store(Request $request, ProductStore $store)
    {
        $product = $this->validate($request, $this->rules);
        $product = $store->create($product);
        return $product;
    }

    public function update(Request $request, ProductStore $store, array $product)
    {
        $productId = $product['id'];

        $product = $this->validate($request, $this->rules);
        $product = $store->update($productId, $product);
        return $product;
    }

    public function destroy(ProductStore $store, array $product)
    {
        return $store->delete($product['id']);
    }
}
