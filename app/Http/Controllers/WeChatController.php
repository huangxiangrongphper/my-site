<?php

namespace App\Http\Controllers;

use Log;

class WeChatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志


        $app = app('wechat.official_account');
        $app->server->push(function($message){
            switch ($message['MsgType']) {
                case 'event':
                    if($message['Event'] == 'subscribe'){
                        return 'Thank you, friend. It\'s fate to meet.🙂😊';
                    }
                    break;
                case 'text':
                    if($message['Content'] == '肖彤'){
                        sleep(1);
                        return '黄向荣喜欢你💕';
                    }
                    if($message['Content'] == '谁是这个世界上最漂亮的女人?'){
                        sleep(1);
                        return '肖彤啊😁';
                    }
                    if($message['Content'] == '小丁'){
                        return '黄向荣和你是好朋友👬';
                    }
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        return $app->server->serve();
    }
}
