<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-27
 * Time: 下午4:17
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'oil_station', 'address', 'oil_type', 'price', 'cost', 'user_id', 'no',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];
}
