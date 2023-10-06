<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\ArticleList;

class OrdreFabrication extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // public $perPage = 10;

    public $displayColumns = [
        'reference' => [
            'table' => [
                'title' => 'OF GPAO',
                'column' => [
                    ['reference'],
                ]
            ],
            'filter' => [
                'by' => ['reference', 'num_of_sage'],
                'placeholder' => 'Recherche : OF GPAO / OF Sage',
                'type' => 'likeRange',
                'pos' => 1,
            ],
        ],
        'num_of_sage' => [
            'table' => [
                'title' => 'OF Sage',
                'column' => [
                    ['num_of_sage'],
                ]
            ],
        ],
        'status' => [
            'table' => [
                'column' => [
                    ['status'],
                ]
            ],
            'filter' => [
                'type' => 'select',
                'list' => 'status',
                'pos' => 2,
            ],
        ],
        'article_id' => [
            'table' => [
                'column' => [
                    ['article', 'reference'],
                    ['article', 'designation'],
                ]
            ],
            'filter' => [
                'type' => 'select',
                'list' => 'articles',
                'pos' => 3,
            ],
        ],
        'qte' => [
            'table' => [
                'column' => [
                    ['qte'],
                ]
            ],
        ],
        'qte_fab' => [
            'table' => [
                'column' => [
                    ['get_qte_fab()'],
                ]
            ],
        ],
        'qte_reste' => [
            'table' => [
                'column' => [
                    ['qte_reste()'],
                ]
            ],
        ],
        'date_prevue' => [
            'table' => [
                'column' => [
                    ['date_prevue'],
                ]
            ],
            'filter' => [
                'placeholder' => 'date_prevue',
                'type' => 'dateRange',
                'by' => ['created_at_start', 'created_at_end'],
            ],
        ],
        'date_livraison' => [
            'table' => [
                'column' => [
                    ['date_livraison'],
                ]
            ],
            'filter' => [
                'placeholder' => 'date_livraison',
                'type' => 'dateRange',
                'by' => ['date_livraison_start', 'date_livraison_end'],
            ],
        ],
        'ordre_fabrication_id' => [
            'table' => [
                'column' => [
                    ['ordre_fabrication', 'reference'],
                ]
            ],
        ],
        'created_at' => [
            'table' => [
                'column' => [
                    ['created_at'],
                ]
            ],
        ],
    ];

    public static $DisplayButtons = ['add' => true, 'show' => true, 'edit' => true, 'delete' => false, 'import' => true, 'export' => true];

    public function can($permission)
    {
        if ($permission == 'edit' && $this->status <= 10) return false;
        return static::$DisplayButtons[$permission];
    }

    public function CssClass()
    {
        return $this->ordre_fabrication ?: 'font-weight-bold';
    }

    public function get_qte_fab()
    {
        return number_format($this->qte_fab ?? 0, 2,);
    }

    public function get_status()
    {
        return isset(ArticleList::STATUS_ORDRE_FABRICATION[$this->status]) ? ArticleList::STATUS_ORDRE_FABRICATION[$this->status] : '' ;
    }

    public function qte_reste()
    {
        return number_format($this->qte - $this->qte_fab, 2,);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function of_motif()
    {
        return $this->belongsTo(OfMotif::class);
    }

    public function ordre_fabrications()
    {
        return $this->hasMany(OrdreFabrication::class);
    }

    public function ordre_fabrication()
    {
        return $this->belongsTo(OrdreFabrication::class);
    }

    public function nomenclature()
    {
        return $this->article->nomenclatures->first();
    }

    public function ofComposants()
    {
        return $this->hasMany(OfComposant::class, 'order_fabrication_id');
    }

    public function suivi_fabrications()
    {
        return $this->hasMany(SuiviFabrication::class, 'order_fabrication_id');
    }
}
