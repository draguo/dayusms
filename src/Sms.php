<?php

namespace Draguo\Dayusms;

use Log;

class Sms extends SendSms
{

    /**
     * 完全自定义的方法，按照官方文档实现
     * https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.7395905.4.6.bQRfgO&apiId=25450
     * 对所有参数可以自行配置
     * $signName  string 例如：'大鱼'
     * $templateCode string 例如：'SMS_585014'
     * $smsParam  json 例如："{\"code\":\"1234\",\"product\":\"alidayu\"}"
     * $phone string 多个号码之间使用英文逗号分隔，一次最多支持200个 例如：'123456,456789'
     **/
    public  function send($phone,$smsParam,$templateCode,$signName=null)
    {
        $signName = $signName? $signName : config('services.dayusms.signName');
        $smsParam = json_encode($smsParam,JSON_UNESCAPED_UNICODE);
        //这个用来做回调使用，暂时用不上
        $this->setExtend("123456");
        $this->setSmsType('normal');
        $this->setSmsFreeSignName($signName);
        $this->setSmsParam($smsParam);
        $this->setRecNum($phone);
        $this->setSmsTemplateCode($templateCode);
        $key = config('services.dayusms.key');
        $secretKey = config('services.dayusms.secret');
        $server = new SmsServer($key,$secretKey);
        $result = $server->execute($this);
        return $this->formatResult($result);
    }

    public function checkBefore()
    {
        // 基础参数进行必要的检查
    }

    public function formatResult($data)
    {
        if(isset($data->result))
        {
            if($data->result->err_code == 0)
            {
                $returnValue = ['code'=>0,'msg'=>'ok','result'=>$data];
            }
            else
            {
                Log::error('alidayu error--'.$data->msg);
                $returnValue = ['code'=>$data->code,'msg'=>$data->msg,'result'=>$data];
            }
        }
        else
        {
            Log::error('alidayu error--'.$data->msg);
            $returnValue = ['code'=>$data->code,'msg'=>$data->msg,'result'=>$data];
        }
        return json_encode($returnValue);
    }
}
