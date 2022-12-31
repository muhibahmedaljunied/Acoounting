<?php

namespace App\Imports;

use App\Category;
use App\GroupCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
class CategoryImport implements  ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {




    

        // Category::create([
            
          
        //     'group_id'    => $rows[1],
        //     'name'     => $rows[2],
        //     'image'    => $rows[3],
        //     'status' => $rows[4],


        // ]);
    
    }


    public function collection(Collection $rows)
    {

        
        

 
        foreach ($rows as $row)
        {
           
            //     $group =  GroupCategory::create([

           
            //     'name'        => $row['group_name'],
  
            // ]);
 
            $category =  Category::create([
           
                'group_id'          =>  $row[1],
                'name'           =>  $row[2],
                'image'    =>  $row[3],
                'status'  =>  $row[4],

                 
            ]);
        }


    }
}
