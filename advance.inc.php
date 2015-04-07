<?php 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
// include_once DISCUZ_ROOT."/source/plugin/geetest/lib/geetestlib.php";
$config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';

$privatekey = md5($config['now']['privatekey']);
$html = <<<HTML
	<iframe src="http://my.geetest.com/api/discuz/login/captchaid={$config['now']['captchaid']}privatekey={$privatekey}/" style="height:820px;width:1200px;border:none;background:white"></iframe>


HTML;
echo $html;







 ?>