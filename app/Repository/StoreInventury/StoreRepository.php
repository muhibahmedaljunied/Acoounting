<?php


namespace App\Repository\StoreInventury;
use App\Services\CoreService;
abstract class StoreRepository
{

    public function __construct(protected CoreService $core)
    {
    }

    abstract function store();


}
