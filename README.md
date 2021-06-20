
<div align="center">
<br/>
<br/>
<img src="/backend/web/plugins/admin/images/logo.png" width="90px" style="margin-top:30px;"/>
   <h1 align="center">
    Pear Admin Yii2
   </h1>
    <h4 align="center">
    开 箱 即 用 的 PHP 快 速 开 发 平 台
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
  <img  width="92%" style="border-radius:10px;margin-top:20px;margin-bottom:20px;box-shadow: 2px 0 6px gray;" src="https://images.gitee.com/uploads/images/2020/1019/104805_042b888c_4835367.png" />
</div>

### 🌈 项目简介

* 基于 Yii2 实现的通用权限管理平台（RBAC模式）。整合最新技术高效快速开发，前后端分离模式，开箱即用。
* 核心模块包括：用户、角色、权限、路由、部门、菜单、文件管理、系统配置等功能。
* 代码量少、学习简单、功能强大、轻量级、易扩展，轻松开发从现在开始！

#### V5.0.1
* 增加图库选择功能。
* 升级THINKPHP6.0.8。

#### V5.0.0

* 增加数据签名验证。
* 增加语法糖扩展。
* 增加成功失败404模板。
* 增加配置文件读改。
* 增加多文件上传。
* 增加工具包。
* 修改系统配置项。
* 更新登录验证方式。
* 更新JSON输出格式。
* 同步更新最新版pear-layui。
* 修复菜单为url报错,修改验证方式。
* 更新路由与入口兼容方法。
* 去除配置表，通过文件配置读改。
* 模型，服务，验证器，事件，工具包 统一放入common文件进行管理。
* 修改设计思路，移动目录结构，简化代码。
* 本次更新，变动较大。请使用最新版本！
### 🔨 项目结构

```
api
    assets/             资源发布文件
    controllers/        控制器文件
    models/             模型文件
    modules/            模块文件
        v1/             接口V1
            controllers 控制器
            views       视图文件
            Module.php  模块
    runtime/            运行缓存
    views/              视图文件
    web/                入口目录
common
    config/             配置文件
    mail/               邮件模板
    models/             模型文件
    tests/              测试模块
console
    config/             配置文件
    controllers/        控制器文件
    migrations/         数据库迁移文件
    models/             模型文件
    runtime/            运行缓存
backend
    assets/             资源发布文件
    config/             配置文件
    controllers/        控制器文件
    models/             模型文件
    modules/            后台其他模块
    runtime/            运行缓存
    tests/              测试模块
    views/              视图
    web/                入口文件
frontend
    assets/             资源发布文件
    config/             配置文件
    controllers/        控制器文件
    models/             模型文件
    runtime/            运行缓存
    tests/              测试模块
    views/              视图
    web/                入口文件
    widgets/            插件
vendor/                 composer安装文件
environments/           环境文件
yii2_cms.sql            数据库文件
```

#### 安装配置
* git clone https://gitee.com/pear-admin/Pear-Admin-Think
* 更新包composer update(可以忽略)
* 将网站入口部署至public目录下面
* 修改thinkphp伪静态配置。
* 运行网站地址, 会自动进入安装界面, 请根据提示进行设置, 然后点击安装。
* 安装完成后会自动生成安装锁public/install.lock, 如需重新安装, 删掉该文件即可
* 如果需要隐藏后台,可以在config/app.php域名绑定。 否则直接访问/admin.php

#### CRUD生成
>env APP_DEBUG = true

* 第一步.约定字段类型必须"XXX_XXX"
* 第二步.选择数据表生成。
* 建议定义软删除delete_time，自动生成回收站功能。如不需要可自行删除。

#### 预览项目

|  |  |
|---------------------|---------------------|
| ![](/backend/web/plugins/admin/images/demos/1.png)  |![](/backend/web/plugins/admin/images/demos/1.png)  |
| ![](/backend/web/plugins/admin/images/demos/1.png)|  ![](/backend/web/plugins/admin/images/demos/1.png)   |
| ![](/backend/web/plugins/admin/images/demos/1.png)|  ![](/backend/web/plugins/admin/images/demos/1.png)  |
| ![](/backend/web/plugins/admin/images/demos/1.png)|  ![](/backend/web/plugins/admin/images/demos/1.png)   |
| ![](/backend/web/plugins/admin/images/demos/1.png)|  ![](/backend/web/plugins/admin/images/demos/1.png)  |
|![](/backend/web/plugins/admin/images/demos/1.png)| ![](/backend/web/plugins/admin/images/demos/1.png)   |

#### 项目声明
>仅供技术研究使用，请勿用于非法用途，否则产生的后果作者概不负责。