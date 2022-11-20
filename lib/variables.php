<?php
	include "configbg.php";
	$result = mysqli_query($conDB,"SELECT * FROM pages where name = 'menu'"); 
	$row = mysqli_fetch_assoc($result);


	// данные странниц -------------- 
	 $content_menu = $row['content'];
	 $module_name = $row['name'];
?>