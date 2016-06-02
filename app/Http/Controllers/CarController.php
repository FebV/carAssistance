<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-26
 * Time: 下午4:38
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Car;
use Auth;
class CarController extends Controller
{
    public function new_car(Request $request)
    {

        $res = $this->filter($request, [
            'brand' => 'required',
            'model' => 'required',
            'car_no' => 'required',
            'arch_no' => 'required',
            'motor_no' => 'required',
            'distance' => 'required|numeric',
            'left_oil' => 'required',
            'motor_status' => 'required',
            'trans_status' => 'required',
            'light_status' => 'required',
        ]);

        if(!$res)
            return $this->stdResponse();

        //if arch_no is exist
        $car = Car::where('arch_no', $request->input('arch_no'))->first();
        if($car)
        {
            //user_id is not auth user id
            if($car->user_id != Auth::user()->id)
                return $this->stdResponse(8);

            $car->update($request->all());
            return $this->stdResponse(0);

        }

        $car = new Car($request->all());
        $id = Auth::user()->id;
        $car->user_id = $id;
        $car->save();
        return $this->stdResponse(0);

    }

    public function all_car(Request $request)
    {
      $user = Auth::user();
        if(!$user)
            return $this->stdResponse(3);
        $cars = Car::where('user_id', $user->id)->get();
        return $this->stdResponse(0, $cars);
    }

    public function update_record(Request $request, $id)
    {
        $car = Car::find($id);
        if(!$car)
            return  $this->stdResponse(5);
        $car->update($request->all());
        return $this->stdResponse(0);
    }

    public function my_car_is_normal(Request $request)
    {
      $user = Auth::user();
      $cars = Car::where('user_id', $user->id)->get();
      $result_set = [];
      foreach ($cars as $car)
      {
          if($car->light_status == '不正常' || $car->light_status == '异常')
          $result_set[] = '「'.$car->brand.$car->model.'」车灯状态异常';

          if($car->motor_status == '不正常' || $car->motor_status == '异常')
            $result_set[] = '「'.$car->brand.$car->model.'」发动机状态异常';

          if($car->trans_status == '不正常' || $car->trans_status == '异常')
            $result_set[] = '「'.$car->brand.$car->model.'」变速器状态异常';
            
          if($car->distance >= 15000*($car->current_notification+1))
          {
            $result_set[] = '「'.$car->brand.$car->model.'」当前里程数已经达到'.$car->distance.'，建议您维护';
            $car->current_notification++;
            $car->save();
          }
          if($car->left_oil < 20)
            $result_set[] = '「'.$car->brand.$car->model.'」剩余油量不足20%';

      }
      if(count($result_set) > 0)
          return $this->stdResponse(0, implode($result_set, ','));
      return $this->stdResponse(0, '全部正常');
    }


}
