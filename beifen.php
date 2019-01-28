<?php

require "hzb/config.php";
require R.'hzb/class/db.class.php';
require R.'hzb/class/Jurisdiction.class.php';
if (!isset($_COOKIE["userid"])||$_COOKIE["userid"]=="")
{
    
    $url->to("login.php");
    
}


$new=$db->select("ukt_jurisdiction", "Jurisdiction", "type='".$_COOKIE["usertype"]."' and userid=".$_COOKIE["userid"]);
$quanxian=$db->select("t_travelpermission", "*", "1=1");
$Jurobj=new Jurisdiction($quanxian);
$Jur=$Jurobj->Jresult($new[0]["Jurisdiction"]);
var_dump($Jur);
$qx=explode(",", $new[0]["userpermission"]);
$presNamea=array();
for($a=1;$a<count($qx);$a++){
    foreach ($quanxian as $q){
        if ($qx[$a]==$q["id"]) {
            array_push($presNamea, $q["presName"]);
        }
    }
    
}
function checkin($presName){
    global $presNamea;
    if(in_array($presName, $presNamea)){
        return true;
    }else{
        return false;
    }
}

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

<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<!--<script src="js/jquery.bgiframe.js" type="text/javascript"></script>-->
<script src="xheditor/xheditor-1.2.2.min.js" type="text/javascript"></script>
<script src="xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

<!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->

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
<!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换时下面dwz.regional.zh.js还需要引入)
<script src="bin/dwz.min.js" type="text/javascript"></script>
-->
<style type="text/css">
		.cwglbtn .buttonActive .buttonContent,.cwglbtn .buttonActive{
			background:none;
			background-color:#ff4400;
			
		}
		.cwglbtn .buttonActive .buttonContent button {
		color:white;
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

<body>
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo" href="#"></a>
				
				<ul class="nav">
				<li><a href="<?php echo $_COOKIE["usertype"]=="lxs"?"online.php":"javascript:void(0);";?>" target="dialog" rel="showonline" width="600" mask="true">当前在线人数：<span id="newnum" style="color: red;"><?php echo $usernum;?></span></a></li>
				<li><a href="<?php 
				if($_COOKIE["usertype"]=="hotel"){
				    echo "jd";
				    
				}else if($_COOKIE["usertype"]=="travel"){
				    echo "lxs";
				    
				}
				
				?>daiding/index.php?msg=newmsg" target="navTab" title="订单确认" rel="daidingxm">新订单：<span id="newmsg" style="color: red;">0</span> </a></li>
				<?php if($_COOKIE["usertype"]=="lxs"){?><li><a href="<?php echo $_COOKIE["usertype"]!="lxs"?"jd":"";?>daiding/index.php?lxsmsg=newlxsmsg" target="navTab" title="代定项目" rel="daidingxm">旅行社新订单：<span id="newlxsmsg" style="color: red;">0</span> </a></li><?php }?>
				<li><a href="javascript:void(0);">用户：<?php echo $user;?></a></li>
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
						<?php if($_SESSION["usertype"]=="hotel"){?>
						<li ><a >接团管理</a>
							<?php 
								$qxsql=mysqli_query($con, "select userlimit from t_hoteluser where id=".$_SESSION["userid"]);
								$qx=mysqli_fetch_array($qxsql);
								$allqx=explode(",", $qx["userlimit"]);
								$show="";
								$hide="style='display:none;'";
								$limitchangepwd=$hide;
								$limitshow=$hide;
								$limitadd=$hide;
								$limitsure=$hide;
								$limitft=$hide;
								for($q=1;$q<count($allqx);$q++){
								  
								    if($allqx[$q]=="updatepwd"){
								        $limitchangepwd=$show;
								    }
								    if($allqx[$q]=="show"){
								        $limitshow=$show;
								    }
								    if($allqx[$q]=="new"){
								        $limitadd="style='display:block;'";
								    }
								    if($allqx[$q]=="sure"){
								        $limitsure="style='display:block;'";
								    }
								    if($allqx[$q]=="ft"){
								        $limitft="style='display:block;'";
								    }
								}
								?>
								<ul>
								<li <?php echo $limitadd;?>><a  href="jddaiding/daiding.php" target="navTab" rel="jddaiding">临时订单</a>
								
							</li>
							<li <?php echo $limitsure;?>><a href="jddaiding/index.php" target="navTab" rel="jddaidingxm">订单确认</a>
								
							</li>
							<li <?php echo $limitshow;?>><a href="jddaiding/ddck.php" target="navTab" rel="ddck">订单查看</a>
								</li>
							</ul>
							</li>
							<li><a>资源中心</a>
								<ul>
									
									<li <?php echo $limitft;?>><a href="zyzx/jdfthotel.php" target="navTab" rel="jdft">房态管理</a></li>
								</ul>
							</li>
							<li><a>系统管理</a>
								<ul>
							
									<li <?php echo $limitchangepwd;?>><a href="xtgl/changepwd.php" target="navTab" rel="changepwd">修改密码</a></li>
									
								</ul>
							</li>
							<?php }else if($_SESSION["usertype"]=="travel"){?>
							
							<li ><a >接团管理</a>
							<?php 
								$qxsql=mysqli_query($con, "select userlimit from t_traveluser where id=".$_SESSION["userid"]);
								$qx=mysqli_fetch_array($qxsql);
								$allqx=explode(",", $qx["userlimit"]);
								$show="";
								$hide="style='display:none;'";
								$limitchangepwd=$hide;
								$limitshow=$hide;
								$limitadd=$hide;
								$limitsure=$hide;
								$limitft=$hide;
								for($q=1;$q<count($allqx);$q++){
								  
								    if($allqx[$q]=="updatepwd"){
								        $limitchangepwd=$show;
								    }
								    if($allqx[$q]=="show"){
								        $limitshow=$show;
								    }
								    if($allqx[$q]=="new"){
								        $limitadd="style='display:block;'";
								    }
								    if($allqx[$q]=="sure"){
								        $limitsure="style='display:block;'";
								    }
								    if($allqx[$q]=="ft"){
								        $limitft="style='display:block;'";
								    }
								}
								?>
								<ul>
								<li <?php echo $limitadd;?>><a  href="lxsdaiding/daiding.php" target="navTab" rel="jddaiding">临时订单</a>
								
							</li>
							<li <?php echo $limitsure;?>><a href="lxsdaiding/index.php" target="navTab" rel="jddaidingxm">订单确认</a>
								
							</li>
							<li <?php echo $limitshow;?>><a href="lxsdaiding/ddck.php" target="navTab" rel="ddck">订单查看</a>
								</li>
							</ul>
							</li>
							
							<li><a>系统管理</a>
								<ul>
							
									<li <?php echo $limitchangepwd;?>><a href="xtgl/changepwd.php" target="navTab" rel="changepwd">修改密码</a></li>
									
								</ul>
							</li>
							
							
							
							<?php }else{?>
							<?php if(checkin("jtgl")){?><li ><a >接团管理</a>
								<ul>
							
						<?php if(checkin("ddxm")){?>	<li><a href="daiding/index.php" target="navTab" rel="daidingxm">代定酒店项目</a>
								
							</li><?php }?>
							<?php if(checkin("lydd")){?>	<li><a href="daiding/lydd.php" target="navTab" rel="lydd">代定旅游项目</a>
								
							</li><?php }?>
							</ul>
							</li><?php }?>
<!-- 							<li><a>审核管理</a> -->
<!-- 								<ul> -->
<!-- 							<li><a href="daiding/shenhe.php" target="navTab" rel="daidingsh">代定审核</a> -->
								
<!-- 							</li> -->
<!-- 							</ul> -->
<!-- 							</li> -->
							<?php if(checkin("cwgl")){?><li rel="cwgl"><a>财务管理</a>
								<ul>
								<?php if(checkin("athsk")){?>	<li><a href="cwgl/tuanin.php" target="navTab" rel="groupsk">按团号收款</a></li><?php }?>
						<?php if(checkin("adwsk")){?>	<li><a href="cwgl/adwsk.php" target="navTab" rel="dwsk">按单位收款</a></li><?php }?>
						<?php if(checkin("lysk")){?>	<li><a href="cwgl/lysk.php" target="navTab" rel="lysk">旅游收款</a></li><?php }?>
						<?php if(checkin("lyfk")){?>	<li><a href="cwgl/lyfk.php" target="navTab" rel="lyfk">旅游付款</a></li><?php }?>
						<?php if(checkin("ffsh")){?>	<li><a href="cwgl/ffsh.php" target="navTab" rel="ffsh">房费审核</a></li><?php }?>
						<?php if(checkin("adwfk")){?>	<li><a href="cwgl/adwfk.php" target="navTab" rel="dwfk">按单位付款</a></li><?php }?>
						<?php if(checkin("athfk")){?>	<li><a href="cwgl/groupout.php" target="navTab" rel="thfk">按团号付款</a></li><?php }?>
							<?php if(checkin("cwsdhz")){?><li><a href="cwgl/countcw.php" target="navTab" rel="cwsdhz">财务时段汇总</a></li><?php }?>
<!-- 							<li> -->
<!-- 							<a href="cwgl/zmsh.php" target="navTab" rel="zmsh">账目审核</a> -->
<!-- 							</li> -->
<!-- 							<li><a href="cwgl/fpgl.php" target="navTab" rel="fpgl">发票管理</a></li> -->
<!-- 							<li><a href="cwgl/sktx.php" target="navTab" rel="sktx">刷卡套现</a></li> -->
								</ul>
							</li><?php }?>
									
<!-- 							<li><a>对账管理</a> -->
<!-- 								<ul> -->
<!-- 									<li><a href="dzgl/tkdz.php" target="navTab" rel="tkdz">团款对账</a></li> -->
<!-- 									<li><a href="dzgl/ffdz.php" target="navTab" rel="ffdz">房费对账</a></li> -->
									
<!-- 								</ul> -->
<!-- 							</li> -->
							<?php if(checkin("bggl")){?><li><a>办公管理</a>
								<ul>
								<?php if(checkin("bgfylr")){?>	<li><a href="bggl/bgfylr.php" target="navTab" rel="bgfylr">办公费用录入</a></li><?php }?>
<!-- 									<li><a href="bggl/kjqjmx.php" target="navTab" rel="kjqjmx">会计期间明细</a></li> -->
								<?php if(checkin("bgfytj")){?>	<li><a href="bggl/bgfytj.php" target="navTab" rel="bgfytj">办公费用统计</a></li><?php }?>
								<?php if(checkin("kmsz")){?>	<li><a href="bggl/kmsz.php" target="navTab" rel="kmsz">科目设置</a></li><?php }?>
								</ul>
							</li><?php }?>
							<?php if(checkin("xyzx")){?><li><a>协议中心</a>
								<ul>
								<?php if(checkin("jdcb")){?>	<li><a href="xyzx/cbcgxy.php" target="navTab" rel="cbcgxy">酒店成本</a></li><?php }?>
							<?php if(checkin("lxsjg")){?>		<li><a href="xyzx/lxsjg.php" target="navTab" rel="lxsjg">旅行社价格</a></li><?php }?>
							<?php if(checkin("jgsjg")){?>		<li><a href="xyzx/jgsjg.php" target="navTab" rel="jgsjg">旅游供应商结算价</a></li><?php }?>
								</ul>
							</li><?php }?>
							<?php if(checkin("cxtj")){?><li><a>查询统计</a>
								<ul>
								<?php if(checkin("ystkcx")){?>	<li><a href="cxtj/ystkcx.php" target="navTab" rel="ystkcx">应收团款查询</a></li><?php }?>
								<?php if(checkin("ystktj")){?>	<li><a href="cxtj/ystktj.php" target="navTab" rel="ystktj">应收团款统计</a></li><?php }?>
								<?php if(checkin("jdyfcx")){?>	<li><a href="cxtj/jdyfcx.php" target="navTab" rel="jdyfcx">酒店用房查询</a></li><?php }?>
								<?php if(checkin("jdyftj")){?>	<li><a href="cxtj/jdyftj.php" target="navTab" rel="jdyftj">酒店用房统计</a></li><?php }?>
								<?php if(checkin("yslytkcx")){?>	<li><a href="cxtj/yslytkcx.php" target="navTab" rel="yslytkcx">应收旅游团款查询</a></li><?php }?>
								<?php if(checkin("yslytktj")){?>	<li><a href="cxtj/yslytktj.php" target="navTab" rel="yslytktj">应收旅游团款统计</a></li><?php }?>
								<?php if(checkin("lyxccx")){?>	<li><a href="cxtj/lyxccx.php" target="navTab" rel="lyxccx">旅游行程查询</a></li><?php }?>
								<?php if(checkin("lyxctj")){?>	<li><a href="cxtj/lyxctj.php" target="navTab" rel="lyxctj">旅游行程统计</a></li><?php }?>
								<?php if(checkin("skmxcx")){?>	<li><a href="cxtj/skmxcx.php" target="navTab" rel="skmxcx">收款明细查询</a></li><?php }?>
								<?php if(checkin("fkmxcx")){?>	<li><a href="cxtj/fkmxcx.php" target="navTab" rel="fkmxcx">付款明细查询</a></li><?php }?>
									<?php if(checkin("dtlrtj")){?><li><a href="cxtj/dtlrtj.php" target="navTab" rel="dtlrtj">酒店单团利润统计</a></li><?php }?>
									<?php if(checkin("lydtlrtj")){?><li><a href="cxtj/lydtlrtj.php" target="navTab" rel="lydtlrtj">旅游单团利润统计</a></li><?php }?>
								<?php if(checkin("mrsztj")){?>	<li><a href="cxtj/mrsztj.php" target="navTab" rel="mrsztj">每日收支统计</a></li><?php }?>
								</ul>
							</li><?php }?>
<!-- 							<li><a>决策分析</a> -->
<!-- 								<ul> -->
<!-- 									<li><a href="chart/test/barchart.html" target="navTab" rel="chart">计调业绩统计</a></li> -->
<!-- 									<li><a href="chart/test/barchart.html" target="navTab" rel="chart">客户业绩分析</a></li> -->
<!-- 									<li><a href="chart/test/barchart.html" target="navTab" rel="chart">外联业绩统计</a></li> -->
<!-- 								</ul> -->
<!-- 							</li> -->
							<?php if(checkin("jcsjwh")){?><li><a>基础数据维护</a>
								<ul>
							<?php if(checkin("jcsj")){?>		<li><a href="jcsj/jcsj.php" target="navTab" rel="chart">基础数据</a></li><?php }?>
<!-- 									<li><a href="chart/test/barchart.html" target="navTab" rel="chart">区域维护</a></li> -->
									
								</ul>
							</li><?php }?>
							<?php if(checkin("zyzx")){?><li><a>资源中心</a>
								<ul>
								<?php if(checkin("khda")){?>	<li><a href="zyzx/khda.php" target="navTab" rel="khda">客户档案</a></li><?php }?>
									<?php if(checkin("jgsda")){?>	<li><a href="zyzx/jgsda.php" target="navTab" rel="jgsda">旅游供应商档案</a></li><?php }?>
								<?php if(checkin("jdda")){?>	<li><a href="zyzx/jdda.php" target="navTab" rel="jdda">酒店档案</a></li><?php }?>
								<?php if(checkin("zhgl")){?>	<li><a href="zyzx/zhgl.php" target="navTab" rel="zhgl">账户管理</a></li><?php }?>
								<?php if(checkin("jdft")){?>	<li><a href="zyzx/jdft.php" target="navTab" rel="jdft">酒店房态查询</a></li><?php }?>
								<?php if(checkin("jdftgl")){?>	<li><a href="zyzx/jdftgl.php" target="navTab" rel="jdftgl">酒店房态管理</a></li><?php }?>
								</ul>
							</li><?php }?>
							<?php if(checkin("zhzx")){?><li><a>账户中心</a>
								<ul>
								<?php if(checkin("jdzh")){?>	<li><a href="zhzx/jdzh.php" target="navTab" rel="hotelacount">酒店账户</a></li><?php }?>
								<?php if(checkin("lxszh")){?>	<li><a href="zhzx/lxszh.php" target="navTab" rel="travelacount">旅行社账户</a></li><?php }?>
								<?php if(checkin("jgszhc")){?>	<li><a href="zhzx/jgszh.php" target="navTab" rel="jgsacount">旅游供应商账户</a></li><?php }?>
								</ul>
							</li><?php }?>
							<?php if(checkin("xtgl")){?><li><a>系统管理</a>
								<ul>
								<?php if(checkin("xgmm")){?>	<li><a href="xtgl/changepwd.php" target="navTab" rel="changepwd">修改密码</a></li><?php }?>
								<?php if(checkin("gsxx")){?>	<li><a href="xtgl/gsxx.php" target="navTab" rel="gsxx">公司信息</a></li><?php }?>
								<?php if(checkin("bmgl")){?>	<li><a href="xtgl/bmgl.php" target="navTab" rel="deptmanage">部门管理</a></li><?php }?>
								<?php if(checkin("yhgl")){?>	<li><a href="xtgl/yhgl.php" target="navTab" rel="USERNAMEGE">用户管理</a></li><?php }?>
								<?php if(checkin("zwgl")){?>	<li><a href="xtgl/zwgl.php" target="navTab" rel="dutyNAMEGE">职务管理</a></li><?php }?>
								<?php if(checkin("zygl")){?>	<li><a href="xtgl/wdzy.php" target="navTab" rel="zygl">主页管理</a></li><?php }?>
								
								</ul>
							</li><?php }?>
							<?php }?>
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
<?php 
if($_SESSION["usertype"]=="lxs"){
$getsql=mysqli_query($con, "select * from t_zygl ");
$msg=mysqli_fetch_array($getsql);
 echo htmlspecialchars_decode($msg["detext"]);
}
?>
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