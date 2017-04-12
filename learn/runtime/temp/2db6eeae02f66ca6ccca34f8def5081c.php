<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:50:"G:\Git\model\web/../app/home\view\index_index.html";i:1478068561;s:55:"G:\Git\model\web/../app/all/view/index_indexlayout.html";i:1477967014;s:50:"G:\Git\model\web/../app/all/view/index_header.html";i:1476756500;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $TITLE; ?></title>
    <link rel="shortcut icon" href="<?php echo $ROOT; ?>/img/favicon.ico?t=29.ico" type="image/x-icon" />
    <!--[if lt IE 9]>
    <script type="text/javascript">
        location.href="<?php echo $ROOT; ?>/home/index/download";
    </script>
    <![endif]-->
    <link href="<?php echo $ROOT; ?>/widget/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ROOT; ?>/widget/easyui/themes/icon.css" rel="stylesheet" type="text/css"  />
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

<body >
<script type="text/javascript">
    $(function() {
        //绑定退出事件
        $('#loginout').click(function() {
            $.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {
                if (r) {
                    location.href = '<?php echo $ROOT; ?>/home/login/logout';
                }
            });
        });
    });
</script>
<style>
    *{ padding:0px; margin:0px; }
    img{ border:none;}
    .head{ background:url("<?php echo $ROOT; ?>/img/top.jpg") no-repeat; width:1002px; height:115px; margin:0 auto;}
    body{ background:url("<?php echo $ROOT; ?>/img/bg.jpg") repeat-x; font-size:12px; color:#6f6f6f; }
    .teach{ height:auto;width:1002px; margin-left:0 ; margin:0 auto;}
    a.red{ font-size:14px;  font-weight:bold; color:#ff0000; text-decoration:underline;}
    .style_blue14{font-family:"宋体";font-size:14px; font-weight:bold; color:#3e65af}
    #border-top{height:11px;background:url("<?php echo $ROOT; ?>/img/j-bg2.jpg")}
    #border-bottom{height:11px;background:url("<?php echo $ROOT; ?>/img/j-bg3.jpg")}
    #footer{font-family:"宋体";font-size:14px;}
</style>
<div class="head"></div>
<div class="teach">
    <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tbody><tr>
            <td id="border-top"></td>
        </tr>
        <tr>
            <td align="center" valign="top" background="<?php echo $ROOT; ?>/img/j-bg.jpg">
                <table width="93%" height="32" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="4%" align="center"><img src="<?php echo $ROOT; ?>/img/point.jpg" width="11" height="11" /></td>
                        <td width="96%" align="left" ><a class="style_blue14" href="<?php echo $ROOT; ?>/base/index/index"> 基础数据</a></td>
                    </tr>
                </table>
                <table width="93%" height="2" border="0" cellpadding="0" cellspacing="0" bgcolor="#85a1d5">
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <table width="93%" height="67" border="0" cellpadding="0" cellspacing="0">
                    <tr align="center">
                        <td><a href="<?php echo $ROOT; ?>/admin/" ><img src="<?php echo $ROOT; ?>/img/j1.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/base/?248"><img src="<?php echo $ROOT; ?>/img/j14.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/base/?249"><img src="<?php echo $ROOT; ?>/img/j9.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/base/?254"><img src="<?php echo $ROOT; ?>/img/j4.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/base/?257"><img src="<?php echo $ROOT; ?>/img/j6.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/base/?262"><img src="<?php echo $ROOT; ?>/img/j22.jpg" /></a></td>
                    </tr>
                </table>
                <table width="93%" height="32" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="4%" align="center"><img src="<?php echo $ROOT; ?>/img/point.jpg" width="11" height="11" /></td>
                        <td width="96%" align="left" class="style_blue14">教务过程</td>
                    </tr>
                </table>
                <table width="93%" height="2" border="0" cellpadding="0" cellspacing="0" bgcolor="#85a1d5">
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <table width="93%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="55" align="center">
                        <td><a href="<?php echo $ROOT; ?>/major/?1431" ><img src="<?php echo $ROOT; ?>/img/j24.jpg" /></a></td>
                        <td><a href="/courseplan" ><img src="<?php echo $ROOT; ?>/img/j3.jpg" /></a></td>
                        <td><a href="/schedule" ><img src="<?php echo $ROOT; ?>/img/j8.jpg" /></a></td>
                        <td><a href="/CourseManager"><img src="<?php echo $ROOT; ?>/img/j13.jpg" /></a></td>
                        <td><a href="/book"><img src="<?php echo $ROOT; ?>/img/j20.jpg" /></a></td>
                        <td><a href="/exam"><img src="<?php echo $ROOT; ?>/img/j11.jpg" /></a></td>
                    </tr>
                    <tr height="55" align="center">
                        <td><a href="/Results"><img src="<?php echo $ROOT; ?>/img/j12.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/major/?1434"><img src="<?php echo $ROOT; ?>/img/j25.jpg" /></a></td>
                        <td><a href="/workload" ><img src="<?php echo $ROOT; ?>/img/j16.jpg" /></a></td>
                        <td><a href="/Quality" ><img src="<?php echo $ROOT; ?>/img/j19.jpg" /></a></td>
                        <td><a href="/credit"><img src="<?php echo $ROOT; ?>/img/j23.jpg" /></a></td>
                        <td><a href="/attendance" ><img src="<?php echo $ROOT; ?>/img/j21.jpg" /></a></td>
                    </tr>
                </table>
                <table width="93%" height="32" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="4%" align="center"><img src="<?php echo $ROOT; ?>/img/point.jpg" width="11" height="11" /></td>
                        <td width="96%" align="left" class="style_blue14">开发中</td>
                    </tr>
                </table>
                <table width="93%" height="2" border="0" cellpadding="0" cellspacing="0" bgcolor="#85a1d5">
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <table width="93%" height="67" border="0" cellpadding="0" cellspacing="0">
                    <tr align="center">
                        <td><a href="<?php echo $ROOT; ?>/plan/" ><img src="<?php echo $ROOT; ?>/img/j3.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/selective/"><img src="<?php echo $ROOT; ?>/img/j13.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/score/"><img src="<?php echo $ROOT; ?>/img/j12.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/quality/" ><img src="<?php echo $ROOT; ?>/img/j19.jpg" /></a></td>
                        <td><a href="#" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j41.jpg" /></a></td>
                        <td><a href="#" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j41.jpg" /></a></td>
                    </tr>
                </table>
                <table width="93%" height="32" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="4%" align="center"><img src="<?php echo $ROOT; ?>/img/point.jpg" width="11" height="11" /></td>
                        <td width="96%" align="left" class="style_blue14">查询分析</td>
                    </tr>
                </table>
                <table width="93%" height="2" border="0" cellpadding="0" cellspacing="0" bgcolor="#85a1d5">
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <table width="93%" height="67" border="0" cellpadding="0" cellspacing="0">
                    <tr align="center" height="55">
                        <td><a href="<?php echo $ROOT; ?>/analysis/?1400" ><img src="<?php echo $ROOT; ?>/img/j7.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/analysis/?1397" ><img src="<?php echo $ROOT; ?>/img/j34.jpg" /></a></td>
                        <td><a href="/semestertimetable" style="visibility:hidden"  ><img src="<?php echo $ROOT; ?>/img/j10.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/analysis/index/index" style="visibility:hidden" ><img src="<?php echo $ROOT; ?>/img/j31.jpg" /></a></td>
                        <td><a href="/statistic/index/jssktj" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j32.jpg" /></a></td>
                        <td><a href="/statistic/index/xjqktj" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j33.jpg" /></a></td>
                    </tr>
                    <!--数据统计
                   <tr  align="center" height="55">
                       <td><a href="/statistic/index/xktj" ><img src="<?php echo $ROOT; ?>/img/j35.jpg" /></a></td>
                       <td><a href="/statistic/index/jczxsjxz" ><img src="<?php echo $ROOT; ?>/img/j36.jpg" /></a></td>
                       <td><a href="/results/index/cjfx" ><img src="<?php echo $ROOT; ?>/img/j37.jpg" /></a></td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                      <td align="right"><a href="<?php echo $ROOT; ?>/statistic" ><img src="<?php echo $ROOT; ?>/img/j15.jpg" /></a></td>
                    </tr>
                    -->
                </table>
                <table width="93%" height="32" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="4%" align="center"><img src="<?php echo $ROOT; ?>/img/point.jpg" width="11" height="11" /></td>
                        <td width="96%" align="left" ><a  class="style_blue14" href="<?php echo $ROOT; ?>/teacher/index/index">个人信息</a></td>
                    </tr>
                </table>
                <table width="93%" height="2" border="0" cellpadding="0" cellspacing="0" bgcolor="#85a1d5">
                    <tr>
                        <td align="left"></td>
                    </tr>
                </table>
                <table  width="93%" height="67" border="0" cellpadding="0" cellspacing="0">
                    <tr align="center">
                        <td><a href="<?php echo $ROOT; ?>/teacher/?232"><img src="<?php echo $ROOT; ?>/img/j38.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/teacher/?233"><img src="<?php echo $ROOT; ?>/img/j40.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/teacher/?234"><img src="<?php echo $ROOT; ?>/img/j39.jpg" /></a></td>
                        <td><a href="<?php echo $ROOT; ?>/teacher/?270"><img src="<?php echo $ROOT; ?>/img/j41.jpg" /></a></td>
                        <td><a href="#" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j2.jpg" /></a></td>
                        <td><a href="#" style="visibility:hidden"><img src="<?php echo $ROOT; ?>/img/j41.jpg" /></a></td>
                    </tr>
                </table>
                <table width="30%" border="0" cellspacing="0" cellpadding="0" style="margin:10px auto;">
                    <tbody><tr>
                        <td align="center" valign="middle"><a href="#"  id="loginout" ><img src="<?php echo $ROOT; ?>/img/but3.jpg"></a></td>
                        <td align="left" valign="middle"><a href="<?php echo $ROOT; ?>/teacher/index/index?267" class="red">修改密码</a></td>
                        <td align="left" valign="middle"><a  style="visibility:hidden" href="/Teacher/"class="red">进入易科开发版</a></td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr>
            <td id="border-bottom"></td>
        </tr>
        </tbody></table>

</div>
<div id="footer">
    <?php echo $COPYRIGHT; ?>
</div>
</body>
</html>