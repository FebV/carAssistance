<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-26
 * Time: 下午4:49
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand', 'model', 'car_no', 'distance', 'left_oil', 'motor_status', 'trans_status', 'light_status', 'arch_no', 'motor_no', 
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
