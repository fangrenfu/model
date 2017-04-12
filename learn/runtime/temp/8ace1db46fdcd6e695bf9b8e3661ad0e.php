<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"G:\Git\model\web\web/../../learn/app/home\view\index_login.html";i:1478653473;s:68:"G:\Git\model\web\web/../../learn/app/all/view/index_indexlayout.html";i:1477967014;s:63:"G:\Git\model\web\web/../../learn/app/all/view/index_header.html";i:1478823866;}*/ ?>
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

<script type="text/javascript" src="<?php echo $ROOT; ?>/js/md5.js"></script>
<script>
        $(function () {
            //密码框回车提交
            $('#pwd').keydown(function(e){
                if(e.keyCode==13){
                    login_click();
                }
            });
        });
        function login_click(){
            var username=$('#username').val();
            var pwd=$('#pwd').val();
            if(!$("#loginForm").form('validate')||username==''||pwd=='') return;

            pwd=hex_md5(hex_md5(pwd)+'<?php echo $GUID; ?>');
            $.post('<?php echo $ROOT; ?>/home/login/checklogin',{username:username,pwd:pwd},function(result){
                if (result.status==1){
                    location="<?php echo $ROOT; ?>/admin/";
                }
                else {
                    $.messager.alert("错误",result.info,"error",pwdselect);
                }
            },'json');
        }
        //提示密码错误后选中密码输入框
        function pwdselect()
        {
            var a=$('#pwd');
            a.select();
            a.focus();
        }
    </script>
    <style type="text/css">
        body
        {
            margin: 0;
            padding: 0;
            background: url('<?php echo $ROOT; ?>/img/logback.png') repeat;
        }
        #head
        {
            margin: 0 auto;
            width: 705px;
            height: 90px;
            margin-top: 20px;
        }
        #content
        {
            position: relative;
            margin: 30px auto;
            width: 760px;
            min-height: 360px;
            height: auto;
            background: url(<?php echo $ROOT; ?>/img/dl.png) no-repeat;
            background-size: cover;
        }
        #cn_bg
        {
            overflow: hidden;
            display: inline-block;
            margin-top: 100px;
            margin-left: 10px;
        }
        #password
        {
            margin-top: 25px;
        }
        #user_name{
            margin-top: 40px;
            position: relative;
        }
        #password, #user_name
        {
            margin-left: 534px;
        }
        #login
        {
            display: block;
            background: url(<?php echo $ROOT; ?>/img/loginbtn_bg.gif);
            line-height: 42px;
            width: 112px;
            height: 42px;
            color: #FFF;
            font-family: "微软雅黑";
            text-decoration: none;
            position:absolute;
            right:54px;
            top: 260px;
            text-indent: 25px;
        }
        input
        {
            height: 25px;
            width: 130px;
            line-height: 25px;
            padding:0 5px;;
            border: 1px solid #999;
        }
        input:focus
        {
            border: 1px solid #294C8E;
        }
        #footer
        {
            width: 810px;
            margin: 0 auto;
            padding-top: 0px;
        }
        .label
        {
            width: 100px;
        }
    </style>
<body>
<form action="" method="post" name="loginForm" id="loginForm">
    <div id="head"> </div>
    <div id="content">
        <div id="cn_bg">
            <div id="user_name">
                <label for="username" class="label">
                    账号：</label>
                <input type="text" name="username" id="username" class="easyui-validatebox" data-options="iconCls:'icon icon-shield',validType:'minmaxLength[2,20]'" placeholder="教师号或者学号"/>
            </div>
            <div id="password">
                <label for="pwd" class="label">
                    密码：</label>
                <input type="password" name="pwd" id="pwd" class="easyui-validatebox" data-options="validType:'minLength[3]'" placeholder="输入密码" />
            </div>
            <a id="login" href="javascript:login_click()">登 录</a>
        </div>
    </div>
    <div id="footer">
        <img src="<?php echo $ROOT; ?>/img/footer_bg.png" width="809" height="73" alt="" /></div>
</form>
</body>
</html>
