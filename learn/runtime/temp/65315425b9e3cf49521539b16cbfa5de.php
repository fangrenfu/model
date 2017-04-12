<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:51:"G:\Git\model\web/../app/course\view\index_talk.html";i:1478658074;s:50:"G:\Git\model\web/../app/all/view/index_layout.html";i:1476756500;s:50:"G:\Git\model\web/../app/all/view/index_header.html";i:1478823866;}*/ ?>
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
    $(function(){
        $('#dg').datagrid({
            title:'《<?php echo $course['name']; ?>》的视频管理',idField:'id', striped:'true',pagination:'true',rownumbers:true,singleSelect:true,pageSize:20,
            url:'<?php echo $ROOT; ?>/admin/course/query',toolbar:'#toolbar',
            columns:[[
                {field:'name',title:'课名*',width:200,align:'center',editor:{type:'validatebox',options:{validType:' maxlLength[50]',required:true}}},
                {field:'video',title:'视频数',width:70,align:'center'},
                {field:'student',title:'学生数',width:70,align:'center'},
                {field:'date',title:'添加时间',width:130,align:'center'}
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
            },
            //点击单元格时候的事件
            onClickCell:function(index, field){
                var tt= $('#dg');
                tt.datagrid('startEditing',{index:index,field:field});
                current_datagrid=tt;
            },
            //数据行上右键菜单
            onRowContextMenu:function(e,rowindex,row){
                var tt=$('#dg');
                tt.datagrid('endEditing');
                if(tt.datagrid('editIndex')!=undefined) return;
                e.preventDefault();  //该方法将通知 Web 浏览器不要执行与事件关联的默认动作（如果存在这样的动作）
                tt.datagrid('selectRow',rowindex);
                $('#menu').menu('show',{
                    left: e.pageX,
                    top: e.pageY
                });
            }
        });
        //著作部分 绑定新建按钮事件
        $("#insert,#menu_insert").click(function(){
            var tt=$('#dg');
            tt.datagrid('endEditing');
            if(tt.datagrid('editIndex')!=undefined) return;
            tt.datagrid('insertRow',{
                index: 0,
                row: {

                }
            });
            tt.datagrid('startEditing',{field:'name',index:0});
            current_datagrid=tt;
        });
        //取消更改
        $("#cancel,#menu_cancel").click(function(){
            var tt= $('#dg');
            tt.datagrid('rejectChanges');
            current_datagrid=null;
        });
        //绑定点击保存按钮事件
        $("#menu_save,#save").click(function(){
            var tt=$('#dg');
            tt.datagrid('endEditing');
            if(tt.datagrid('editIndex')!=undefined) return;
            //获取更改的数据行内容
            var rows=tt.datagrid('getRows');
            rows=tt.datagrid('getChanges','updated');
            var count=0;
            var effectRow = {};
            if(rows.length>0){
                count+=rows.length;
                effectRow["updated"]=$.toJSON(rows);
            }
            //获取删除的行
            rows=tt.datagrid('getChanges','deleted');
            if(rows.length>0){
                count+=rows.length;
                effectRow["deleted"]=$.toJSON(rows);
            }
            //获取添加的行
            rows=tt.datagrid('getChanges','inserted');
            if(rows.length>0){
                count+=rows.length;
                effectRow["inserted"]=$.toJSON(rows);
            }
            if(count<=0) {
                $.messager.alert('提示','没有需要保存的数据！','info');
                return;
            }
            $.post('<?php echo $ROOT; ?>/admin/course/update',effectRow,function(result){
                if (result.status==1){
                    tt.datagrid('acceptChanges');
                    tt.datagrid('reload');
                    $.messager.show({	// show error message
                        title: '成功',
                        msg: result.info
                    });
                } else {
                    $.messager.alert('错误',result.info,'error');
                }
            },'json');
        });
        //右键菜单删除按钮
        $("#menu_delete,#delete").click(function(){
            var tt=$('#dg');
            var row = tt.datagrid('getSelected');
            if (row) {
                tt.datagrid('endEditing');
                var rowIndex = tt.datagrid('getRowIndex', row);
                tt.datagrid('deleteRow', rowIndex);
            }
            else{
                $.messager.alert('错误','请先选中一条记录','error')
            }
        });

        $("#menu_manage,#manage").click(function(){
            var tt=$('#dg');
            var row = tt.datagrid('getSelected');
            if (row) {
                var id=row.id;
                var url='/course/index/index?';
                window.open('<?php echo $ROOT; ?>'+url+'id='+id,'课程管理');
            }
            else{
                $.messager.alert('错误','请先选中一条记录','error')
            }
        });
    });
</script>
<div class="container">
    <div id="menu" class="easyui-menu" style="width:100px;">
        <div id='menu_insert' data-options="iconCls:'icon icon-add'">新增学院/部门</div>
        <div id='menu_save' data-options="iconCls:'icon icon-save'">保存</div>
        <div class="menu-sep"></div>
        <div id='menu_delete' data-options="iconCls:'icon icon-remove'">删除</div>
        <div id='menu_cancel' data-options="iconCls:'icon icon-cancel'">取消</div>
        <div id='menu_manage' data-options="iconCls:'icon icon-people'">课程管理</div>
    </div>
    <div id="toolbar">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon icon-add',plain:'true'"  id="insert">新增</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon icon-remove',plain:'true'"  id="delete">删除</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon icon-save',plain:'true'" id="save">保存</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon icon-cancel',plain:'true'" id="cancel">取消</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon icon-people',plain:'true'" id="manage">课程管理</a>
    </div>
    <table id="dg"></table>
    <div class="space"></div>
    <div class="information">
        <ol>说明：
            <li>有*标注的为可编辑单元，点击后可以修改内容。</li>
            <li>院号设置后无法更改。</li>
            <li>标记为废弃的学院/部门不会在下拉菜单中显示。</li>
            <li>标记为职能部门的学院/部门能对全校学生成绩更新。</li>
        </ol>
    </div>
</div>
 </body>
</html>