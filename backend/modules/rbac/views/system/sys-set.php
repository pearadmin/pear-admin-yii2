<?php
use backend\assets\PearAsset;
PearAsset::register($this);
$this->registerJs($this->render('js/index.js'));
?>

<body class="pear-container">
    <form class="layui-form" action="">
        <div class="layui-card" >
            <div class="layui-card-header">内容设置</div>
            <div class="layui-card-body layui-row layui-col-space10" style="padding-bottom: 20px">
                <div class="layui-form-item" style="margin-top:20px;">
                    <div class="layui-col-md4">
                        <label class="layui-form-label layui-form-label-100 layui-form-label-required">网站标题</label>
                        <div class="layui-input-block layui-input-block-bottom">
                            <input type="text" name="logo_title"  lay-verify="" placeholder="网站标题" class="layui-input  " value="<?php echo $model['logo']['logo_title']; ?>" style="width: 100%;">
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <label class="layui-form-label layui-form-label-100">选项卡数量</label>
                        <div class="layui-input-block layui-input-block-bottom">
                            <input type="number" name="tab_max"  lay-verify="" placeholder="" class="layui-input" value="<?php echo $model['tab']['tab_max']; ?>">
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <label class="layui-form-label layui-form-label-100" >动画时长</label>
                        <div class="layui-input-block layui-input-block-bottom">
                            <input type="number" name="keep_load"  lay-verify="" placeholder="" class="layui-input" value="<?php echo $model['other']['keep_load']; ?>">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-col-md4">
                        <label class="layui-form-label layui-form-label-100 layui-form-label-required" style="">首页标题</label>
                        <div class="layui-input-block layui-input-block-bottom" >
                            <input type="text" name="index_title"  placeholder="标题" class="layui-input " value="<?php echo $model['tab']['index']['index_title']; ?>">
                        </div>
                    </div>
                    <div class="layui-col-md4">
                        <label class="layui-form-label layui-form-label-100">首页标题</label>
                        <div class="layui-input-block layui-input-block-bottom" style="position: relative">
                            <input type="text" name="index_href" placeholder="链接" class="layui-input" value="<?php echo $model['tab']['index']['index_href']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-card" >
            <div class="layui-card" >
                <div class="layui-card-header">网站视图设置</div>
                <div class="layui-card-body layui-row layui-col-space10" style="padding-bottom: 20px">
                    <div class="layui-form-item">
                        <div class="layui-input-block layui-input-block-bottom">
                            <input type="checkbox" name="session" lay-skin="primary" title="开启Tab记忆" <?php echo $model['tab']['session'] == true ? 'checked':'' ?>>
                            <input type="checkbox" name="muilt_tab" lay-skin="primary" title="开启多选项卡"  <?php echo $model['tab']['muilt_tab'] == true ? 'checked':'' ?>>
                            <input type="checkbox" name="verify_code" lay-skin="primary" title="开启登录验证码" <?php echo $model['other']['verify_code'] == true ? 'checked':'' ?>>
                            <input type="checkbox" name="menu_control" lay-skin="primary" title="开启多系统模式" <?php echo $model['menu']['control'] == true ? 'checked':'' ?>>
                            <input type="checkbox" name="menu_accordion" lay-skin="primary" title="开启单菜单模式" <?php echo $model['menu']['accordion'] == true ? 'checked':'' ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-card" >
            <div class="layui-card" >
                <div class="layui-card-header">右侧面板设置</div>
                <div class="layui-card-body layui-row layui-col-space10" style="padding-bottom: 20px;margin-top:-20px;">
                    <table class="layui-table" lay-filter="pannel-table" id="pannel-table"></table>
                    <script type="text/html" id="pannel-tr-set">
                        <a  lay-event="remove" style="color: #58bf7e;cursor:pointer;">删除</a>
                    </script>
                    <div class="layui-form-item pannel-add">
                        <i class="layui-icon layui-icon-add-1"></i> 新增
                    </div>
                    <input id="icon" type="hidden" >
                </div>
            </div>
        </div>

        <div class="layui-card" >
            <div class="layui-card" >
                <div class="layui-card-header">图片设置</div>
                <div class="layui-card-body layui-row layui-col-space10" >
                    <div class="layui-form-item" style="position: relative">
                        <label class="layui-form-label layui-form-label-100">网站LOGO</label>
                        <div class="layui-col-md4 img-upload-btn">
                            <div class="input-group">
                                <button type="button" class="pear-btn-sm pear-btn-primary primary upload-file" >上传图片</button>
                                <img class="pre-img" src="<?php echo $model['logo']['image'] ?>">
                                <input type="hidden" name="file_content">
                                <input type="hidden" name="file_name">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top:20px !important;">
                        <div class="layui-col-md12"  style="text-align: right;">
                            <button type="reset" class="pear-btn-sm pear-btn" style="padding:0 14px;">重 置 </button>
                            <button class="pear-btn-sm pear-btn-primary" lay-submit  lay-filter="sys-submit" style="padding:0 14px;margin-left:10px;">提 交
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
