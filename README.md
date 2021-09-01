
<div align="center">
<br/>
<br/>
<img src="/backend/web/plugins/admin/images/logo.png" width="90px" style="margin-top:30px;"/>
<h1 align="center">
Pear Admin Yii2
</h1>
<h4 align="center">
基于 Yii2 + Pear Admin Layui 实现的快速开发平台
</h4> 

  [预 览](http://pear.tsaihoo.com/)   |   [官 网](http://www.pearadmin.com/)   |   [群聊](https://jq.qq.com/?_wv=1027&k=5OdSmve)   |   [社区](http://forum.pearadmin.com/)

</div>

<p align="center">
    <a href="#">
        <img src="https://img.shields.io/badge/Pear Admin Layui-3.6.5+-green.svg" alt="Pear Admin Layui Version">
    </a>
	<a href="#">
        <img src="https://img.shields.io/badge/php-7.0.10+-green.svg" alt="PHP Version">
    </a>
    <a href="#">
        <img src="https://img.shields.io/badge/mysql-5.7.14+-green.svg" alt="MYSQL Version">
    </a>
</p>

<div align="center">
  <img  width="92%" style="border-radius:10px;margin-top:20px;margin-bottom:20px;box-shadow: 2px 0 6px gray;" src="/backend/web/plugins/admin/images/demos/1.png" />
</div>

### 🏄 项目简介

Pear Admin Yii2是基于 Yii2 + Pear Admin Layui 实现的企业级高效开发平台，采用经典的RBAC权限管理模式。是一款轻量级、易上手、开发速度快的开发平台。

### 📜 项目结构

```
backend
    assets              资源发布文件
    config              配置文件
    controllers         控制器文件
    modules             模块文件
        rbac            接口V1
            components  常用组件
            controllers 控制器
            messages    语言
            models      模型
            views       视图文件
            Module.php  模块
    runtime             运行缓存
    test                测试模块
    views               视图文件
    web                 入口目录
common
    cache               缓存
    config              配置文件
    mail                邮件模板
    models              模型文件
    tests               测试模块
    widgets             小部件
console
    config              配置文件
    controllers         控制器文件
    migrations          数据库迁移文件
    models              模型文件
    runtime             运行缓存
environments            环境文件
frontend
    assets              资源发布文件
    config              配置文件
    controllers         控制器文件
    models              模型文件
    runtime             运行缓存
    tests               测试模块
    views               视图
    web                 入口文件
    widgets             插件
vendor                  composer安装文件
paer_admin_yii2.sql     数据库文件

```

### 🔧 安装配置

* git clone https://gitee.com/imbee/pear-admin-yii2.git
* 更新包composer update(可以忽略)
* 将网站入口部署至backend/web/目录下面
* 数据库配置路径：common/config/main-local.php

### 🎨 预览项目

|  |  |
|---------------------|---------------------|
| ![](/backend/web/plugins/admin/images/demos/1.png)  |![](/backend/web/plugins/admin/images/demos/2.png)  |
| ![](/backend/web/plugins/admin/images/demos/3.png)|  ![](/backend/web/plugins/admin/images/demos/4.png)   |
| ![](/backend/web/plugins/admin/images/demos/5.png)|  ![](/backend/web/plugins/admin/images/demos/6.png)  |
| ![](/backend/web/plugins/admin/images/demos/7.png)|  ![](/backend/web/plugins/admin/images/demos/8.png)   |
| ![](/backend/web/plugins/admin/images/demos/9.png)|  ![](/backend/web/plugins/admin/images/demos/10.png)   |


