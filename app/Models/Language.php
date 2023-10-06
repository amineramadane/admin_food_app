<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};

class Language extends Model
{
    use HasFactory, SoftDeletes;
}
