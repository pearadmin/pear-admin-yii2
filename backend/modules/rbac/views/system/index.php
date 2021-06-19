<?php
$this->registerJs($this->render('js/index.js'));
?>

<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <div class="layui-form-item layui-inline">
                    <label class="layui-form-label">文件名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="filename" placeholder="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-inline aa">
                    <button class="pear-btn pear-btn-md pear-btn-primary" lay-submit="search" lay-filter="search" >
                        <i class="layui-icon layui-icon-search"></i>
                        查询
                    </button>
                    <button type="reset" class="pear-btn pear-btn-md">
                        <i class="layui-icon layui-icon-refresh"></i>
                        重置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="layui-row layui-col-space15">
    <div class="layui-col-md12" attr="con">
        <div class="layui-card" >
            <div class="layui-card">
                <div class="layui-card-body">
                    <table id="dir-table" lay-filter="dir-table"></table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/html" id="toolbar">
    <div class="event-content">
        <a lay-event="rename">重命名</a> |
        <a lay-event="power">权限</a> |
        <a lay-event="compress">压缩</a> |
        <a lay-event="remove">删除</a>
    </div>
</script>
<script type="text/html" id="main-table-toolbar">
    <div class="dirs" >
        <button class="back layui-icon layui-icon-prev" ></button>
        <input class="dir-input" disabled>
        <span class="tz pear-btn pear-btn-xs pear-btn-primary">跳转</span>
        <ul class="oul">
            <li class="fli" data-value="">根目录</li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
            <li class="sli"></li>
        </ul>
        <input type="hidden" class="route-text layui-input" value="" name="cur_route" autocomplete="off">
    </div>
    <button class="pear-btn pear-btn-xs pear-btn-primary btn-down">
        <span>新建</span>
        <i class="layui-icon layui-icon-triangle-d"></i>
    </button>
    <ul class="btn-ul">
        <li class="create-file" data-value="file">新增空白文件</li>
        <li class="create-file" data-value="dir">新增目录</li>
    </ul>
    <button class="pear-btn pear-btn-xs pear-btn-danger btn-del" style="left:500px" lay-event="del">
        <span >删除</span>
        <i class="layui-icon">&#x1006;</i>
    </button>
</script>

<div hidden id="addUserCard" class="trace-index layui-form" style="padding-right:5%;">
    <form class="layui-form" action="">
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
                <input type="text" name="username" autocomplete="off" lay-verify="required" placeholder="账号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" autocomplete="off" lay-verify="required" placeholder="昵称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input  name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off" class="layui-input">
            </div>
        </div>
        <button class="layui-btn layui-bg-blue hidden" id="btnSubmit" lay-submit lay-filter="add">
            <i class="layui-icon">&#xe609;</i>保存
        </button>
    </form>
</div>

<!--更新人员界面-->
<div hidden id="updateUserCard" class="trace-index layui-form" style="padding-right:5%;">
    <form class="layui-form" action="">
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
                <input type="text" disabled  name="username" autocomplete="off" lay-verify="required" placeholder="账号" class="layui-input">
                <input type="hidden" disabled  name="id">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" autocomplete="off" lay-verify="required" placeholder="昵称" class="layui-input">
            </div>
        </div>

        <div class="layui-inline">
            <label class="layui-form-label">选择部门</label>
            <div class="layui-input-inline">
                <input type="text" id="dtreeSelect" lay-filter="dtreeSelect" name="dept_id" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">启用状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="启用|关闭">
            </div>
        </div>
        <button class="layui-btn layui-bg-blue" style="display: none" id="update-btn" lay-submit lay-filter="update">
            <i class="layui-icon">&#xe609;</i>更新
        </button>
    </form>
</div>
