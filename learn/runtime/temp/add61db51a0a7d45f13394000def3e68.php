<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:51:"G:\Git\model\web/../app/admin\view\index_index.html";i:1491978814;s:55:"G:\Git\model\web/../app/all/view/index_indexlayout.html";i:1477967014;s:50:"G:\Git\model\web/../app/all/view/index_header.html";i:1478823866;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $TITLE; ?></title>
    <link rel="shortcut icon" href="<?php echo $ROOT; ?>/img/favicon.ico?t=29.ico" type="image/x-icon" />
    <link href="<?php echo $ROOT; ?>/widget/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ROOT; ?>/widget/easyui/themes/icon.css" rel="stylesheet" type="text/css"  />
    <script type="text/javascript" src="<?php echo $ROOT; ?>/js/browsercheck.js"></script>
    <script type="text/javascript">
        var browser=browsercheck();
        if(browser.browser=="IE"&&parseFloat(browser.version)<9.0)
            location.href="<?php echo $ROOT; ?>/home/index/download";
    </script>
    <script type="text/javascript" src="<?php echo $ROOT; ?>/widget/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $ROOT; ?>/js/jquery.fileDownload.min.js"></script>  <!--文件导出-->
    <script type="text/javascript" src="<?php echo $ROOT; ?>/widget/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?php echo $ROOT; ?>/widget/easyui/locale/easyui-lang-zh_CN.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $ROOT; ?>/css/common.css" />
    <script type="text/javascript" src="<?php echo $ROOT; ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo $ROOT; ?>/js/easyui.extend.js"></script>
    <script type="text/javascript" src="<?php echo $ROOT; ?>/js/jquery.json.js"></script>

    <script type="text/javascript">
        var current_datagrid=null;
        var cmenu_obj={};
        cmenu_obj.cmenu=""; //标题行右键菜单
        $(function() {
            $(document).keydown(function (event) {
                if (current_datagrid != null) { //如果正在编辑
                    if (event.which == 9) {
                        event.preventDefault();
                        current_datagrid.datagrid('nextEditor');
                    }
                    else if (event.which == 13) {
                        event.preventDefault();
                        current_datagrid.datagrid('nextEditor', 'col');
                    }
                }
            });
        });
    </script>
</head>

<body class="easyui-layout"   fit="true"   scroll="no" >
<script type="text/javascript">
    var menuTabs = null;
    $(function() {
        _menus = eval('(' + '<?php echo $menu; ?>' + ')');
        menuTabs = $("#west").cwebsFrame(_menus, "功能介绍");

        $('#loading-mask').fadeOut(); //关闭遮罩
        //绑定退出事件
        $('#loginOut').click(function() {
            $.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {
                if (r) {
                    location.href = '<?php echo $ROOT; ?>/home/login/logout';
                }
            });
        });
        var s=decodeURI(getRequest());
        if (isNaN(s))
            menuTabs.menuObj.accordion('select', s);
        else {
            var obj = $("a[menuid='" + s + "']");
            obj.click();
            obj.each(function () {
                menuTabs.menuObj.accordion('select', $(this).parents('.panel').children().first().text());
            });
        }

    });
</script>
<noscript>
    抱歉，请开启脚本支持！
</noscript>
<!-- 正在加载窗口 -->
<div id="loading-mask" >
    <div id="pageloading">
        <img src="<?php echo $ROOT; ?>/img/loading.gif" align="absmiddle" /> 正在加载中,请稍候...
    </div>
</div>
<!-- 头部 -->
<div id="top" region="north" split="false" border="false" >
    <span style="float:right; padding-right:30px;">
        <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon icon-role'"><?php echo $USERINFO['username']; ?>/<?php echo $USERINFO['realname']; ?>(<?php echo $USERINFO['schoolname']; ?>)</a> |
        <a href="<?php echo $ROOT; ?>/admin/"  class="easyui-linkbutton" data-options="plain:true,iconCls:'icon icon-home'">返回首页</a>
        <a href="#"  class="easyui-linkbutton" data-options="plain:true,iconCls:'icon icon-exit'" id="loginOut">退出</a>
    </span>
    <span style="padding-left:10px; font-size: 16px; "><img src="<?php echo $ROOT; ?>/img/logo_min.jpg" /></span>
</div>
<!-- 左侧菜单 -->
<div region="west" split="true"  title="功能导航" style="width:130px;" id="west"></div>
<!-- 初始内容页 -->
<div data-options="region:'center',border:'false'" style="overflow: hidden" scroll="no">
    <div class="easyui-tabs" name="__mainTabs__"  fit="true" border="false" style="overflow: hidden" scroll="no" >
        <div class="welcome">
            欢迎使用系统管理
        </div>
    </div>
</div>
<div id="footer" data-options="region:'south',border:false">
    <?php echo $COPYRIGHT; ?>
</div>
</body>
</html>