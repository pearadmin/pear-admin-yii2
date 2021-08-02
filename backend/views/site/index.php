<!-- 结 构 代 码 -->
<body class="layui-layout-body pear-admin">
<!-- 布 局 框 架 -->
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <!-- 顶 部 左 侧 功 能 -->
        <ul class="layui-nav layui-layout-left">
            <li class="collaspe layui-nav-item"><a href="#" class="layui-icon layui-icon-shrink-right"></a></li>
            <li class="refresh layui-nav-item"><a href="#" class="layui-icon layui-icon-refresh-1" loading = 600></a></li>
        </ul>
        <!-- 顶 部 右 侧 菜 单 -->
        <div id="control" class="layui-layout-control"></div>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide-xs"><a href="#" class="fullScreen layui-icon layui-icon-screen-full"></a></li>
            <li class="layui-nav-item layui-hide-xs"><a href="http://www.pearadmin.com" class="layui-icon layui-icon-website"></a></li>
            <li class="layui-nav-item">
                <!-- 头 像 -->
                <a href="javascript:;">
                    <img src="plugins/admin/images/avatar.jpg" class="layui-nav-img">
                </a>
                <!-- 功 能 菜 单 -->
                <dl class="layui-nav-child">
                    <dd><a user-menu-url="/rbac/user/person" user-menu-id="5555" user-menu-title="基本资料">基本资料</a></dd>
                    <dd><a href="/rbac/user/logout" class="logout">注销登录</a></dd>
                </dl>
            </li>
            <!-- 主 题 配 置 -->
            <li class="layui-nav-item setting"><a href="#" class="layui-icon layui-icon-more-vertical"></a></li>
        </ul>
    </div>
    <!-- 侧 边 区 域 -->
    <div class="layui-side layui-bg-black">
        <!-- 菜 单 顶 部 -->
        <div class="layui-logo">
            <!-- 图 标 -->
            <img class="logo"></img>
            <!-- 标 题 -->
            <span class="title"></span>
        </div>
        <!-- 菜 单 内 容 -->
        <div class="layui-side-scroll">
            <div id="sideMenu"></div>
        </div>
    </div>
    <!-- 视 图 页 面 -->
    <div class="layui-body">
        <!-- 内 容 页 面 -->
        <div id="content"></div>
    </div>
    <!-- 遮 盖 层 -->
    <div class="pear-cover"></div>
    <!-- 加 载 动 画-->
    <div class="loader-main">
        <div class="loader"></div>
    </div>
</div>
<!-- 移 动 端 便 捷 操 作 -->
<div class="pear-collasped-pe collaspe">
    <a href="#" class="layui-icon layui-icon-shrink-right"></a>
</div>
<!-- 依 赖 脚 本 -->
<!-- 框 架 初 始 化 -->
<script>
    layui.use(['admin','jquery','convert','popup'], function() {
        var admin = layui.admin;
        var $ = layui.jquery;
        var convert = layui.convert;
        var popup = layui.popup;

        // 初始化顶部用户信息
        admin.setAvatar("plugins/admin/images/avatar.jpg","<?php echo Yii::$app->user->identity->username; ?>");

        // 根目录下 pear.config.yml 文件为初始化配置
        // 你可以通过 admin.setConfigPath 方法修改配置文件位置
        // 你可以通过 admin.setConfigType 方法修改配置文件类型
        admin.setConfigType("yml");
        admin.setConfigPath("plugins/config/pear.config.yml");
        admin.render();

        // 登出逻辑
        admin.logout(function(){

            popup.success("注销成功",function(){
                location.href = "site/login";
            })

            // 注销逻辑 返回 true / false
            return true;
        })
    })
</script>
</body>
</html>
