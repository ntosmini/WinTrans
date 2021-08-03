<?php
include_once(dirname(__FILE__).'/_common.php');


$Chk_Hi = (int)date("Hi");

$RandTime = 120;	//초

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);
$SetStartTime = date('H:i', $SetStart);

$sName = "_WinTrans";

$TransName = "Multi_GoogleTrans_De_En";

$dir = 'C:/xampp/htdocs/_Ntos/_Trans';
$TransData= CF_getDataURL('http://amazonde.ntos.co.kr/_Mini_/_WinTrans/'.$TransName.'.List.php?CustId=amazon&pc='.$pc);



switch($TransData){
	case 'allstop' :
	case 'stop' :
		exec('taskkill /im chrome.exe /f');
		
		if($TransData == "stop"){
			exec('schtasks /delete /tn "'.$sName.'" /f');
			sleep(1);
			exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		} else {
			exec('schtasks /delete /tn "'.$sName.'" /f');
		}	//end if
		exit;
	break;

	case 'pull' :
		exec('taskkill /im chrome.exe /f');

		exec('schtasks /delete /tn "'.$sName.'" /f');
		sleep(1);
		exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		if($pc != 1){
			exec('c:\xampp\htdocs\_Ntos\_Trans\_GitPull.bat');
		}	//end if
		exit;
	break;

	case 'push' :
		exec('taskkill /im chrome.exe /f');

		exec('schtasks /delete /tn "'.$sName.'" /f');
		sleep(1);
		exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		if($pc == 1){
			exec('c:\xampp\htdocs\_Ntos\_Trans\_GitPush.bat');
	}	//end if
		exit;
	break;

	default :

		$dest_file = $dir."/_".$TransName.".txt";
		$source_file = fopen($dest_file, "w") or die("Unable to open file!");
		fwrite($source_file, $TransData);
		fclose($source_file);

		ob_start();
		passthru("/xampp/htdocs/_Ntos/_Trans/".$TransName.".py $pc ");
		$Result = ob_get_clean(); 
		if(preg_match('@success@', $Result)) {
			$sType = "run";
		} else {
			$sType = "rerun";
		}

	break;

}	//end switch

unlink($dir."/_".$TransName.".txt");

$sType = (empty($sType))?"run":$sType;


include_once(dirname(__FILE__).'/_tail.php');