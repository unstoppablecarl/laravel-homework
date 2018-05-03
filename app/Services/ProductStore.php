<?php

namespace App\Services;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ProductStore
{

    /**
     * @var JsonDataStore
     */
    protected $store;

    protected $file = 'products';

    public function __construct(JsonDataStore $store)
    {
        $this->store = $store;
    }

    public function all()
    {
        return $this->store->get($this->file);
    }

    public function get($id)
    {
        return $this->store->find($this->file, $id);
    }

    public function create(array $product)
    {
        $defaults = [
            'product_name' => null,
            'quantity_in_stock' => null,
            'price_per_item' => null,
        ];

        $product = array_merge($defaults, $product);
        $product['id'] = Uuid::uuid1();
        $product['created_at'] = Carbon::now()->toDateTimeString();

        return $this->store->create($this->file, $product);
    }

    public function update($id, array $product)
    {
        return $this->store->update($this->file, $id, $product);
    }

    public function delete($id)
    {
        return $this->store->delete($this->file, $id);
    }
}
