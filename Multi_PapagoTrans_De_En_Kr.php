<?php
include_once(dirname(__FILE__).'/_common.php');


$Chk_Hi = (int)date("Hi");

$RandTime = 120;	//초

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);
$SetStartTime = date('H:i', $SetStart);

$sName = "_WinTrans";

$dir = 'C:/xampp/htdocs/_Ntos/_Trans';
$TransData= CF_getDataURL('http://amazonde.ntos.co.kr/_Mini_/_WinTrans/Multi_PapagoTrans_De_En_Kr.List.php?CustId=amazon&pc='.$pc);



switch($TransData){
	case 'allstop' :
	case 'stop' :
		exec('taskkill /im chrome.exe /f');
		
		if($TransData == "stop"){
			exec('schtasks /delete /tn "'.$sName.'" /f');
			sleep(1);
			exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		} else {
			exec('schtasks /delete /tn "'.$sName.'" /f');
		}	//end if
		exit;
	break;

	case 'pull' :
		exec('taskkill /im chrome.exe /f');

		exec('schtasks /delete /tn "'.$sName.'" /f');
		sleep(1);
		exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		if($pc != 1){
			exec('c:\xampp\htdocs\_Ntos\_Trans\_GitPull.bat');
		}	//end if
		exit;
	break;

	case 'push' :
		exec('taskkill /im chrome.exe /f');

		exec('schtasks /delete /tn "'.$sName.'" /f');
		sleep(1);
		exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
		if($pc == 1){
			exec('c:\xampp\htdocs\_Ntos\_Trans\_GitPush.bat');
	}	//end if
		exit;
	break;

	default :

		$dest_file = $dir."/_Multi_PapagoTrans_De_En_Kr.txt";
		$source_file = fopen($dest_file, "w") or die("Unable to open file!");
		fwrite($source_file, $TransData);
		fclose($source_file);

		ob_start();
		passthru("/xampp/htdocs/_Ntos/_Trans/Multi_PapagoTrans_De_En_Kr.py $pc ");
		$Result = ob_get_clean(); 
		if(preg_match('@success@', $Result)) {
			$sType = "run";
		} else {
			$sType = "rerun";
		}

	break;

}	//end switch

unlink($dir."/_Multi_PapagoTrans_De_En_Kr.txt");

$sType = (empty($sType))?"run":$sType;

if($pc == 1){
	if($Chk_Hi >= "900" && $Chk_Hi <= "925"){
		$SetStartTime = "09:29";
		$sType = "ready";
	} else if($Chk_Hi >= "1010" && $Chk_Hi <= "1030"){
		$SetStartTime = "10:35";
		$sType = "ready";
	}
}


//스케줄 등록
exec('schtasks /delete /tn "'.$sName.'" /f');
sleep(1);
exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.Ready.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);

if($sType == "run"){	//바로시작
	exec('c:\xampp\php\php.exe -f "c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.php"');
	/*
	exec('schtasks /delete /tn "'.$sName.'" /f');
	exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\Multi_PapagoTrans_De_En_Kr.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);
	exec('schtasks /run /tn "'.$sName.'" ');
	*/
} else if($sType == "rerun"){
	sleep(1);
	exec('taskkill /im chrome.exe /f');	
	sleep(3);
	exec('schtasks /run /tn "'.$sName.'" ');
} else {
	sleep(1);
	exec('taskkill /im chrome.exe /f');	
}	//end if