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
        if($this->_user['sessionuserid'])
		{
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php"
            );
            $this->G->R($message);
		}
		$this->login = $this->G->make('login','weixin');
		$action = $this->ev->url(3);
		if(!method_exists($this,$action))
		$action = "index";
		$this->$action();
		exit;
	}

	private function autologin()
	{
        $sessionid = $this->session->getSessionid();
        $info = $this->login->getLogin($sessionid);
		$user = $info['wxinfo'];
		if($user['userid'])
		{
            $this->session->setSessionUser(array('sessionuserid'=>$user['userid'],'sessionpassword'=>$user['userpassword'],'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$user['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$user['username']));
            $this->login->delLogin($sessionid);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php"
            );
            exit(json_encode($message));
		}
        $message = array(
            'statusCode' => 200
        );
        exit(json_encode($message));
	}

	private function login()
	{
		$sessionid = $this->session->getSessionid();
		$url = urlencode(WP.'index.php?weixin-phone-index-pclogin&sessionid='.$sessionid);
        $this->tpl->assign('url',$url);
        $this->tpl->display('login');
	}

	private function index()
	{
        //
	}
}


?>
