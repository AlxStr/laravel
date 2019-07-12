<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 *
 * @package App\Entity
 *
 * @property integer  id
 * @property string   name
 * @property string   slug
 * @property integer  parent_id
 *
 * @property Region   parent
 * @property Region[] children
 */
class Region extends Model
{
    const PER_PAGE = 20;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
}
