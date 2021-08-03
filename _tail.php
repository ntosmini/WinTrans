<?php
/*
번역 하단
*/
if($pc == 1){
	if($Chk_Hi >= "900" && $Chk_Hi <= "920"){
		$SetStartTime = "09:21";
		$sType = "ready";
	} else if($Chk_Hi >= "1000" && $Chk_Hi <= "1020"){
		$SetStartTime = "10:21";
		$sType = "ready";
	}
}

//스케줄 등록
exec('schtasks /delete /tn "'.$sName.'" /f');
sleep(1);
exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.Ready.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);

if($sType == "run"){	//바로시작
	exec('c:\xampp\php\php.exe -f "c:\xampp\htdocs\_Ntos\_Trans\\'.$TransName.'.php"');
} else if($sType == "rerun"){
	sleep(1);
	exec('taskkill /im chrome.exe /f');	
	sleep(3);
	exec('schtasks /run /tn "'.$sName.'" ');
} else {
	sleep(1);
	exec('taskkill /im chrome.exe /f');	
}	//end if