<?php
/**
 *      2012-2099 Geetest Inc.
 *
 *      $Id: install.php  2014-08-12 Break
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';

if (!is_writable(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php')) {
	$test = plang("test");
	echo '<script>alert("geetest/lib/'.$test.'")</script>'; 
}
else{
	if (!isset($config['now']) || empty($config['now']) || is_null($config['now'])) {
		  $result = dfsockopen('http://my.geetest.com/api/discuz/add');
		  $result = json_decode($result,true);
		  $config['now'] = $result;
		  $config = "<?php\n return  ".var_export($config, TRUE).";\n?>";
		  file_put_contents(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php', $config);
	}
}

function plang($str) {
	return lang('plugin/geetest', $str);
}

$finish = TRUE;
?>