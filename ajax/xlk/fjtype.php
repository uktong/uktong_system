<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
			require_once $_SESSION["ROOT"].'/db/db.php';
			$id=$_GET["id"];
			$resultnow=mysqli_query($con,"select id,basetype as fjtype".$id." from t_baseconfig where basenote='2' " );
			$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			echo json_encode($resultnowarray);
			    ?>
			   
			