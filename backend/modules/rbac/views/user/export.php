<?php
$this->registerJs($this->render('js/export.js'));
?>
<style>
    .layui-select-title{
        position: relative;
    }
    .option-checkbox-container{
        position: absolute;
        top:50px;
        left: 0px;
        padding: 10px;
        background: white;
        margin-top: -10px;
        z-index: 999;
        display: none;
    }
    .layui-filter-panel{
        max-height:220px;
        overflow-y: auto;
    }
    .layui-filter-panel::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
</style>
<body class="pear-container">
<form class="layui-form" action="" onsubmit="return false">
    <div class="layui-form-item">
        <input type="hidden" id="param" value="<?php echo $param?>">
        <input type="hidden" id="url" value="<?php echo $url?>">
        <label class="layui-form-label test">表头</label>
        <div class="layui-col-xs5">
            <div class="layui-select-title">
                <div class="layui-form-select">
                    <div class="layui-select-title">
                        <input id="diy_header" type="text" placeholder="自定义表头"  readonly class="layui-input">
                        <i class="layui-edge"></i>
                    </div>
                </div>
                <div class="option-checkbox-container ">
                    <ul class="layui-filter-panel">
                        <?php foreach ($header as $k=>$v): ?>
                            <li>
                                <input type="checkbox" name="<?php echo $k?>" title="<?php echo $v?>" checked lay-skin="primary" >
                                <div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
                                    <span><?php echo $v?></span>
                                    <i class="layui-icon layui-icon-ok"></i>
                                </div>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
        <div >
            <button style="margin-left:10px;" class="layui-btn pear-btn-primary" id="export">导出</button>
        </div>
    </div>
</form>
</body>