<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$about_geetest = plang("about_geetest");
$about_geetest_note = plang("about_geetest_note");
$what_geetest = plang("what_geetest");
$what_geetest_note = plang("what_geetest_note");
$see_more = plang("see_more");

$html = <<<HTML
		<table class="tb tb2 ">
			<tbody>
			<tr>
				<th colspan="15" class="partition">$about_geetest
				</th>
			</tr>
			<tr class="noborder" >
				<td class="vtop tips2" s="1">
					$about_geetest_note
				</td>				
			</tr>
			<tr>
				<th colspan="15" class="partition">$what_geetest
				</th>
			</tr>

			</tbody>
		</table>
HTML;
echo $html;	
$html = <<<HTML
		<table class="tb tb2 ">
			<tbody>		
			<tr class="noborder">
				<td style="width:300px;">
					<img src="http://www.geetest.com/static/img/plugin/pic_8.png"/>
				</td>
				<td class="vtop tips2" s="1">
					$what_geetest_note
				</td>
				
			</tr>
			<tr>
				<td>$see_more:<a style="cursor:pointer;" target="_blank" href="http://www.geetest.com">http://www.geetest.com</a>
				</td>
			</tr>
			</tbody>
		</table>
HTML;
echo $html;

function plang($str) {
	return lang('plugin/geetest', $str);
}

?>