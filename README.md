## 目录
- [项目介绍](#项目介绍)
- [安装](#安装)
- [使用方法](#使用方法)
  - [AXYB](#AXYB)
  - [AXB](#AXB)
  - [AXN](#AXN)
  - [AXN分机号](#AXN分机号)
  - [白名单报备](#白名单报备)

# 项目介绍
联通 COP 平台

# 安装
使用 composer

```shell
composer require linshunwei/laravel-uniin -vvv
```

在配置文件中添加服务提供者（Laravel5.5 有自动添加）
```php
'providers' => [
    //...
    Linshunwei\LaravelRedisLbs\UniinServiceProvider::class,
    //...
],
```


然后执行
```shell
php artisan vendor:publish --provider="Linshunwei\Uniin\UniinServiceProvider"
```
将生成 `config/uniin..php` 配置文件，配置文件中的

# 使用方法
具体参数查看文档
```php
use Linshunwei\Uniin\Uniin;
    //...
    $uniin = new Uniin();
    $uniin->axb->query();
    //...
 或
use Linshunwei\Uniin\Facades\Uniin;
    Uniin::axb()->query();
```

## AXYB
```php
 $uniin->axyb->stdSet(); //绑定
 $uniin->axyb->stdRelease();//解绑
 $uniin->axyb->stdUpdate(); //更新
 $uniin->axyb->query(); //查询
```

## AXB
```php
 $uniin->axb->stdSet(); //绑定
 $uniin->axb->stdRelease();//解绑
 $uniin->axb->stdUpdate(); //更新
 $uniin->axb->query(); //查询
```
## AXN
```php
 $uniin->axn->stdSet(); //绑定
 $uniin->axn->stdRelease();//解绑
 $uniin->axn->stdUpdate(); //更新
 $uniin->axn->query(); //查询
```

## AXN分机号
```php
 $uniin->axnExt->stdSet(); //绑定
 $uniin->axnExt->stdRelease();//解绑
 $uniin->axnExt->stdUpdate(); //更新
 $uniin->axnExt->query(); //查询
```

## 白名单报备
```php
 $uniin->whitelistCaller->report(); //报备申请接口
 $uniin->whitelistCaller->reportStatus();//报备结果查询接口
 $uniin->whitelistCaller->query(); //报备结果查询接口
```
