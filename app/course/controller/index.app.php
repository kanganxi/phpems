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

    private function lists()
    {
        $catids = array();
        $catids = $this->category->getCategoriesByArgs(array(array("AND","catinmenu = '0'"),array("AND","catapp = 'course'"),array("AND","catparent = 0")));
        $contents = array();
        if($catids)
        {
            foreach($catids as $p)
            {
                $catstring = $this->category->getChildCategoryString($p['catid']);
                $contents[$p['catid']] = $this->course->getCourseList(array(array("AND","find_in_set(cscatid,:catstring)",'catstring',$catstring)),1,$p['catindex']?$p['catindex']:6);
            }
        }
        $this->tpl->assign('catids',$catids);
        $this->tpl->assign('categories',$this->category->categories);
        $this->tpl->assign('contents',$contents);
        $this->tpl->display('index_lists');
    }

	private function index()
	{
		$page = $this->ev->get('page');
		$contents = $this->course->getOpenCourseListByUserid($this->_user['sessionuserid'],$page);
		$news = $this->course->getCourseList(array(),1,5);
		$this->tpl->assign('news',$news['data']);
		$this->tpl->assign('contents',$contents);
        $this->tpl->assign('page',$page);
		$this->tpl->display('index');
	}
}


?>
