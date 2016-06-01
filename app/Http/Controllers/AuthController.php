<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-24
 * Time: 下午4:37
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('username', $request->input('username'));
        if(!$user->count() > 0)
        {
            return $this->stdResponse(2, '用户不存在');
        }

        $user = $user->where('password', $request->input('password'))->first();
        if(!$user)
        {
            return $this->stdResponse(2, '用户名/密码错误');
        }


        //success
        if(!$user->api_token)
        {
          $user->api_token = Crypt::encrypt($user->id.'#'.time());
          $user->save();
        }
        return $this->stdResponse(0, $user->api_token);

    }
}
//decrypt
//            try {
//                $decrypted = Crypt::decrypt($user->api_token);
//            } catch (DecryptException $e) {
//                //
//            }
