<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/component/pear/css/pear.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/person.css');
?>
<body class="pear-container">
<div class="layui-row layui-col-space10">
    <div class="layui-col-md3">
        <div class="layui-card">
            <div class="layui-card-body" style="padding: 25px;">
                <div class="text-center layui-text">
                    <div class="user-info-head" id="userInfoHead">
                        <img src="" id="userAvatar" width="115px" height="115px" alt="">
                    </div>
                    <h2 style="padding-top: 20px;font-size: 20px;">就眠仪式</h2>
                    <p style="padding-top: 8px;margin-top: 10px;font-size: 13.5px;">China ， 中国</p>
                </div>
            </div>
            <div style="height: 45px;border-top: 1px whitesmoke solid;text-align: center;line-height: 45px;font-size: 13.5px;">
                <span>今日事 ，今日毕</span>
            </div>
        </div>

        <div class="layui-card">
            <div class="layui-card-header">
                归档
            </div>
            <div class="layui-card-body">
                <ul class="list">
                    <li class="list-item"><span class="title">优化代码格式</span><span class="footer">2020-06-04 11:28</span></li>
                    <li class="list-item"><span class="title">新增消息组件</span><span class="footer">2020-06-01 04:23</span></li>
                    <li class="list-item"><span class="title">移动端兼容</span><span class="footer">2020-05-22 21:38</span></li>
                    <li class="list-item"><span class="title">系统布局优化</span><span class="footer">2020-05-15 14:26</span></li>
                    <li class="list-item"><span class="title">兼容多系统菜单模式</span><span class="footer">2020-05-13 16:32</span></li>
                    <li class="list-item"><span class="title">兼容多标签页切换</span><span class="footer">2019-12-9 14:58</span></li>
                    <li class="list-item"><span class="title">扩展下拉组件</span><span class="footer">2019-12-7 9:06</span></li>
                    <li class="list-item"><span class="title">扩展卡片样式</span><span class="footer">2019-12-1 10:26</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="layui-col-md9">
        <div class="layui-card">
            <div class="layui-card-header">
                我的文章
            </div>
            <div class="layui-card-body">
                <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space10" style="margin: 15px;">
                                <div class="layui-col-md1">
                                    <img src="/plugins/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
                                </div>
                                <div class="layui-col-md11" style="height: 80px;">
                                    <div class="title">为什么程序员们愿意在GitHub上开源自己的成果给别人免费使用和学习？</div>
                                    <div class="content">
                                        “Git的精髓在于让所有人的贡献无缝合并。而GitHub的天才之处，在于理解了Git的精髓。”来一句我们程序员们接地气的话：分享是一种快乐~
                                    </div>
                                    <div class="comment">2020-06-12 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论 5 点赞 12 转发 4</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/component/layui/layui.js"></script>
<script>
    layui.use(['jquery', 'element', 'layer'], function () {
        var element = layui.element,
            layer = layui.layer,
            $ = layui.jquery;

        let MODULE_PATH = "operate/";
        $("#userAvatar").attr("src", parent.layui.$(".layui-nav-img").attr("src"));

        window.callback = function (data) {
            layer.close(data.index);
            $("#userAvatar").attr("src", data.newAvatar);
            parent.layui.$(".layui-nav-img").attr("src", data.newAvatar);
        }

        $("#userAvatar").click(function () {
            layer.open({
                type: 2,
                title: '更换图片',
                shade: 0.1,
                area: ["900px", "500px"],
                content: MODULE_PATH + 'uploadProfile.html',
                btn: ['确定', '取消'],
                yes: function (index, layero) {
                    window['layui-layer-iframe' + index].submitForm();
                }
            });
        });
    });
</script>
</body>
</html>
