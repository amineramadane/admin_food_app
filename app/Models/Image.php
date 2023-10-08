<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function imageable(){
        return $this->morphTo();
    }

    public function getpathAttribute($value){
        return asset('storage/'.$value);

    }
}
