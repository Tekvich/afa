<?php 
	$nameDB = "u-world";
	$nameSERVER = "legendaryworld.fun";
	$nameUSER = "root";
	$passUSER = "";

	$conDB = mysqli_connect($nameSERVER, $nameUSER, $passUSER, $nameDB) 
	or die("ERROR".mysqli_error($nameDB));

	mysqli_query($conDB, "SET NAMES utf8");
?>