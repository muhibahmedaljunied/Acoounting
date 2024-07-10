<?php


namespace App\Repository\StoreInventury;

use App\RepositoryInterface\StoreRepositoryInterface;
use App\Traits\StoreProductTrait;
abstract class StoreRepository implements StoreRepositoryInterface
{

  use StoreProductTrait;
  public $operation;
  public $core;

  abstract function store();






}
