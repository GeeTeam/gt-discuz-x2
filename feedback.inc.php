<?php

  // error_reporting(E_ALL);

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT."/source/plugin/geetest/lib/geetestlib.php";
$config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';

	$geetestlib = new geetestlib();
if(submitcheck("feedback_submit")){
	$config_url = "plugins&operation=$operation&do=$pluginid&identifier=geetest&pmod=feedback";
	$url = "http://my.geetest.com/page_plugin/save_feedback/";
	global $_G;
    global $pluginid;
	$from_url = $_G["siteurl"]; 
	$feedback_content = trim($_GET['feedback_content']);
	if('gbk' == CHARSET){//ת��utf8
		$feedback_content = iconv("GBK", "UTF-8", $feedback_content);
	}else if('big5' == CHARSET){
		$feedback_content = iconv("BIG5", "UTF-8", $feedback_content);
	}
	$post_data = array(
			'feedback_content' => $feedback_content,
			'from_url' => $from_url
			);

	$response = $geetestlib->send_post($url,$post_data);
	//print_r($response);
	cpmsg(plang('feeback_success'), 'action=plugins&operation=operation&do='.$pluginid.'&identifier=geetest&pmod=feedback', 'succeed');	
}

//���԰�
$assist = plang('assist');
$website = plang('website');
$tutorial_label = plang('tutorial_label');
$contact = plang('contact');
$QQqun = plang('QQqun');
$about_link_commerce = plang('about_link_commerce');
$about_link_bug = plang('about_link_bug');
$about_link_product = plang('about_link_product');
$about_link_tech = plang('about_link_tech');

$warn = <<<HTML

	<table class="tb tb2 ">
		<tbody>
		<tr><th colspan="15" class="partition">$assist</th></tr>
			<tr>
				<td>$tutorial_label <a>http://www.geetest.com/help/discuz</a>
				</td>	
			</tr>
			<tr>
				<td>$website :<a>http://www.geetest.com</a>
				</td>
				
				
			</tr>
			<tr>
				<td>$contact :contact@geetest.com
				</td>
			</tr>
			<tr>
				<td>$QQqun :162669835
				</td>
			</tr>

		</br>
	
		<tr class="noborder"><td class="vtop tips2" s="1"><a target="_self" href="http://wpa.qq.com/msgrd?v=3&amp;uin=632618615&amp;site=qq&amp;menu=yes">$about_link_tech<img src="http://wpa.qq.com/pa?p=2:632618615:44"></a></td></tr>
		<tr class="noborder"><td class="vtop tips2" s="1"><a target="_self" href="http://wpa.qq.com/msgrd?v=3&amp;uin=315815060&amp;site=qq&amp;menu=yes">$about_link_product<img src="http://wpa.qq.com/pa?p=2:315815060:44"></a></td></tr>
		<tr class="noborder"><td class="vtop tips2" s="1"><a target="_self" href="http://wpa.qq.com/msgrd?v=3&amp;uin=877077145&amp;site=qq&amp;menu=yes">$about_link_bug<img src="http://wpa.qq.com/pa?p=2:877077145:44"></a></td></tr>
		<tr class="noborder"><td class="vtop tips2" s="1"><a target="_self" href="http://wpa.qq.com/msgrd?v=3&amp;uin=41570993&amp;site=qq&amp;menu=yes">$about_link_commerce<img src="http://wpa.qq.com/pa?p=2:41570993:44"></a></td></tr>
		
		</tbody>
	</table>

HTML;

echo($warn);




showformheader("plugins&operation=$operation&do=$pluginid&identifier=geetest&pmod=feedback", "",'actform','post');
showtableheader(plang('feeback_title_label'));
showsetting(plang('feeback_label'), 'feedback_content', plang('feeback_content'), 'textarea','','',plang('feeback_note'));

showtablefooter();
showsubmit('feedback_submit', 'submit');
showformfooter();

$recommend = plang('recommend');
$recommend_label = plang('recommend_label');
$recommend_note = plang('recommend_note');
$invite = plang('invite');

$data = array(
	'captchaid' => $config['now']['captchaid'],
	'privatekey' => $config['now']['privatekey'],
	);
$result_post = $geetestlib->send_post("http://my.geetest.com/api/discuz/inv",$data);
$result_post = json_decode($result_post,true);
if ($result_post['message'] == "discuz") {
	$num = '0';
	$user = 'discuz';
}elseif($result_post['message'] == "success"){
	$num = $result_post['num'];
	$user = $result_post['email'];
}



$html = <<<HTML
	<table class="tb tb2 ">
		<tbody>
		<tr><th colspan="15" class="partition">$recommend</th></tr>
			<tr>
				<td>$recommend_label
				</td>	
			</tr>
			<tr>
				<td>$recommend_note 
				</td>
	
			</tr>
			<tr>
				<td><input type="text" name="feedback" size="95" value="http://my.geetest.com/accounts/register/?inviter_email={$user}"  onclick="select();"/></td>
			</tr>
			<tr>
				<td>$invite ($num)
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