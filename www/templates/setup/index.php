<?PHP
//加载配置文件
Require('../../inc.config.php');

//加载数据库逻辑层类
Require('data/Database.php');

//加载缓存类
Require('data/Cache.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公司列表</title>
<link rel="stylesheet" href="<?PHP Echo(WEB_URL)?>www/templates/style/reset.css" type="text/css" />
<link rel="stylesheet" href="<?PHP Echo(WEB_URL)?>www/templates/style/layout.css" type="text/css" />
</head>
<body>
<!--Header BOF-->
<div id="header"></div>
<!--Header EOF-->
<!--Content BOF-->
<div id="content">
  <table width="97%" cellpadding="0" cellspacing="0" class="center">
    <tr>
      <td width="4%">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="button" name="add" id="add" value="新建" />
        <input type="button" name="edt" id="edt" value="查看/编辑" />
        <input type="button" name="makeup" id="makeup" value="定制" />
        <input type="button" name="del" id="del" value="删除" />
        <input type="button" name="finish" id="finish" value="完成" />
        <input type="button" name="extend" id="extend" value="延长使用时间" />
        <input type="button" name="send-info" id="send-info" value="帐号信息" />
        <input type="button" name="power-mgr" id="power-mgr" value="权限维护" />
        <input type="button" name="major-mgr" id="major-mgr" value="专业维护" />
        <input type="button" name="itskill-mgr" id="itskill-mgr" value="IT技能维护" />
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <form name="frm" id="frm" action="" method="post">
  <table width="97%" cellpadding="0" cellspacing="0" class="list-table center">
    <tr>
      <th width="2%"><input type="checkbox" name="select-alle" id="select-alle" value="check" /></th>
      <th width="7%">ID</th>
      <th width="27%">公司名称</th>
      <th width="21%">公司代码</th>
      <th width="16%">创建时间</th>
      <th width="18%">到期时间</th>
      <th width="9%">后台</th>
    </tr>
    <!--Company list BOF-->
    <{section name=row loop=$Companys}>
    <tr>
      <td><input type="checkbox" name="select-one" id="select-one<{$Companys[row].com_id}>" value="<{$Companys[row].comID}>"  /></td>
      <td><{$Companys[row].com_id}>(<{$Companys[row].language}>)</td>
      <td><{$Companys[row].com_name_cn}></td>
      <td><{$Companys[row].com_code}></td>
      <td><{$Companys[row].create_date}></td>
      <td><{$Companys[row].end_date}></td>
      <td><a href="com_login.php?com_id=<{$Companys[row].com_id}>" target="_blank">登录</a></td>
    </tr>
    <{/section}>
    <!--Company list EOF-->
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>
  </form>
</div>
<!--Content EOF-->
<!--Footer BOF-->
<div id="footer"></div>
<!--Footer EOF-->
</body>
<script src="<?PHP Echo(WEB_URL)?>www/templates/javascript/mootools.js" type="text/javascript"></script>
<script src="<?PHP Echo(WEB_URL)?>www/templates/javascript/checkall.js" type="text/javascript"></script>
<script src="<?PHP Echo(WEB_URL)?>www/templates/javascript/zebratable.js" type="text/javascript"></script>
<script language="javascript">
<!--
document.addEvent('domready', function(){
    //初始化表格样式
	var checkalls = new CheckAll({
        selectedAll: 'select-alle',
        selectedChildren: 'select-one'
    });
	
	//提交按钮点击
    $('get-checked').addEvent('click', function(){
     var result= new Array();
       $$('[name=select-one]').each(function(el){
            if(el.checked == true)
            {
                result += el.value+',';
            }
        });
        alert(result.substring(0, result.length-1));
    });
});
-->
</script>
</html>
