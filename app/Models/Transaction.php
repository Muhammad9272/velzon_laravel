<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    public function user() {
          return $this->belongsTo('App\Models\User')->first();
      }

    public function subscription() {
            return $this->belongsTo('App\Models\Subscriptions', 'subscriptions_id')->first();
    }

    public function relateduser()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
