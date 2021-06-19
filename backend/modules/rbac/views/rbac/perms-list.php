<?php
$this->registerJs($this->render('js/perms-list.js'));
?>
<body class="pear-container">
    <div class="layui-card" >
        <div class="layui-card-body">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                        <div class="layui-form-item layui-inline">
                            <label class="layui-form-label">权限名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="perm_name" placeholder="" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item layui-inline">
                            <button class="pear-btn pear-btn-md pear-btn-primary" lay-submit="search" lay-filter="search" >
                                <i class="layui-icon layui-icon-search"></i>
                                查询
                            </button>
                        </div>
                        <div class="layui-form-item layui-inline">
                            <button class="pear-btn pear-btn-success pear-btn-md" id="addPermsBtn"> <i class="layui-icon layui-icon-add-1" ></i> 新增 </button>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <div class="layui-card" >
        <div class="layui-card-body">
            <table class="layui-table" lay-data="{url:'/rbac/rbac/get-perms-list',page: true,skin:'line',limit: 10, id:'main-table',method:'post'}" lay-filter="main-table" id ='id'>
                <thead>
                <tr>
                    <th lay-data="{field:'_name',width:'20%', sort: true,hide:true}">权限名称</th>
                    <th lay-data="{field:'name', width:'20%', sort: true,edit:'text'}">权限名称</th>
                    <th lay-data="{field:'description', width:'20%', sort: true,edit:'text'}">权限描述</th>
                    <th lay-data="{field:'created_at', width:'20%', sort: true}">创建时间</th>
                    <th lay-data="{field:'updated_at', width:'20%', sort: true}">更新时间</th>
                    <th lay-data="{fixed: 'right',width:'20%' ,title:'操作', align: 'center',toolbar: '#barDemo_hash'}">积分</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

<!--添加权限界面-->
    <div id="addPermsCard" class="trace-index layui-form" style="display:none;padding-right:5%;">
        <form class="layui-form" action="">
            <div class="layui-form-item" style="margin-top:20px;">
                <label class="layui-form-label layui-form-label-100">权限名称</label>
                <div class="layui-input-block layui-input-block-bottom">
                    <input type="text" name="name" autocomplete="off" lay-verify="required" placeholder="权限名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label layui-form-label-100">描述</label>
                <div class="layui-input-block layui-input-block-bottom">
                    <input  name="description" placeholder="描述" autocomplete="off" class="layui-input">
                </div>
            </div>
            <button class="layui-btn layui-bg-blue" style="display: none" id="btnSubmit" lay-submit
                    lay-filter="add">
                <i class="layui-icon">&#xe609;</i>保存
            </button>
        </form>
    </div>
</body>

<script type="text/html" id="barDemo_hash">
    <button class="pear-btn pear-btn-warming pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-vercode"></i></button>
    <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="del"><i class="layui-icon layui-icon-delete"></i></button>
</script>