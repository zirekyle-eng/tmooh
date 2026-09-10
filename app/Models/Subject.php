<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $table = 'subjects';

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}