<?php
/**
 *      2012-2099 Geetest Inc.
 *
 *      $Id: uninstall.php  2014-08-12 Break
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';

if ($config['gt_basic']['cps'] != 1 || $config['gt_basic']['text'] != 0 || !is_null($config['now'])) {
      $config['gt_basic']['cps'] = 0;
      $config['gt_basic']['text'] = 0;
      $config['now'] = array();
      $config = "<?php\n return ".var_export($config, TRUE).";\n?>";
	  file_put_contents(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php', $config);
}

$finish = TRUE;
?>