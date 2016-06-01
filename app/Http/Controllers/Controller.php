<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    private $stdStatus = [
        0 => 'OK',
        1 => '表单错误',
        2 => '身份信息错误',
        3 => 'api_token校验失败',
        4 => '图片解析失败',
        5 => '记录不存在',
        6 => '图片不存在',
        7 => '图片读取失败',
        8 => '权限不足（车架号不属于你）',
    ];

    public $filterFail = false;
    public $backMsg;

    //standard response
    //
    public function stdResponse($code='', $result='')
    {
        $hasCode = ($code || $code === 0);
        return response()->json(['code' => $hasCode ? $code : 1, 'status' => $this->filterFail ? $this->backMsg : $this->stdStatus[$code], 'result' => $result]);
    }

    public function filter(Request $request, array $arr)
    {
        $validator = Validator::make($request->all(), $arr);

        if($validator->fails())
        {
            $this->backMsg = implode($validator->errors()->all(), ', ');
            $this->filterFail = true;
            return false;
        }
        return true;
    }
}
