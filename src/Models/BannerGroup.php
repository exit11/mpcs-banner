<?php

namespace Exit11\Banner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpcs\Core\Traits\ModelTrait;

use Exit11\Banner\Facades\Banner;

class BannerGroup extends Model
{
    use SoftDeletes, ModelTrait;

    protected $table = 'banner_groups';
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    public $appends = ['type_str'];
    // $sortable 정의시 정렬기능을 제공할 필드는 필수 기입
    public $sortable = ['id', 'order', 'is_visible'];
    public $defaultSortable = [
        'id' => 'asc',
    ];

    protected static $m_params = [];

    public static $typeStrings = [
        1 => 'popup',
        2 => 'promotion',
        3 => 'banner',
        4 => 'sponsor',
    ];

    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::setMemberParams(self::$m_params);
    }

    /**
     * banners
     *
     * @return void
     */
    public function banners()
    {
        return $this->hasMany(Banner::class, 'banner_group_id');
    }


    /**
     * getAllowTypes
     *
     * @return void
     */
    public static function getAllowTypes()
    {
        return collect(static::$typeStrings);
    }

    /**
     * getTypeStrAttribute
     *
     * @return void
     */
    public function getTypeStrAttribute()
    {
        return static::$typeStrings[$this->attributes['type']];
    }
}
