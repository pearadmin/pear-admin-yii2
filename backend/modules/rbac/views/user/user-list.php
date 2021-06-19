<?php
$this->registerJs($this->render('js/user-list.js'));
?>

<body class="pear-container" style="overflow: hidden">
    <form class="layui-form" action="">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item" style="">
                    <div class="layui-form-item layui-inline">
                        <label class="layui-form-label">账号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="username" placeholder="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-inline">
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
            </div>
        </div>
    </form>

    <div class="layui-row layui-col-space15" style="margin-top:6px;">
        <div class="layui-col-md3" attr="con">
            <div class="layui-card" >
                <div class="layui-card-body">
                    <div class="" style="text-align: center;margin-bottom: 10px;">
                        <button class="pear-btn pear-btn-primary pear-btn-xs" style="width: 100%;" data-target="search-all"> 查看全部</button>
                    </div>
                    <div id="organizationTreeContent" style="overflow: auto">
                        <ul id="organizationTree" class="dtree organizationTree" data-id="9527"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md9" attr="con">
            <div class="layui-card">
                <div class="layui-card-body">
                    <table id="main-table" lay-filter="main-table"></table>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/html" id="toolbar">
    <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
    <button class="pear-btn pear-btn-warming pear-btn-sm" lay-event="power"><i class="layui-icon layui-icon-vercode"></i></button>
    <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
</script>

<script type="text/html" id="main-table-toolbar">
    <button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
        <i class="layui-icon layui-icon-add-1" ></i>
        新增
    </button>
    <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
        <i class="layui-icon layui-icon-delete"></i>
        删除
    </button>
    <button class="pear-btn pear-btn-default pear-btn-md" lay-event="more">
        <i class="pear-icon pear-icon-modular"></i>
        部门
    </button>
</script>

<!--添加人员界面-->
<div  id="addUserCard" class="trace-index layui-form" style="padding-right:5%;display: none">
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
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input  name="email" placeholder="邮箱" lay-verify="required" type="email" autocomplete="off" class="layui-input">
            </div>
        </div>
        <button class="layui-btn layui-bg-blue" style="display: none" id="btnSubmit" lay-submit lay-filter="add">

            <i class="layui-icon">&#xe609;</i>保存
        </button>
    </form>
</div>

<!--更新人员界面-->
<div hidden id="updateUserCard" class="trace-index layui-form" style="padding-right:5%;">
    <form class="layui-form" action="">
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label layui-form-label-100">账号</label>
            <div class="layui-input-block layui-input-block-bottom">
                <input type="text" disabled  name="username" autocomplete="off" lay-verify="required" placeholder="账号" class="layui-input">
                <input type="hidden" disabled  name="id">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top:20px;">
            <label class="layui-form-label layui-form-label-100">昵称</label>
            <div class="layui-input-block layui-input-block-bottom">
                <input type="text" name="nickname" autocomplete="off" lay-verify="required" placeholder="昵称" class="layui-input">
            </div>
        </div>

        <div class="layui-inline">
            <label class="layui-form-label layui-form-label-100">选择部门</label>
            <div class="layui-input-inline layui-input-block-bottom">
                <input type="text" id="dtreeSelect" lay-filter="dtreeSelect" name="dept_id" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-form-label-100">启用状态</label>
            <div class="layui-input-block layui-input-block-bottom">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="启用|关闭">
            </div>
        </div>
        <button class="layui-btn layui-bg-blue" style="display: none" id="update-btn" lay-submit lay-filter="update">
            <i class="layui-icon">&#xe609;</i>更新
        </button>
    </form>
</div>
