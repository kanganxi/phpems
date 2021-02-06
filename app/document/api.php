<?php

class app
{
	public $G;
	private $sc = 'testSys&dongao';

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->apps = $this->G->make('apps','core');
		$_user = $this->_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if(!$_user['sessionuserid'])
		{
            $message = array(
                'statusCode' => 300,
                "message" => "请您重新登录",
                "callbackType" => 'forward',
                "forwardUrl" => "index.php?user-app-login"
            );
            $this->G->R($message);
		}
		$this->attach = $this->G->make('attach','document');
		$this->allowexts = $this->attach->getAllowAttachExts();
        $this->forbidden = array('rpm','exe','hta','php','phpx','asp','aspx','jsp');
		//$this->allowexts = array('zip','jpg','rar','png','gif','mp3','mp4','ogg','webm');
	}
}

?>