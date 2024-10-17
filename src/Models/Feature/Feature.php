<?php

namespace JWebb\Unleash\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public $timestamps = false;

    protected $table = 'FEATURES';

    protected $primaryKey = 'ID';

    protected $guarded = ['ID'];

    protected $fillable = [
        'ACTIVE',
        'JSON_VALUE',
        'CONTEXT_ID',
        'CONTEXT_TABLE',
    ];

    protected $casts = [
        'TS_CREATED' => 'timestamp',
        'TS_LASTMODIFIED' => 'timestamp',
        'ACTIVE' => 'boolean',
    ];
}
