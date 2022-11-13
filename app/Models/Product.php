<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['user_id','sku','slug','name','photo','category_id','website','email','phone','location','revenue','facebook','twitter','instagram','youtube','linkedin','details'];

    public function category($value='')
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
