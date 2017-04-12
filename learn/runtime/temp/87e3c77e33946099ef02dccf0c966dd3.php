<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"G:\Git\model\web/../app/admin\view\index_log.html";i:1477014432;s:50:"G:\Git\model\web/../app/all/view/index_layout.html";i:1476756500;s:50:"G:\Git\model\web/../app/all/view/index_header.html";i:1478823866;}*/ ?>
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
 <body>
 <div id="w" class="easyui-window" title="请稍候..."
      data-options="modal:true,closed:true,closable:false,minimizable:false,maximizable:false,iconCls:'icon-save'"
      style="width:250px;height:80px;padding:10px;">数据保存中，请勿刷新页面！
 </div>

<script type="text/javascript">
    $(function() {
        $('#dg').datagrid({
            title:'操作日志',idField:'logid', striped:'true',pagination:'true',rownumbers:true,singleSelect:true,url:'<?php echo $ROOT; ?>/admin/log/query',toolbar:'#toolbar',pageSize:20,
            columns:[[
                {field:'host',title:'服务器',width:120},
                {field:'username',title:'账号',width:60,align:'center'},
                {field:'name',title:'姓名',width:60,align:'center'},
                {field:'role',title:'角色',width:60,align:'center'},
                {field:'requesttime',title:'访问时间',width:110,align:'center'},
                {field:'remoteip',title:'访问IP',width:100,align:'center'},
                {field:'url',title:'URL',width:200},
                {field:'operate',title:'操作',width:30,align:'center'},
                {field:'data',title:'提交数据',width:300}
            ]],
            //标题行右键菜单
            onHeaderContextMenu: function(e, field){
                e.preventDefault();
                if (!cmenu_obj.cmenu)//没有的话创建一个
                    $('#dg').datagrid('createColumnMenu',cmenu_obj);
                cmenu_obj.cmenu.menu('show', {
                    left:e.pageX,
                    top:e.pageY
                });
            }
        });
        $("#clearlog").click(function(){
            $.messager.confirm('确认','你确定要清空日志么？',function(r){
                if (r){
                    $.post('<?php echo $ROOT; ?>/admin/log/delete',function(result){
                        if (result.status==1){
                            $('#dg').datagrid('reload');	// reload the user data
                            $.messager.show({	// show error message
                                title: '成功',
                                msg: result.info
                            });
                        }
                        else {
                            $.messager.alert('错误',result.info,'error');
                        }
                    },'json');
                }
            });
        });
        $("#search").click(function(){
            var tt=$('#dg');
            tt.datagrid('loadData',{total:0,rows:[]});
            tt.datagrid('load', {
                start: $("#start").datebox("getValue"),
                end: $("#end").datebox("getValue"),
                username:$('#username').val(),
                url:$('#url').val()
            });
        });
    });
</script>

<div class="container">
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon icon-remove" plain="true"  id="clearlog">清空日志</a> |
        从 <input id="start" class="easyui-datetimebox" size="18"/> 到
        <input id="end" class="easyui-datetimebox" size="18"/>
        帐号:<input id="username" class="easyui-validatebox" onkeydown="if(event.keyCode==13) search();" size='8' value="%"/>
        动作：<input id="url" class="easyui-validatebox" onkeydown="if(event.keyCode==13) search();" size="20" value="%"/>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon icon-search" plain="true" id="search">筛选日志</a>
    </div>
    <table id="dg"></table>
</div>
 </body>
</html>