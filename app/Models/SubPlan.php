<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPlan extends Model
{
    use HasFactory;
     protected $fillable=['second_name','price','interval','details','features','is_featured','free_trial'];
}
