## 阿里大于发送短信包 for laravel
持续完善中  

## Laravel 应用
### 安装
```shell
composer require "draguo/dayusms:dev-master"  
```
### 创建配置文件以及配置  
  ```shell
  php artisan vendor:publish
  ```
  修改应用根目录下的 `config/dayusms.php` 中对应的项即可

### 注册 `ServiceProvider`:

  ``` php  
  Draguo\Dayusms\ServiceProvider::class
  ```

### 使用  
    $sms = app('sms');  
    $sms->send($phone,$smsParam,$templateCode);

###函数使用相关  
    用户注册
    public function regitst($phone)
    用户重置密码
    public function reset($phone)

    // $phone strong 接收的号码
    // $smsParam array 短信模板，详情请参考 (开发文档)[https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.7395905.4.6.bQRfgO&apiId=25450]
    // $templateCode string 例如：'SMS_585014' ,请到配置文件中配置默认的值
    // $signName string 例如：'大鱼', 请到配置文件中配置默认的值，这个字段通常情况下不会改变

    public function send($phone,$smsParam,$templateCode=0,$signName=0)

### 错误处理
    发送失败会在 Laravel 的日志中记录基本的错误信息，详细信息请查看返回值，
    成功之后会返回 code = 0
