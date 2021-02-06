<?php
/*
 * Created on 2013-12-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

define('PEPATH',dirname(dirname(__FILE__)));
class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
        $this->user = $this->G->make('user','user');
		$this->order = $this->G->make('orders','bank');
	}

	public function run()
	{
		$orderobj = $this->G->make('orders','bank');
		$alipay = $this->G->make('alipay');
		$orderid = $this->ev->get('out_trade_no');
		$order = $orderobj->getOrderById($orderid);
		$verify_result = $alipay->alireturn();
		if($verify_result)
		{
			if($order['orderstatus'] == 2)
			{
				//
			}
			else
			{
				if($this->ev->get('trade_status') == 'TRADE_FINISHED' ||$this->ev->get('trade_status') == 'TRADE_SUCCESS')
				{
					$orderobj->modifyOrderById($orderid,array('orderstatus' => 2));
					$user = $this->user->getUserById($order['orderuserid']);
					$args['usercoin'] = $user['usercoin']+$order['orderprice']*10;
					$this->user->modifyUserInfo($order['orderuserid'],$args);
				}
				else
				{
					//
				}
			}
		}
		else
		{
			//
		}
		if($this->ev->isMobile())
        header("location:../index.php?user-phone-payfor-orderdetail&ordersn=".$orderid);
        else
		header("location:../index.php?user-center-payfor-orderdetail&ordersn=".$orderid);
		exit();
	}
}
include PEPATH.'/lib/init.cls.php';
$app = new app(new ginkgo);
$app->run();

?>