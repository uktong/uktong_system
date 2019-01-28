<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
switch($_GET["searchtype"]){
    case "ystktj":
        $tittle="应收团款统计表";
        
        break;
    case "ystkcx":
        $tittle="应收团款查询表";
        
        break;
    case "jdyfcx":
        $tittle="酒店用房查询表";
        
        break;
    case "skmxcx":
        $tittle="收款明细查询表";
        
        break;
    case "fkmxcx":
        $tittle="付款明细查询表";
        
        break;
    case "dtlrtj":
        $tittle="单团利润统计表";
        
        break;
    case "jdddqr":
        $tittle="酒店订单确认";
        
        break;
    case "lxsddqr":
        $tittle="旅行社订单确认";
        
        break;
}
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>优客通酒店管理系统</title>
     
     <link href="print.css" rel="stylesheet" type="text/css">
     <script type="text/javascript" src="../js/jquery-2.1.4.js"></script>
     <script type="text/javascript" src="tableExport.js"></script>
    <script type="text/javascript">
            function printit(){
                if (confirm('确定打印吗？')){
                    try{
                        print.portrait   =  false    ;//横向打印 
                    }catch(e){
                        //alert("不支持此方法");
                    }
                     var bdhtml=window.document.body.innerHTML;//获取当前页的html代码    
                        var sprnstr="<!--begin-->";//设置打印开始区域    
                        var eprnstr="<!--end-->";//设置打印结束区域    
                        var prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html    
                        var prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html    
                        window.document.body.innerHTML=prnhtml;    
                        window.print();    
                        window.document.body.innerHTML=bdhtml;    
                }

            }
            function toexcel() 
           {
            	 $('#tbQuo').tableExport({

            	        type:'excel',

            	        escape:'false',

            	        fileName: '<?php echo $tittle;?>'

            	        });
           }
            function toword()
            {
            	$('#tbQuo').tableExport({

        	        type:'word',

        	        escape:'false',

        	        fileName: '<?php echo $tittle;?>'

        	        });
            }
        </script>
</head>
<body style="border-bottom: 40px;" id="ArticleBody">
<div id="PrintToolBar" class="fixed noprint">
       <a id="PrintToolBarBtn" href="javascript:" onclick="window.printit();" hidefocus="true" style="margin-left:5%;" class="sealed_outter">
        <span class="sealed">
           <span class="sealed_inner">
            <img id="imgPrint" class="printImg" src="print.png"
             align="absmiddle">账单导出
         </span>
            </span></a>
         <a class="PrintSplitRule" href="javascript:" id="Word"></a>
         <a href="javascript:" hidefocus="true"  style="" class="sealed_outter" onclick="toword()">
            <span class="sealed">
                    <span class="sealed_inner">
                        <img src="word.png" align="absmiddle">导出Word
                    </span>
                </span>
             
           </a>
         
          <div id="UcToolBar_Stamp">
         <a href="javascript:" class="PrintSplitRule"></a>
         <a href="javascript:" hidefocus="true" class="sealed_outter" onclick="toexcel()">
            <span class="sealed">
              <span class="sealed_inner">
                <img src="excel.png" align="absmiddle">导出Excel
                </span>
             </span></a>
          </div>
        
         
        </div>    
           <!--begin-->
       <table class="imgtable">
       <tbody>
        <tr>
            <td align="center" colspan="18">
                <span class="title">
        <?php 

echo $tittle;
?>           
               </span>
            </td>
        </tr>
    </tbody></table>
   

     <table id="tbQuo" class="Prtable" cellpadding="0" cellspacing="0" rules="all">
  <?php require $_GET["searchtype"].'.php';?>
                 </table>
   
  <table id="PrintCommon">

       <tbody><tr id="tbColum">
         <td style="width:100%" colspan="20">打印人：<?php echo $_SESSION["user"];?> &nbsp;&nbsp;&nbsp;打印时间：<?php echo date("Y-m-d"); ?></td>
       </tr>
</tbody></table>
                  <!--end-->  