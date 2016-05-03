### [探庐者](http://www.casarover.com/)开源，其中大多为本业务使用
持续完善中  
### 安装
```shell
composer require "draguo/dayusms:dev-master"  
```
## 配置

### Laravel 应用

1. 注册 `ServiceProvider`:

  ``` php  
  Draguo\Dayusms\ServiceProvider::class
  ```

2. 创建配置文件：

  ```shell
  php artisan vendor:publish
  ```

3. 请修改应用根目录下的 `config/dayusms.php` 中对应的项即可；
4. 使用  
    $sms = app('sms');  

###函数使用相关  
    用户注册
    public function regitst($phone)
    用户重置密码
    public function reset($phone)

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
