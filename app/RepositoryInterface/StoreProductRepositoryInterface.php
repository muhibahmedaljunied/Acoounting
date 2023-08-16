<?php
namespace App\RepositoryInterface;

interface StoreProductRepositoryInterface{

    public function init_store_product();

    public function get_store_product();

    public function refresh_store_product(...$list_data);




}
