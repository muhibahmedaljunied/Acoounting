<?php
namespace App\RepositoryInterface;
interface HRRepositoryInterface{

    public function sum($data);
    public function add(...$list_data);
    public function update($request,$value=null);

}
