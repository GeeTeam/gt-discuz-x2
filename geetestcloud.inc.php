<?php 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT."/source/plugin/geetest/lib/geetestlib.php";
$geetestlib = new geetestlib();

$config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';
if (empty($config['now']['captchaid']) || empty($config['now']['captchaid'])) {
	$config['now'] = $config['keyset'];
}
$web_id_key = plang("web_id_key");
$mobile_id_key = plang("mobile_id_key");
$web_captcha = plang("web_captcha");
$web_private = plang("web_private");
$mobile_captcha = plang("mobile_captcha");
$mobile_private = plang("mobile_private");

$relevance_geetest_account = plang("relevance_geetest_account");
$id_note = plang("id_note");
$key_note =plang("key_note");
$web_button_note = plang("web_button_note");
$mobile_button_note = plang("mobile_button_note");
$modify_id_key = plang("modify_id_key");
$click_modify = plang("click_modify");
$html = <<<HTML
<script src="http://code.jquery.com/jquery-1.6.min.js" type="text/javascript"></script>
<script src="./source/plugin/geetest/js/web_keyset.js" type="text/javascript"></script>

    <form action="" method="post">
    <table class="tb tb2 ">
        <tbody>
        <tr>
            <th colspan="15" class="partition">$web_id_key
            </th>
        </tr>
        <tr>
            <td class="td27" s="1">$web_captcha</td>
        </tr>
        <tr class="noborder">
            <td class="vtop rowform">     

                <input name="id" value="{$config['now']['captchaid']}" type="text" class="txt" id="web_captcha" style="border:none;">

            </td>
            <td class="vtop tips2" s="1" ><span id="msg_web_id"></span><span id="label_web_id">$id_note</span>
            </td>
        </tr>
        <tr>
            <td class="td27" s="1">$web_private<span></span></td>
        </tr>
        <tr class="noborder">
            <td class="vtop rowform">
                <input name="key" value="{$config['now']['privatekey']}" type="text" class="txt" id="web_private" style="border:none;">
            </td>
            <td class="vtop tips2" s="1"><span id="msg_web_key"></span><span id="label_web_key">$key_note</span>
            </td>
        </tr>
        <tr class="noborder">
            <td class="vtop rowform">
            <div id="web_btn" style="width: 113px;">
                    <div class="web_set1" style="">$modify_id_key</div>
                    <div class="web_set2" style="display:none;">$click_modify</div>
            </div>

            </td>
                <td class="vtop tips2" s="1">$web_button_note
            </td>
        </tr>
        </tbody>
    </table>
    </form>

    <style type="text/css">
    .web_set1,.web_set2,.mobile_set1,.mobile_set2,.rele{
  background-color: #00b7f1;
  color: #fff !important;
  padding: 0 20px;
  height: 22px;
  line-height: 22px;
  position: relative;
  cursor:pointer;
    }
    </style>
HTML;
echo $html;




$web_keyset = $_POST['web_keyset'];

        $gt_cache = check($web_keyset);
        $result_ajax = $geetestlib->send_post("http://my.geetest.com/api/discuz/get",$gt_cache);
        $result_ajax = json_decode($result_ajax,true);
        if ($result_ajax["message"] == "not_reg" || $result_ajax["message"]=="success") {
            $config = @include DISCUZ_ROOT.'source/plugin/geetest/lib/config.php';
            $config['now']=$gt_cache;
            file_put_contents(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php', "<?php return ".var_export($config,true).";?>");
        }

function check($data){
    if ($data != "" || $data != null ) {
        $keyset = explode("/", $data);
        $keyset['0'] = trim($keyset['0']);
        $keyset['1'] = trim($keyset['1']);
        $geetest_key = array(
                'captchaid'=>$keyset['0'],
                'privatekey'=>$keyset['1'],
            );
        return $geetest_key;
    }
}


$geetest_account = plang("geetest_account");
$id_and_key_error = plang("id_and_key_error");
$not_relevance = plang("not_relevance");
$relevance = plang("relevance");
$commission_withdrawal = plang("commission_withdrawal");
$acquisition = plang("acquisition");
$acquisition_note = plang("acquisition_note");
$yes = plang('yes');
$no = plang('no');

    $result = $geetestlib->send_post("http://my.geetest.com/api/discuz/get",$config['now']);

    $result = json_decode($result,true);
    if ($result['message'] == "error") {
        $html = <<<HTML
        <table class="tb tb2 ">
            <tbody>
            <tr>
                <th colspan="15" class="partition">$geetest_account
                </th>
            </tr>
            <tr>
                <td class="td27" s="1" style="color:red;">$id_and_key_error</td>
            </tr>
            
            </tbody>
        </table>
HTML;
    echo $html;
    }elseif ($result['message'] == "not_reg" ) {
        $privatekey = md5($config['now']['privatekey']);
        $html = <<<HTML
        <table class="tb tb2 ">
            <tbody>
            <tr>
                <th colspan="15" class="partition">$geetest_account
                </th>
            </tr>
            <tr>
                <td class="td27" s="1">$not_relevance</td>
            </tr>
            <tr>
                <td>
                    <div class = "rele" style="width:65px;"><a style="  color: white;text-decoration: none;" target="view_window" href="http://my.geetest.com/discuzreg/{$config['now']['captchaid']}/{$privatekey}">
                	$relevance_geetest_account
                </a>
                    </div>
                </td>

            </tr>
            </tbody>
        </table>
HTML;
    echo $html;
        
    }elseif ($result['message'] == "success") {
        $money = $result['gmoney'];
        $email = $result['email'];
            $html = <<<HTML
    <table class="tb tb2 ">
        <tbody>
        <tr>
            <th colspan="15" class="partition">$geetest_account
            </th>
        </tr>
        <tr>
            <td class="td27" s="1">$relevance:{$email}</td>
        </tr>
        </tbody>
    </table>

    <table class="tb tb2 ">
        <tbody>
        <tr>
            <th colspan="15" class="partition">
            </th>
        </tr>
      
        
        </tbody>
    </table>
HTML;
    echo $html;
    
    }   



function plang($str) {
    return lang('plugin/geetest', $str);
}


 ?>