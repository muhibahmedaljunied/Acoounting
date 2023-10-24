<?php
namespace App\RepositoryInterface;

interface StoreProductRepositoryInterface{

    public function init_store_product_table();

    // public function get_store_product_table();

    public function refresh_store_product_table(...$list_data);




}
