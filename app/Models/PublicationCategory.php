<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicationCategory extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
