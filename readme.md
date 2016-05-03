### [探庐者](http://www.casarover.com/)开源，其中大多为本业务使用
在完善中
## 配置

### Laravel 应用

1. 注册 `ServiceProvider`:

  ```php
          Draguo\Dayusms\ServiceProvider::class,
  ```

2. 创建配置文件：

  ```shell
  php artisan vendor:publish
  ```

3. 请修改应用根目录下的 `config/dayusms.php` 中对应的项即可；
4. 使用  
    $sms = app('sms');
