<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type () : BelongsTo
    {
        return $this->belongsTo(PublicationType::class, 'publication_type_id');
    }

    public function documentType () : BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function category () : BelongsTo
    {
        return $this->belongsTo(PublicationCategory::class, 'publication_category_id');
    }
}
