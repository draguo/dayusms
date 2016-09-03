<?php

namespace Draguo\Dayusms;
use Draguo\Dayusms\SendSms as SendSms;
use Log;

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
     * 完全自定义的方法，按照官方文档实现
     * https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.7395905.4.6.bQRfgO&apiId=25450
     * 对所有参数可以自行配置
     * $signName  string 例如：'大鱼'
     * $templateCode string 例如：'SMS_585014'
     * $smsParam  json 例如："{\"code\":\"1234\",\"product\":\"alidayu\"}"
     * $phone string 多个号码之间使用英文逗号分隔，一次最多支持200个 例如：'123456,456789'
     **/
    public  function send($phone,$smsParam,$templateCode=0,$signName=0)
    {
        // default value
        $signName = $signName === 0 ? config('dayusms.defaultSignName') : $signName;
        $smsParam = json_encode($smsParam,JSON_UNESCAPED_UNICODE);
        $templateCode = $templateCode === 0 ? config('dayusms.defaultTemplateCode') : $templateCode;
        //这个用来做回调使用，暂时用不上
        $this->setExtend("123456");
        $this->setSmsType('normal');
        $this->setSmsFreeSignName($signName);
        $this->setSmsParam($smsParam);
        $this->setRecNum($phone);
        $this->setSmsTemplateCode($templateCode);
        $appkey = config('dayusms.appkey');
        $secretKey = config('dayusms.secretKey');
        $server = new SmsServer($appkey,$secretKey);
        $result = $server->execute($this);

        if(isset($result->result))
        {
            if($result->result->err_code == 0)
            {
                $returnValue = ['code'=>0,'msg'=>'ok','result'=>$result];
            }
            else
            {
                Log::error('alidayu error--'.$result->msg);
                $returnValue = ['code'=>$result->code,'msg'=>$result->msg,'result'=>$result];
            }
        }
        else
        {
            Log::error('alidayu error--'.$result->msg);
            $returnValue = ['code'=>$result->code,'msg'=>$result->msg,'result'=>$result];
        }
        return json_encode($returnValue);
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
