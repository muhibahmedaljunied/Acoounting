<?php
namespace App\RepositoryInterface;
interface SanctionRepositoryInterface{


    public function create($id, $request, $val);
    public function get();


}
