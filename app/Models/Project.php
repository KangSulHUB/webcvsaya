<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'mime_type',
        'external_url',
        'is_published',
    ];
}
