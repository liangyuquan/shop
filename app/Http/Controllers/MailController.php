<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;


class MailController extends Controller
{
    public function send()
    {
        $image = '';
        $name = 'GreenForest';
        $flag = Mail::send('emails.test',['name'=>$name,'image'=>$image],function($message){
            $to = '363016588@qq.com';
            $message ->to($to)->subject('邮件测试');
        });
        /*//图片
        $image = Storage::get('images/obama.jpg');
        //附件
        $attachment = storage_path('app/files/test.txt');
        // 在邮件中上传附件
        $message->attach($attachment,['as'=>'中文文档.txt']);*/
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
    }
}
