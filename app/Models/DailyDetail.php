<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyDetail extends Model
{
    protected $fillable = ['account_id','account_name','description','debit','credit'];

}
