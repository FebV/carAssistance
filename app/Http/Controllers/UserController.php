<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-24
 * Time: 下午2:01
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
class UserController extends Controller
{

    public function new_user(Request $request)
    {
        $res = $this->filter($request,[
            'username' => 'required|unique:users',
            'password' => 'required',
            'realname' => 'required',
            'email' => 'required|email',
        ]);

        if (!$res)
            return $this->stdResponse();


        $photo_url = '';
        //parse base64 to photo
        if($request->input('photo'))
        {
            $img = base64_decode($request->input('photo'));
            if(!$img)
                return $this->stdResponse(4);
            $photo_url = "../resources/photos/".$request->input('username').time().'.pic';
            file_put_contents($photo_url, $img);
        }

        //create user
        $user = new User($request->all());
        $user->api_token = '';
        $user->photo_url = $photo_url ?  $photo_url : 'null';
        $user->save();
        return $this->stdResponse(0);
    }

    public function user_info(Request $request)
    {

        return $this->stdResponse(0, Auth::user());
    }

    public function all_user()
    {
        return $this->stdResponse(0, User::all());
    }
    
    public function get_photo()
    {
        $user = Auth::user();
        $url = $user->photo_url;
        if($url == 'null')
            return $this->stdResponse(6);
        $img = file_get_contents($url);
        if(!$img)
            return $this->stdResponse(7);
        return response($img)->header('Content-Type', 'image/jpg');
    }

}