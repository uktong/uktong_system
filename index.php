<?php
require "hzb/config.php";
require R.'hzb/class/db.class.php';
require R.'hzb/class/Jurisdiction.class.php';
if (!isset($_COOKIE["userid"])||$_COOKIE["userid"]=="")
    {
        
        $url->to("login.php");
        
    }
   

    $new=$db->select("ukt_jurisdiction", "Jurisdiction", "type='".$_COOKIE["usertype"]."' and userid=".$_COOKIE["userid"]);
    $quanxian=$db->select("t_travelpermission", "*", "1=1 order by sort ");
    $Jurobj=new Jurisdiction($quanxian);
    $Jur=$Jurobj->Jresult($new[0]["Jurisdiction"]);
    $Jurlist=array();
    foreach ($Jur as $a){
        if ($a["lastid"]==0){
            $oneJur=$a;
            $son=array();
            foreach ($Jur as $b){
                if($b["lastid"]==$a["id"]){
                    array_push($son, $b);
                    $oneJur["son"]=$son;
                }
            }
            array_push($Jurlist, $oneJur);
        }
    }
    $userfile = fopen("cache/Jur/".md5($_COOKIE["username"]).".json", "w") or die("Unable to open file!");
    $usertxt = json_encode($Jurlist);
    fwrite($userfile, $usertxt);
    fclose($userfile);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $servername.$version;?></title>

<link href="themes/azure/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lt IE 9]><script src="js/speedup.js" type="text/javascript"></script><script src="js/jquery-1.11.3.min.js" type="text/javascript"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="js/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->
<script type="text/javascript">
var mask=$('#background,#progressBar');
mask.show();
</script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<!--<script src="js/jquery.bgiframe.js" type="text/javascript"></script>-->
<script src="xheditor/xheditor-1.2.2.min.js" type="text/javascript"></script>
<script src="xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>


<script src="js/dwz.core.js" type="text/javascript"></script>
<script src="js/dwz.util.date.js" type="text/javascript"></script>
<script src="js/dwz.validate.method.js" type="text/javascript"></script>
<script src="js/dwz.barDrag.js" type="text/javascript"></script>
<script src="js/dwz.drag.js" type="text/javascript"></script>
<script src="js/dwz.tree.js" type="text/javascript"></script>
<script src="js/dwz.accordion.js" type="text/javascript"></script>
<script src="js/dwz.ui.js" type="text/javascript"></script>
<script src="js/dwz.theme.js" type="text/javascript"></script>
<script src="js/dwz.switchEnv.js" type="text/javascript"></script>
<script src="js/dwz.alertMsg.js" type="text/javascript"></script>
<script src="js/dwz.contextmenu.js" type="text/javascript"></script>
<script src="js/dwz.navTab.js" type="text/javascript"></script>
<script src="js/dwz.tab.js" type="text/javascript"></script>
<script src="js/dwz.resize.js" type="text/javascript"></script>
<script src="js/dwz.dialog.js" type="text/javascript"></script>
<script src="js/dwz.dialogDrag.js" type="text/javascript"></script>
<script src="js/dwz.sortDrag.js" type="text/javascript"></script>
<script src="js/dwz.cssTable.js" type="text/javascript"></script>
<script src="js/dwz.stable.js" type="text/javascript"></script>
<script src="js/dwz.taskBar.js" type="text/javascript"></script>
<script src="js/dwz.ajax.js" type="text/javascript"></script>
<script src="js/dwz.pagination.js" type="text/javascript"></script>
<script src="js/dwz.database.js" type="text/javascript"></script>
<script src="js/dwz.datepicker.js" type="text/javascript"></script>
<script src="js/dwz.effects.js" type="text/javascript"></script>
<script src="js/dwz.panel.js" type="text/javascript"></script>
<script src="js/dwz.checkbox.js" type="text/javascript"></script>
<script src="js/dwz.history.js" type="text/javascript"></script>
<script src="js/dwz.combox.js" type="text/javascript"></script>
<script src="js/dwz.file.js" type="text/javascript"></script>
<script src="js/dwz.print.js" type="text/javascript"></script>
<style type="text/css">
		 .buttonActive .buttonContent, .buttonActive{
		 	width:40px;
		 	text-align:center;
			background:none;
			background-color:#ff4400;
			
		}
		 .buttonActive .buttonContent button {
		 	text-align:center;
		color:white;
		}
	.tableline td{
	text-align:center;
	}
p{
	border-bottom:1px solid #8db2e3;
	border-right:1px solid #8db2e3;
}
.pageFormContent  .customer,.pageFormContent .planremark{
	width:90%;
}

</style>
<script src="js/dwz.regional.zh.js" type="text/javascript"></script>
<script type="text/javascript">

$(function(){

	DWZ.init("dwz.frag.xml", {
		loginUrl:"login.php", loginTitle:"登录",	// 弹出登录对话框
		loginUrl:"login.php",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		keys: {statusCode:"statusCode", message:"message"}, //【可选】
		ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"themes"}); // themeBase 相对于index页面的主题base路径
		}
	});


	
});


</script>

</head>

<body onload="mask.fadeOut();">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo" href="#"></a>
				
				<ul class="nav">
			<li><a href="javascript:void(0);">用户：<?php echo $_COOKIE["username"];?></a></li>
<!-- 					<li><a href="changepwd.html" target="dialog" rel="changepwd" width="600">设置</a></li> -->
					<li><a href="login.php">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
				<li theme="azure"><div class="selected">天蓝</div></li>
					<li theme="default"><div >蓝色</div></li>
					<li theme="green"><div>绿色</div></li>
					<!--<li theme="red"><div>红色</div></li>-->
					<li theme="purple"><div>紫色</div></li>
					<li theme="silver"><div>银色</div></li>
					
				</ul>
			</div>

			<!-- navMenu -->

		</div>

		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

				<div class="accordion" fillSpace="sidebar">
					<div class="accordionHeader">
						<h2><span>Folder</span>功能菜单</h2>
					</div>
					<div class="accordionContent">
					
						<ul class="tree treeFolder">
						<?php //获取权限
					
						foreach ($Jurlist as $l){
						    if ($l["state"]=="1"){
						?>
							<li><a><?php echo $l["comment"];?></a>
								<ul>
							<?php if(is_array($l["son"])){foreach ($l["son"] as $s){ if ($s["state"]=="1"){?>
									<li ><a href="<?php echo $s["url"];?>?J=<?php echo md5($s["name"]);?>" target="navTab" rel="<?php echo $s["name"];?>"><?php echo $s["comment"];?></a></li>
								<?php }}
						}?>	
								</ul>
							</li>
						<?php }}?>	
						</ul>
					</div>
					
				</div>
			</div>
		</div>
		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
					<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">我的主页</a></li>
				</ul>
				<div class="navTab-panel tabsPageContent layoutBox" style="overflow:scroll;">
					<div class="page unitBox" >

<div class="divider"></div>


						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>

	</div>

	<div id="footer">Copyright &copy; <?php echo $copyrightyear;?> <a href="#" target="dialog"><?php echo $copyrightname;?></a> <?php echo $copyrighttext;?> </div>

</body>
</html>