<?php
include "../lib/configbg.php";

if (isset($_POST['group']) && isset($_POST['nickname']) && $_POST['nickname'] != '' && isset($_REQUEST['checkprice'])) {

	$promo = 0;
	if (isset($_POST['promocode'])) {
		$promos = mysqli_query($conDB, 'SELECT * FROM `promo` WHERE `promo`="'.$_POST['promocode'].'"');
		while ($p = mysqli_fetch_assoc($promos)) {
			$promo = $p['sale'];
		}
	}

	if (isset($_POST['group'])) {

		$groups = $_POST['group'];
	
		$adds = mysqli_query($conDB, 'SELECT * FROM `donate` WHERE `group`="'.$groups.'"');
		while ($row = mysqli_fetch_assoc($adds)) {
			$type = $row['type'];
			$price = $row['price'];
			$name = $row['name'];

			if ($type == 'perm') {
				$sumAdds = mysqli_query($conDB, 'SELECT * FROM `buy` WHERE `type`="perm" AND `name`="'.$_POST['nickname'].'"');
				while ($rowSum = mysqli_fetch_assoc($sumAdds)) {
					$price = $row['price'];
					$price = $row['price'] - $rowSum['sum'];

					if ($price < 1) { $price = $row['price']; }
				}
			}
		}
		
		if ($promo != 0) {
			$price = $price - (($promo * $price) / 100);
		}

		if ($price > 0) {
			$url = 'https://unitpay.ru/pay/119951-3e75c?sum='.$price.'&account='.$_POST['nickname'].'.'.$groups.'&signature='.getFormSignature(($_POST['nickname'].'.'.$groups), 'Покупка '.$name, $price, '93b94a27ba9742a50a6fb80c0f4d7da0').'&desc=Покупка '.$name;

			echo '<input type="submit" value="Купить за '.$price.' руб." class="btn bnt-new btn-lg btn-block">';
			//echo '<a href="'.$url.'" class="btn btn-sum btn-lg btn-block">Купить за '.$price.' руб.</a>';
			//<input type="submit" value="Купить" class="btn bnt-new btn-lg btn-block">
			//header('Location: https://unitpay.ru/pay/119951-3e75c?sum='.$price.'&account='.$_POST['nickname'].'.'.$groups.'&signature='.getFormSignature(($_POST['nickname'].'.'.$groups), 'Покупка "'.$name.'"', $price, '93b94a27ba9742a50a6fb80c0f4d7da0').'&desc=Покупка "'.$name.'"');
		} else {
			echo '<button type="submit" class="btn bnt-new btn-lg btn-block disabled">Слишком низкая цена</button>';
			//header('Location: /');
		}
	}

} else {
	//echo '<button type="submit" class="btn bnt-new btn-lg btn-block disabled">Заполните данные</button>';
	//echo '<button type="submit" class="btn bnt-new btn-lg btn-block disabled">'.$_POST['checkprice'].'</button>';
	//header('Location: /');

	$promo = 0;
	if (isset($_POST['promocode'])) {
		$promos = mysqli_query($conDB, 'SELECT * FROM `promo` WHERE `promo`="'.$_POST['promocode'].'"');
		while ($p = mysqli_fetch_assoc($promos)) {
			$promo = $p['sale'];
		}
	}

	if (isset($_POST['group'])) {

		$groups = $_POST['group'];
	
		$adds = mysqli_query($conDB, 'SELECT * FROM `donate` WHERE `group`="'.$groups.'"');
		while ($row = mysqli_fetch_assoc($adds)) {
			$type = $row['type'];
			$price = $row['price'];
			$name = $row['name'];

			if ($type == 'perm') {
				$sumAdds = mysqli_query($conDB, 'SELECT * FROM `buy` WHERE `type`="perm" AND `name`="'.$_POST['nickname'].'"');
				while ($rowSum = mysqli_fetch_assoc($sumAdds)) {
					$price = $row['price'];
					$price = $row['price'] - $rowSum['sum'];

					if ($price < 1) { $price = $row['price']; }
				}
			}
		}
		
		if ($promo != 0) {
			$price = $price - (($promo * $price) / 100);
		}

		if ($price > 0) {
			header('Location: https://unitpay.ru/pay/119951-3e75c?sum='.$price.'&account='.$_POST['nickname'].'.'.$groups.'&signature='.getFormSignature(($_POST['nickname'].'.'.$groups), 'Покупка "'.$name.'"', $price, '93b94a27ba9742a50a6fb80c0f4d7da0').'&desc=Покупка "'.$name.'"');
		} else {
			header('Location: /');
		}
	}
}

function getFormSignature($account, $desc, $sum, $secretKey) {
    $hashStr = $account.'{up}'.$desc.'{up}'.$sum.'{up}'.$secretKey;
    return hash('sha256', $hashStr);
}