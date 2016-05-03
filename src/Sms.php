<?php

namespace Draguo\Dayusms;
use Draguo\Dayusms\SendSms as SendSms;
class Sms extends SendSms
{
    /**
     * 用户注册
     **/
    public function regitst($phone)
    {
        $verifyCode = $this->codeTemplet('注册验证',config('dayusms.templateCode.regist'),$phone);
        return $verifyCode;
    }


    /**
     * 用户重置密码
     **/
    public function reset($phone)
    {
        $verifyCode = $this->codeTemplet('变更验证',config('dayusms.templateCode.reset'),$phone);
        return $verifyCode;
    }
    /**
     * 活动通知
     */
    public function activ()
    {

    }

    /**
     * 完全自定义的方法，按照官方文档实现
     * https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.7395905.4.6.bQRfgO&apiId=25450
     * 对所有参数可以自行配置
     * $signName  string 例如：'大鱼'
     * $templateCode string 例如：'SMS_585014'
     * $smsParam  json 例如："{\"code\":\"1234\",\"product\":\"alidayu\"}"
     * $phone string 多个号码之间使用英文逗号分隔，一次最多支持200个 例如：'123456,456789'
     **/
    public  function send($signName,$templateCode,$smsParam,$phone)
    {
        //这个不知道是干什么的
        $this->setExtend("123456");
        $this->setSmsType('normal');
        $this->setSmsFreeSignName($signName);
        $this->setSmsParam($smsParam);
        $this->setRecNum($phone);
        $this->setSmsTemplateCode($templateCode);
        $appkey = config('dayusms.appkey');
        $secretKey = config('dayusms.secretKey');
        $server = new SmsServer($appkey,$secretKey);
        $message = $server->execute($this);
        return $message;
    }

    /**
     * 需要发送验证码的
     * signName 短信签名，例如：注册验证
     * templateCode 短信模板代码，要在阿里大鱼上申请
     * */
    private function codeTemplet($signName,$templateCode,$phone)
    {
        $product = config('dayusms.product');
        $verifyCode = $this->getCode();
        //这个不知道是干什么的
        $this->setExtend("123456");
        $this->setSmsType('normal');
        $this->setSmsFreeSignName($signName);
        $this->setSmsParam("{\"code\":\"$verifyCode\",\"product\":\"$product\"}");
        $this->setRecNum($phone);
        $this->setSmsTemplateCode($templateCode);
        $appkey = config('dayusms.appkey');
        $secretKey = config('dayusms.secretKey');
        $server = new SmsServer($appkey,$secretKey);
        $message = $server->execute($this);
        if(! isset($message->result))
        {
            return $message;
        }
        return $verifyCode;
    }

}