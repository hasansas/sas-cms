<?php

/** sas - PHP Pagination Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 sas Project
  *   @package: sas_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */

class pagination{

	function pagination($db,$query,$numRows,$navNumber,$permalink,$thisPage,$lastUri){

		global $config;
		global $system;

		$this->db 		 		= $db;
		$this->query 	 		= $query;
		$this->numRows 	 		= $numRows;
		$this->navNumber 		= $navNumber;
		$this->config 			= $config;
		$this->permalink 		= $permalink;
		$this->thisPage			= $thisPage;
		$this->thisLastUri		= $lastUri;
		$this->requestURI		= $this->config['permalink']=='.html'?str_replace($this->thisLastUri,'',get_string_before(requestURI,'.html')).str_replace('-','/',$this->thisLastUri):requestURI;
		$this->uri 		 		= explode('/',str_replace($config['baseURL'],'',$this->requestURI));
		$this->activePage 		= intval(@$this->uri[$this->activePageKeys()])==0 ? 1:$this->uri[$this->activePageKeys()];
		$this->getRow			= $this->db->execute($this->query);
		$this->ylimit			= $this->numRows;
		$this->xlimit			= empty($this->activePage)?0:intval($this->activePage-1)*$this->ylimit;
		$this->limit			= $this->xlimit.','.$this->ylimit;
		$this->totalRow			= $this->getRow->recordCount();
		$this->totalPage 		= ceil($this->totalRow/$this->ylimit);
		$this->totalPageNumber	= ceil($this->totalPage/$this->navNumber);
		$this->addLinkUrl		= '';

		if($system->thisModuleID()==1){

			if(!$system->uri(2)){
				$homeFld = $system->site->isMultiLang()?'page_url _'.$system->active_lang():'page_url';
				$homeURL = $system->db->getOne("select ".$homeFld." from ".$system->table_prefix."pages where page_id='".$system->thisModuleID()."'");
				$this->addLinkUrl = $homeURL.'/';
			}
		}
	}
	function linkUrl(){

		global $system;

		#$keys = array_keys($this->uri, 'page');
		$pageKeys = $this->pageKeys();
		$uri	  = '';

		for($i=0;$i<$pageKeys;$i++){

			$xuri = $this->uri[$i]!=''?$this->uri[$i].'/':'';
			$uri .= $xuri;
		}
		$getUrl = $this->uri[$pageKeys]=='page'?baseURL:requestURI;
		$getUrl = $getUrl.$uri;

		$isGet		= preg_match('/\?/i',requestURI)?true:false;
		$vGet		= $isGet?get_string_after(requestURI,'?'):'';
		$linkUrl 	= $isGet?str_replace($this->thisLastUri,'',$getUrl):$getUrl;
		$linkUrl 	= $this->config['permalink']=='.html'?str_replace('?'.$vGet,'',$getUrl):$linkUrl;
		$linkUrl 	= $this->config['permalink']=='.html'?(str_replace('.html','/',$linkUrl)):$linkUrl;

		$this->getVar = !empty($vGet)?'?'.$vGet:'';
		return $linkUrl.$this->addLinkUrl;
	}
	function pageKeys(){
		$pageKeys = array_search('page',$this->uri);
		return $pageKeys;
	}
	function activePageKeys(){
		$activePageKeys = $this->pageKeys()+1;
		return $activePageKeys;
	}
	function lastUri(){

		foreach($this->uri  as $k => $v){

			if(!empty($v)){
				$uri[] = $v;
			}
		}

		$navUri  = count(@$uri)-1;
		$pageUri = count(@$uri)-2;
		$lastUri = @$uri[$navUri];

		if(@$uri[$pageUri]=='page'){
			return $lastUri;
		}
		else return null;
	}
	function pageNav(){

		$x = 1;

		for($i=1;$i<=$this->totalPageNumber;$i++){

			$v = '';

			for($n=$x;$n<($x+$this->navNumber);$n++){

				$pageUrl = $this->linkUrl().'page/'.$n.$this->permalink.$this->getVar;
				$pageUrl = $this->config['permalink']=='.html'?$this->linkUrl().'page-'.$n.$this->permalink.$this->getVar:$pageUrl;

				$p = $n!=$this->activePage?'<li><a href="'.$pageUrl.'">'.$n.'</a></li>':'<li class="active"><a href="javascript:void(0)">'.$n.'</a></li>';

				if($n<=$this->totalPage){
					$v .= $p;
				}
			}

			$navNumber[$i] = $v;
			$x = $n;
		}

		$firstUrl 	= $this->linkUrl().'page/1'.$this->permalink.$this->getVar;
		$firstUrl 	= $this->config['permalink']=='.html'?$this->linkUrl().'page-1'.$this->permalink.$this->getVar:$firstUrl;
		$prefUrl 	= $this->linkUrl().'page/'.($this->activePage-1).$this->permalink.$this->getVar;
		$prefUrl 	= $this->config['permalink']=='.html'?$this->linkUrl().'page-'.($this->activePage-1).$this->permalink.$this->getVar:$prefUrl;
		$nextUrl 	= $this->linkUrl().'page/'.($this->activePage+1).$this->permalink.$this->getVar;
		$nextUrl 	= $this->config['permalink']=='.html'?$this->linkUrl().'page-'.($this->activePage+1).$this->permalink.$this->getVar:$nextUrl;
		$lastUrl 	= $this->linkUrl().'page/'.$this->totalPage.$this->permalink.$this->getVar;
		$lastUrl 	= $this->config['permalink']=='.html'?$this->linkUrl().'page-'.$this->totalPage.$this->permalink.$this->getVar:$lastUrl;

		$first	 = $this->activePage>1?'<li><a href="'.$firstUrl.'" class="first">First</a></li>':'<li class="disabled"><span class="first">First</span></li>';
		$prev	 = $this->activePage>1?'<li><a href="'.$prefUrl.'" class="prev">Prev</a></li>':'<li class="disabled"><span class="prev">Prev</span></li>';
		$next	 = $this->activePage<$this->totalPage?'<li><a href="'.$nextUrl.'" class="next">Next</a></li>':'<li class="disabled"><span class="next">Next</span></li>';
		$last	 = $this->activePage<$this->totalPage?'<li><a href="'.$lastUrl.'" class="last">Last</a></li>':'<li class="disabled"><span class="last">Last</span></li>';
		$pageNav = $this->totalPage>1?$first.$prev.$navNumber[ceil($this->activePage/$this->navNumber)].$next.$last:'';
		$pageNav = '<ul class="pagination">'.$pageNav.'</ul>';

		return $pageNav;
	}

	function arrData(){
		$arrData = $this->db->getArray($this->query.' limit '.$this->limit);
		return $arrData;
	}

	function getRows(){
		$this->query.' limit '.$this->limit;
		$getArray = $this->db->getArray($this->query.' limit '.$this->limit);
		$arrData  = array();

		foreach($getArray as $key => $val){
			foreach($val as $k => $v){
				if(!is_numeric($k)){

					$arrData[$k] = $v;
				}
			}
		}
		return $arrData;
	}

	function totalData(){

		$limit 	= explode(',',$this->limit);
		$xt 	= $limit[1]-count($this->arrData());
		$sFirst = (($this->activePage * $limit[1])-$limit[1])+1;
		$sLast 	= (($sFirst+$limit[1])-1)-$xt;

		$rsData	= $this->db->execute($this->query);
		$total	= $rsData->recordCount();

		$totalData = 'Showing <strong>'.$sFirst.' - '.$sLast.'</strong> from (<strong>'.$total.'</strong> total)';

		return $totalData;
	}

	function getQuery(){

		$query = $this->query.' limit '.$this->limit;
		return $query;
	}
}
?>
