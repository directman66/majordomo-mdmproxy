<?php
/**
* 
* @package project
* @author Wizard <sergejey@gmail.com>
* @copyright http://majordomo.smartliving.ru/ (c)
* @version 0.1 (wizard, 09:04:00 [Apr 04, 2016])
*/
//
//
class mdmproxy extends module {
/**
*
* Module class constructor
*
* @access private
*/
function mdmproxy() {
  $this->name="mdmproxy";
  $this->title="mdmproxy";
  $this->module_category="<#LANG_SECTION_APPLICATIONS#>";
  $this->checkInstalled();
}
/**
* saveParams
*
* Saving module parameters
*
* @access public
*/
function saveParams($data=0) {
 $p=array();
 if (IsSet($this->id)) {
  $p["id"]=$this->id;
 }
 if (IsSet($this->view_mode)) {
  $p["view_mode"]=$this->view_mode;
 }
 if (IsSet($this->edit_mode)) {
  $p["edit_mode"]=$this->edit_mode;
 }
 if (IsSet($this->tab)) {
  $p["tab"]=$this->tab;
 }
 return parent::saveParams($p);
}



/**
* getParams
*
* Getting module parameters from query string
*
* @access public
*/
function getParams() {
  global $id;
  global $mode;
  global $view_mode;
  global $edit_mode;
  global $tab;
  if (isset($id)) {
   $this->id=$id;
  }
  if (isset($mode)) {
   $this->mode=$mode;
  }
  if (isset($view_mode)) {
   $this->view_mode=$view_mode;
  }
  if (isset($edit_mode)) {
   $this->edit_mode=$edit_mode;
  }
  if (isset($tab)) {
   $this->tab=$tab;
  }
}
/**
* Run
*
* Description
*
* @access public
*/
function run() {
 global $session;
  $out=array();
  if ($this->action=='admin') {
   $this->admin($out);
  } else {
   $this->usual($out);
  }
  if (IsSet($this->owner->action)) {
   $out['PARENT_ACTION']=$this->owner->action;
  }
  if (IsSet($this->owner->name)) {
   $out['PARENT_NAME']=$this->owner->name;
  }
  $out['VIEW_MODE']=$this->view_mode;
  $out['EDIT_MODE']=$this->edit_mode;
  $out['MODE']=$this->mode;
  $out['ACTION']=$this->action;
  $out['TAB']=$this->tab;
  $this->data=$out;
  $p=new parser(DIR_TEMPLATES.$this->name."/".$this->name.".html", $this->data, $this);
  $this->result=$p->result;
}
/**
* BackEnd
*
* Module backend
*
* @access public
*/
function admin(&$out) {
 $this->getConfig();



 

if ($url=='') $out['URL'] = 'http://192.168.1.1';
 if ($this->view_mode=='get_content') {

global $url;
$out['URL'] = $url;

$par = $_GET['par'];


//if ($par=='') $par='/'.$rec['PASSWORD'];

$data=$this->gethttpmessage($url,$par); 


//$data=$this->gethttpmessage($rec['IP'], '/'. $rec['PASSWORD']);
debmes($data, 'mdmrpoxy');
$out['CONTENT']=$data;


}
 
 
 if ($this->view_mode=='update_settings') {
	global $srv_name;
	$this->config['SRV_NAME']=$srv_name;	 

	global $api_server;
	$this->config['API_SERVER']=$api_server;	 

	global $api_port;
	$this->config['API_PORT']=$api_port;	 

	global $api_mac;
	$this->config['API_MAC']=$api_mac;

	global $every;
	$this->config['EVERY']=$every;
   
   $this->saveConfig();
   $this->redirect("?");
 }
 if (isset($this->data_source) && !$_GET['data_source'] && !$_POST['data_source']) {
  $out['SET_DATASOURCE']=1;
 }
 
 //if ($this->tab=='' || $this->tab=='outdata') {
if ($this->tab=='outdata') {
//**   $this->outdata_search($out);
 }  
 //if ($this->tab=='indata') {
if ($this->tab=='' || $this->tab=='indata') {	
//   $this->indata_search($out); 
 }

	
}
/**
* FrontEnd
*
* Module frontend
*
* @access public
*/
function usual(&$out) {
 $this->admin($out);
}
/**
* OutData search
*
* @access public
*/

/**
* InData search
*
* @access public
*/ 

/**
* OutData edit/add
*
* @access public
*/

/**
* OutData delete record
*
* @access public
*/

/**
* InData edit/add
*
* @access public
*/

/**
* InData delete record
*
* @access public
*/

 

 
 

						

		
	
 
   
 
/**
* Install
*
* Module installation routine
*
* @access private
*/
 function install($data='') {
  parent::install();
 }
/**
* Uninstall
*
* Module uninstall routine
*
* @access public
*/
 function uninstall() {
  parent::uninstall();
 }
/**
* dbInstall
*
* Database installation routine
*
* @access private
*/
 function dbInstall($data) {

  

  parent::dbInstall($data);

	 
 }


    function gethttpmessage($ip, $cmd)
    {

        $config = getURL($ip . $cmd, 0);
        $new = $config;

        $new = preg_replace('/<a href=(.+?)>/i', '<a href="?data_source=&view_mode=edit_megaddevices&id=' . $this->id . '&tab=config2&address=' . $ip . '&par=$1">', $new);

        $new = preg_replace('/<form action=(.+?)>/i', '<form action="?" method="post" class="form" enctype="multipart/form-data" name="frmEdit">', $new);

        $new = preg_replace('/<input name=/is', '<input class="form-control" name=', $new);
        $new = preg_replace('/<input size=/is', '<input class="form-control" size=', $new);
        $new = preg_replace('/<select name=/is', '<select class="form-control" name=', $new);
        $new = preg_replace('/>ON</is', ' class="btn btn-default">ON<', $new);
        $new = preg_replace('/>OFF</is', ' class="btn btn-default">OFF<', $new);

        $new = str_replace('Act <input', 'Act <a href="#" onclick="return showMegaDHelp(\'act\');"><i class="glyphicon glyphicon-info-sign"></i></a> <input', $new);
        $new = str_replace('Net <input', 'Net <a href="#" onclick="return showMegaDHelp(\'net\');"><i class="glyphicon glyphicon-info-sign"></i></a> <input', $new);
        $new = str_replace('Raw <input', 'Raw <a href="#" onclick="return showMegaDHelp(\'raw\');"><i class="glyphicon glyphicon-info-sign"></i></a> <input', $new);
        $new = str_replace('Mode <select', 'Mode <a href="#" onclick="return showMegaDHelp(\'mode\');"><i class="glyphicon glyphicon-info-sign"></i></a> <select', $new);
        $new = str_replace('Type <select', '<hr/>Type <a href="#" onclick="return showMegaDHelp(\'type\');"><i class="glyphicon glyphicon-info-sign"></i></a> <select', $new);
        $new = str_replace('Def <select', 'Def <a href="#" onclick="return showMegaDHelp(\'def\');"><i class="glyphicon glyphicon-info-sign"></i></a> <select', $new);

        $new = preg_replace('/checkbox name=af.+?>/is','\0 Af <a href="#" onclick="return showMegaDHelp(\'af\');"><i class="glyphicon glyphicon-info-sign"></i></a><br/>',$new);
        $new = preg_replace('/checkbox name=naf.+?>/is','\0 Naf <a href="#" onclick="return showMegaDHelp(\'naf\');"><i class="glyphicon glyphicon-info-sign"></i></a><br/>',$new);
        $new = preg_replace('/checkbox name=misc.+?>/is','\0 Misc <a href="#" onclick="return showMegaDHelp(\'misc\');"><i class="glyphicon glyphicon-info-sign"></i></a><br/>',$new);

        $new = str_replace('<input type=submit value=Save>', '<input type=submit class="btn btn-default btn-primary" value=Save><input type="hidden" name="sourceurl" value="' . $cmd . '"><input type="hidden" name="sourceip" value="' . $ip . '">', $new);

        return $config;


    }

// --------------------------------------------------------------------

//////

}
/*
*
* TW9kdWxlIGNyZWF0ZWQgQXByIDA0LCAyMDE2IHVzaW5nIFNlcmdlIEouIHdpemFyZCAoQWN0aXZlVW5pdCBJbmMgd3d3LmFjdGl2ZXVuaXQuY29tKQ==
*
*/
