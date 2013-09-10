<?php
//by zhushuai
//方便调试，主要可以指定URL，GET/POST方式，指定GET/POST的内容，指定cookie
//处理del  div时全部删除的bug ?
//使用本地存储，记录历史数据 ?
//支持 a=b&c=d&e=f 风格的输入？
if(count($_POST)){
	$url = $_POST['url'];
//validate url
	if(!filter_var($url, FILTER_VALIDATE_URL))
	 {
	 echo "URL is not valid";
	 exit;
	 }
//array remix
	$r_head = array();
	foreach($_POST['headerk'] as $k => $v){
		if(empty($v)){
			//key could not be empty
			unset($_POST['headerk'][$k]);
			unset($_POST['headerv'][$k]);
		}
		else{
			$r_head[$v] = trim($_POST['headerv'][$k]);
		}
	}
		
	$r_get = array();
	foreach($_POST['geterk'] as $k => $v){
		if(empty($v)){
			//key could not be empty
			unset($_POST['geterk'][$k]);
			unset($_POST['geterv'][$k]);
		}
		else{
			$r_get[$v] = trim($_POST['geterv'][$k]);
		}
	}


	$r_post = array();
	foreach($_POST['posterk'] as $k => $v){
		if(empty($v)){
			//key could not be empty
			unset($_POST['posterk'][$k]);
			unset($_POST['posterv'][$k]);
		}
		else{
			$r_post[$v] = trim($_POST['posterv'][$k]);
		}
	}


	$r_cook = array();
	foreach($_POST['cookerk'] as $k => $v){
		if(empty($v)){
			//key could not be empty
			unset($_POST['cookerk'][$k]);
			unset($_POST['cookerv'][$k]);
		}
		else{
			$r_cook[$v] = trim($_POST['cookerv'][$k]);
		}
	}
//process date
	$url = $url.'?'.http_build_query($r_get);
 
	$cookstr = '';
	foreach($r_cook as $k => $v){
		$cookstr .= $k.'='.$v.';';
	}
	$header = array();
	foreach($r_head as $k => $v){
		$header[] = $k.': '.$v;
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt ($ch, CURLOPT_COOKIE , $cookstr );
	//为了支持cookie
	//curl_setopt($ch, CURLOPT_COOKIEJAR, ‘cookie.txt’);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $r_post);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);
	if($result ===FALSE){
		echo "Error Result !(Tips from postman)";
	}
	elseif(strlen($result)==0){
		echo "Empty Result !(Tips from postman)";
	}
	else{
		echo $result;
	}
	

}
else{
	$html = 'postman.html';
	$tpl = file_get_contents($html);
	echo $tpl;


}



