<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class Plan extends Model
{
    protected $fillable = [
        'slug',
        'price',
        'duration_in_days',
    ];

    public $appends = ['title', 'icon'];

    public function getIconAttribute()
    {
        switch ($this->slug) {
            case 'ordinary':
                return asset('img/fontawesome/user-plus-solid.svg');
                break;
            case 'official_publication':
                return asset('img/fontawesome/file-pdf-regular.svg');
                break;
            case 'private_publication':
                return asset('img/fontawesome/file-pdf-solid.svg');
                break;
            case 'exemplary_provision':
                return asset('img/fontawesome/newspaper-solid.svg');
                break;
        }
    }

    public function getTitleAttribute()
    {
        switch ($this->slug) {
            case 'biannual':
                return 'Suscripción Ordinario Semestral';
                break;
            case 'yearly':
                return 'Suscripción Ordinario Anual';
                break;
        }
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getVisualPriceAttribute()
    {
        return '$' . number_format($this->price,  2);
    }
}
