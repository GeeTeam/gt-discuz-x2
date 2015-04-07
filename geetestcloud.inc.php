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




$relevance_cloud = plang("relevance_cloud");
$geetest_id = plang("geetest_id");
$geetest_key = plang("geetest_key");
$id_note = plang("id_note");
$key_note =plang("key_note");
$button_note = plang("button_note");
$id_long_error = plang("id_long_error");
$key_long_error = plang("key_long_error");
$html = <<<HTML
<script src="http://code.jquery.com/jquery-1.6.min.js" type="text/javascript"></script>
<script type="text/javascript">
	
		$(function() {
			var state = true;
			$("#button").click(function(){
				if (state == true) {
					$("#id").val("");
					$("#key").val("");
					$("#img1").attr("style","display:none");
					$("#img2").attr("style","display:inline;cursor:pointer;");
					$(".txt").attr("style","border:#999 solid 1px;");
					state = false;
				}else{
					$.ajax({
				        type:'POST',
				        url:'admin.php?action=plugins&operation=config&do=$do&identifier=geetest&pmod=geetestcloud',
				        data: 'data='+$("#id").val()+'/'+$("#key").val(),

				        success:function(){
							
						}
						
				    });
					$.ajax({
				        type:'GET',
				        async:false,
				        url:'http://my.geetest.com/api/discuz/value',
				        dataType:'jsonp',
				        data:{"captchaid":$("#id").val(),"privatekey":$("#key").val()},
				        jsonp:"callback",
				       
				        success:function(callback){
							if (callback.success == "fail") {
								alert(callback.success);
								state = false;
								$("#img2").attr("style","display:inline");
								$("#img1").attr("style","display:none");
								window.location.reload();
								
							};
							if (callback.success == "success") {
								alert(callback.success);
								state = true;
								$("#img1").attr("style","display:inline");
								$("#img2").attr("style","display:none");
								window.location.reload();
							};
						}
						
				    });
					
				};
			});			
		});
		
	</script>
	<script type="text/javascript">
		$(function(){
			$("input").blur(function(){
				if ($.trim($("#id").val()).length != 32 ) {
					$("#msg_id").html("<span style='color:red;'>$id_long_error</span>");
					$("#label_id").hide();
				}else{
					$("#label_id").show();
					$("#msg_id").html("");
				};
				if ($.trim($("#key").val()).length != 32) {
					$("#msg_key").html("<span style='color:red;'>$key_long_error</span>");
					$("#label_key").hide();
				}else{
					$("#label_key").show();
					$("#msg_key").html("");
				};
			});
		});
	</script>
	
	<form action="" method="post">
	<table class="tb tb2 ">
		<tbody>
		<tr>
			<th colspan="15" class="partition">$relevance_cloud
			</th>
		</tr>
		<tr>
			<td class="td27" s="1">$geetest_id</td>
		</tr>
		<tr class="noborder">
			<td class="vtop rowform">

				<input name="id" value="{$config['now']['captchaid']}" type="text" class="txt" id="id" style="border:none;">

			</td>
			<td class="vtop tips2" s="1" ><span id="msg_id"></span><span id="label_id">$id_note</span>
			</td>
		</tr>
		<tr>
			<td class="td27" s="1">$geetest_key<span></span></td>
		</tr>
		<tr class="noborder">
			<td class="vtop rowform">
				<input name="key" value="{$config['now']['privatekey']}" type="text" class="txt" id="key" style="border:none;">
			</td>
			<td class="vtop tips2" s="1"><span id="msg_key"></span><span id="label_key">$key_note</span>
			</td>
		</tr>
		<tr class="noborder">
			<td class="vtop rowform">
				<div id="button" style="width:130px;height:22px;">
					<div id="img1" style="cursor:pointer;"><img src="http://www.geetest.com/static/img/plugin/pic_3.png"/></div>
					<div id="img2" style="display:none;"><img src="http://www.geetest.com/static/img/plugin/pic_7.png"/></div>

				</div>
			</td>
				<td class="vtop tips2" s="1">$button_note
			</td>
		</tr>
		</tbody>
	</table>
	</form>

HTML;
echo $html;

$data = $_POST['data'];
if ($data != "" || $data != null) {
	$keyset = explode("/", $data);
	$keyset['0'] = trim($keyset['0']);
	$keyset['1'] = trim($keyset['1']);
	$geetest_key = array(
			'captchaid'=>$keyset['0'],
			'privatekey'=>$keyset['1'],
		);

	$result_ajax = $geetestlib->send_post("http://my.geetest.com/api/discuz/get",$geetest_key);

	$result_ajax = json_decode($result_ajax,true);
	// print_r($result_ajax);
	if ($result_ajax["message"] == "not_reg" || $result_ajax["message"]=="success") {
		if (is_writable(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php'))
		{
			$config['now'] = $geetest_key;
			$config = "<?php\n return ".var_export($config, TRUE).";\n?>";
		  file_put_contents(DISCUZ_ROOT.'source/plugin/geetest/lib/config.php', $config);
		}
	}
	
}


$geetest_account = plang("geetest_account");
$id_and_key_error = plang("id_and_key_error");
$not_relevance = plang("not_relevance");
$relevance = plang("relevance");
$commission_withdrawal = plang("commission_withdrawal");
$acquisition = plang("acquisition");
$acquisition_note = plang("acquisition_note");

	$result = $geetestlib->send_post("http://my.geetest.com/api/discuz/get",$config['now']);
	// print_r($_G['cache']['gt_cache']);

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
					<div style="cursor:pointer;"><a target="view_window" href="http://my.geetest.com/discuzreg/{$config['now']['captchaid']}/{$privatekey}"><img src="http://www.geetest.com/static/img/plugin/pic_1.png"/></a>
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
			<th colspan="15" class="partition">$commission_withdrawal
			</th>
		</tr>
		<tr>
			<td class="td27" s="1">$acquisition :{$money}</td>
		</tr>
		<tr class="noborder">
			<td class="vtop rowform">
				<div style="cursor:pointer;"><img src="http://www.geetest.com/static/img/plugin/pic_2.png"/>
				</div>
			</td>
			<td class="vtop tips2" s="1">$acquisition_note</td>
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