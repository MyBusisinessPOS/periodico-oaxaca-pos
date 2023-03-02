<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'active_until',
        'user_id',
        'plan_id',
        'is_paid',
    ];

    protected $appends = ['expire_at', 'status_label', 'plan_label'];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    protected $dates = [
        'active_until',
    ];

    public function getPlanLabelAttribute () {
        return $this->plan->slug === 'yearly'? 'Anual' : 'Semestral';
    }

    public function getExpireAtAttribute () {
        return Carbon::parse($this->active_until)->diffForHumans();
    }

    public function getStatusLabelAttribute () {
        if($this->isPaid()) {
            return $this->isActive() ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Activo</span>' : '<span class="badge badge-danger"><i class="fas fa-ban"></i> Inactivo</span>';
        }
        return '<span class="badge badge-warning"><i class="fas fa-dollar-sign"></i> Por Pagar</span>';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * [isActive description]
     *
     * @return  [type]  [return description]
     */
    public function isActive()
    {
        return $this->active_until->gt(now()) && $this->is_paid;
    }

    public function isPaid () {
        return $this->is_paid ?? false;
    }
}
