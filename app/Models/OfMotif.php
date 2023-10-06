<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Factories\HasFactory};

class OfMotif extends Model
{
    use HasFactory, SoftDeletes;

    public static $DisplayButtons = ['add' => true, 'show' => false, 'edit' => true, 'delete' => true, 'import' => false, 'export' => false];

    protected $fillable = [
        'motif'
    ];

    protected $guarded = [];

    public $displayColumns = [
        'motif' => [
            'table' => [],
            'filter' => [
                'type' => 'like',
                'pos' => 1,
            ],
        ],
    ];

    public function CssClass()              { return $this->ordre_fabrication ?: 'font-weight-bold'; }

    public function can($permission)
    {
        return static::$DisplayButtons[$permission]; 
    }
}
