<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function counsel()
    {
        return $this->belongsTo(Counsel::class);
    }
}
