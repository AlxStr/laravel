<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Category
 *
 * @package App\Entity\Adverts
 */
class Category extends Model
{
    use NodeTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'advert_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];
}
