<?php
$this->registerJs($this->render('js/index.js'));
?>
<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <div class="layui-form-item layui-inline">
                        <label class="layui-form-label">部门</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" placeholder="" required class="layui-input" >
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
            </form>
        </div>
    </div>
    <div class="layui-card">
        <div class="layui-card-body">
            <table class="layui-table" lay-filter="main-table" id ='main-table' >
                <script type="text/html" id="power-bar">
                    <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
                    <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
                </script>

                <script type="text/html" id="icon">
                    <i class="layui-icon {{d.icon}}"></i>
                </script>
            </table>
        </div>
    </div>
</body>

<script type="text/html" id="power-toolbar">
    <button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
        <i class="layui-icon layui-icon-add-1"></i>
        新增
    </button>
    <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
        <i class="layui-icon layui-icon-delete"></i>
        删除
    </button>
    <button class="pear-btn pear-btn-success pear-btn-md" lay-event="expandAll">
        <i class="layui-icon layui-icon-spread-left"></i>
        展开
    </button>
    <button class="pear-btn pear-btn-success pear-btn-md" lay-event="foldAll">
        <i class="layui-icon layui-icon-shrink-right"></i>
        折叠
    </button>
</script>


