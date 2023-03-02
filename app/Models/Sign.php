<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sign extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function signDocument(): BelongsTo
    {
        return $this->belongsTo(SignDocument::class, 'sign_document_id');
    }

    public function document () : BelongsTo
    {
        return $this->belongsTo(SignDocument::class, 'sign_document_id');
    }
}
