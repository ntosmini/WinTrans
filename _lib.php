<?php
// redirect 처리 필요.
function curl_get_follow_url(/*resource*/ $ch, /*int*/ &$maxredirect = null) {
    $mr = $maxredirect === null ? 5 : intval($maxredirect);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    if ($mr > 0) {
        $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        $rch = curl_copy_handle($ch);
        curl_setopt($rch, CURLOPT_HEADER, true);
        curl_setopt($rch, CURLOPT_NOBODY, true);
        curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
        curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($rch, CURLOPT_CONNECTTIMEOUT, 2); 
        curl_setopt($rch, CURLOPT_TIMEOUT, 3); 
        do {
            curl_setopt($rch, CURLOPT_URL, $newurl);
            $header = curl_exec($rch);
            if (curl_errno($rch)) {
                $code = 0;
            } else {
                $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                if ($code == 301 || $code == 302) {
                    preg_match('/Location:(.*?)\n/', $header, $matches);
                    $newurl = trim(array_pop($matches));
                } else {
                    $code = 0;
                }
            }
        } while ($code && --$mr);
        curl_close($rch);
        if (!$mr) {
            if ($maxredirect === null) {
                trigger_error('Too many redirects. When following redirects, libcurl hit the maximum amount.', E_USER_WARNING);
            } else {
                $maxredirect = 0;
            }
            return false;
        }
    }
    return $newurl;
}

function CF_getDataURL($url, $add_opt = ''){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_HEADER, false);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml;charset=UTF-8"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); //
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); //
    $ret=curl_exec($ch);
    curl_close($ch);
    return $ret;
}// end func



function SendSlackNtosAlarm($Subject='', $SendMsg='', $link='', $member=''){

	include_once(dirname(__FILE__).'/_Class/slack.class.php');

		$msg = array();

		$msg[] = $_SERVER['HTTP_HOST']."\n";
		if($SendMsg){
			$msg[] = $SendMsg;
		}	//end if
		if($link){
			$msg[] = '<'.urlencode($link).'|바로가기>';
		}	//end if

		if($member){
			$msg[] = '<@'.$member.'>';  //담당자
		} else {
			$msg[] = '<@U09SPGBDX>';  //담당자
		}

		$_text = implode("\n", $msg);


			$slack = new SLACK();

			$slack->setWebHookUrl('https://hooks.slack.com/services/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');
			$slack->setChannel('##ntos-alarm');

			$slack->setUserName('NtosWin');
			//$slack->setIconEmoji(':loudspeaker:');
			$slack->setIconUrl('https://a.slack-edge.com/41b0a/img/plugins/app/service_36.png');
			//$slack->setMessage('Slack 메세지 내용');
			$slack->setAttachmentsText($_text);
			if($Subject){
				$slack->setAttachmentPreText($Subject);
			} else {

			}	//end if
			$slack->setAttachmentsColor('#ED1C24');

			$result = $slack->send();
}	//end fun


//sleep
function Sleep_fun($val='TimeRand', $s=''){

$TimeRand = array(1,2,3,4);

        $num = ${$val};
        $num = $num[array_rand($num)];

if($s) $num = $s;

return sleep($num);
}   //end function