<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [];

    protected $appends = ['label', 'badge_status'];

    public function getBadgeStatusAttribute()
    {
        switch ($this->status) {
            case 'Por Pagar':
                return "<span class='badge badge-warning'><i class='fas fa-dollar-sign'></i> {$this->status}</span>";
                break;
            case 'Pagado':
                return "<span class='badge badge-success'><i class='fas fa-check-circle'></i> {$this->status}</span>";
                break;
        }
    }

    public function getLabelAttribute()
    {
        return "ORD_"  . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
