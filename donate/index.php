<?php

error_reporting(E_ALL);

include 'config.php';
include 'lib/UnitPayModel.php';
include 'lib/UnitPay.php';

class UnitPayEvent {
    public function check($params) {
        try {
            $unitPayModel = UnitPayModel::getInstance();

            if ($unitPayModel->getAccountByName($params['account'])) {
                return true;
            }
            return true;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function pay($params) {
         $unitPayModel = UnitPayModel::getInstance();
         $countItems = floor($params['sum'] / Config::ITEM_PRICE);
		 
		 $array = explode(".",$params['account']);
		 $account = $array[0];
		 $perm = $array[1];
		
         $unitPayModel->donateForAccountLive($account,$perm,$countItems);
    }
}

$payment = new UnitPay(
    new UnitPayEvent()
);

echo $payment->getResult();
