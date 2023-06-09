<?php

namespace FireAZ\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;
    protected $table='local_area';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'code',
        'parent_code',
        'name',
        'type',
        'slug',
        'slug_path',
        'slug_path_with_type',
        'name_with_type',
        'path',
        'path_with_type',
    ];
    protected $casts = [];
}
