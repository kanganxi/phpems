<?php

class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->tpl = $this->G->make('tpl');
		$this->session = $this->G->make('session');
		$this->category = $this->G->make('category');
		$this->user = $this->G->make('user','user');
		$this->_user = $this->session->getSessionUser();
		$user = $this->user->getUserById($this->_user['sessionuserid']);
		$this->tpl->assign('_user',$user);
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
	}
}

?>