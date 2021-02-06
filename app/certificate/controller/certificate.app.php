<?php
/*
 * Created on 2016-5-19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class action extends app
{
	public function display()
	{
		$action = $this->ev->url(3);
		if(!method_exists($this,$action))
		$action = "index";
		$this->$action();
		exit;
	}

	private function apply()
	{
		$ceid = $this->ev->get('ceid');
		$ce = $this->ce->getCeById($ceid);
		if($this->ev->get('apply'))
		{
			$user = $this->user->getUserById($this->_user['sessionuserid']);
			if($user['usercoin'] < $ce['ceprice'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "余额不足，请到个人中心充值"
				);
				exit(json_encode($message));
			}
			$eh = $this->G->make('favor','exam')->getExamHistoryByArgs(array(array("AND","ehuserid = :ehuserid","ehuserid",$this->_user['sessionuserid']),array("AND","ehispass = 1"),array("AND","ehtype = 2"),array("AND","ehbasicid = :ehbasicid","ehbasicid",$ce['cebasic'])));
			if(!$eh['ehid'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "您需要通过考试后才能申请"
				);
				exit(json_encode($message));
			}
			$info = $this->ev->get('info');
            if(!$info['useraddress'] || !$info['userphone'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请填写地址和联系电话"
                );
                exit(json_encode($message));
            }
			$args = array();
			$args['cequserid'] = $this->_user['sessionuserid'];
			$args['ceqtime'] = TIME;
			$args['ceqstatus'] = 0;
			$args['ceqceid'] = $ceid;
			$args['ceqinfo'] = array('username' => $user['username'],'photo' => $user['userphoto'],'usertruename' => $user['usertruename'],'usersex' => $user['usergender'],'userphone' => $info['userphone'],'useraddress' => $info['useraddress']);
			$this->ce->addCeQueue($args);
			$coin = $user['usercoin'] - $ce['ceprice'];
			$this->user->modifyUserInfo($this->_user['sessionuserid'],array('usercoin' => $coin));
			$this->G->make('consume','bank')->addConsumeLog(array('conluserid' => $this->_user['sessionuserid'],'conlcost' => $ce['ceprice'],'conltype' => 1,'conltime' => TIME,'conlinfo' => '申请证书'.$ce['cetitle']));
			$user = $this->user->getUserById($this->_user['sessionuserid']);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?certificate"
			);
			exit(json_encode($message));
		}
		else
		{
			$basic = $this->G->make('basic','exam')->getBasicById($ce['cebasic']);
            $this->tpl->assign('basic',$basic);
			$this->tpl->assign('ce',$ce);
			$this->tpl->display('certificate_apply');
		}
	}

	private function index()
	{
		$page = intval($this->ev->get('page'));
		$certificates = $this->ce->getCeList(array(),$page,10);
		$args = array();
		$args[] = array("AND","cequserid = :cequserid","cequserid",$this->_user['sessionuserid']);
		$new = $this->ce->getCeQueueList($args,1,10);
		$this->tpl->assign('news',$new['data']);
		$this->tpl->assign('certificates',$certificates);
		$this->tpl->assign('page',$page);
		$this->tpl->display('certificate');
	}
}


?>
