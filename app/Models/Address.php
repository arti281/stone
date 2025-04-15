<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

        // Define the relationship to the user
        public function state()
        {
            return $this->belongsTo(State::class, 'state_id');
        }

        public function country()
        {
            return $this->belongsTo(Country::class, 'country_id');
        }
}
