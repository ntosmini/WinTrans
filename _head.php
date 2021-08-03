<?php
/*
번역 상단
*/
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

	case 'reboot' :

			list($SetStartDay, $SetStartTime) = SetTime(300);
			exec('taskkill /im chrome.exe /f');
			sleep(0.5);
			exec('schtasks /delete /tn "'.$sName.'" /f');
			sleep(0.5);
			exec('schtasks /create /tn "'. $sName .'" /tr c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.Ready.bat /sc once /st '. $SetStartTime .' /sd '. $SetStartDay);
			sleep(0.5);
			exec('start shutdown /r /t 5');
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