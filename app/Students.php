<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model {

    public $timestamps = false;
    protected $table = "students";
    protected $fillable = ['id', 'name', 'class', 'city', 'state', 'pincode', 'address', 'created_at', 'updated_at'];

}
