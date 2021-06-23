<?php
include_once(dirname(__FILE__).'/_common.php');

$TransUrl = CF_getDataURL('http://amazon.ntos.co.kr/_Mini_/_WinTrans/ItemWinTrans.php?CustId=amazon&limit='.$limit);

$dir = 'C:/xampp/htdocs/_Ntos/_Trans';

//재등록
$sName = "_TransOne";

$PyMode = 'not';
switch($TransUrl){
	case 'stop' :
		$PyMode = "stop";
		passthru("/xampp/htdocs/_Ntos/_Trans/PapagoTransOne.Start.py $PyMode");



		$Chk_Hi = (int)date("Hi");
		$Chk_i = (int)date("i");
			
		$RandTime = 80;	//초

		$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
		$SetStartDay = date('Y/m/d', $SetStart);

			exec('schtasks /delete /tn "'.$sName.'" /f');
			$SetStartTime = date('H:i', $SetStart);
			exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\PapagoTransOne.Ready.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);
			//			exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\PapagoTransOne.Ready.bat /sc minute /mo 3 /st '.$SetStartTime.' /sd '.$SetStartDay);

		exit;
	break;

	default :

		$pattern = '@<ItemList>(?P<ItemList>.*)</ItemList>@Us';
		preg_match_all($pattern, $TransUrl, $matches);
		$ItemList = $matches['ItemList'];

		$CodeTxt = array();
		$NameTxt = array();
		foreach($ItemList as $Key => $Val){
			$pattern = '@<code>(?P<Code>.*)</code>@Us';
			preg_match($pattern, $Val, $matches);
			$Code = $matches['Code'];
			$CodeTxt[] = $Code;

			$pattern = '@<name>(?P<Name>.*)</name>@Us';
			preg_match($pattern, $Val, $matches);
			$Name = $matches['Name'];
			$NameTxt[] = $Name;

		}

		$CodeTxt = implode("\n\n", $CodeTxt);
		$dest_file = $dir."/_TransOne_codelist.txt";
		$source_file = fopen($dest_file, "w") or die("Unable to open file!");
		fwrite($source_file, $CodeTxt);
		fclose($source_file);


		$NameTxt = implode("\n\n", $NameTxt);
		$dest_file = $dir."/_TransOne_namelist.txt";
		$source_file = fopen($dest_file, "w") or die("Unable to open file!");
		fwrite($source_file, $NameTxt);
		fclose($source_file);

		Sleep_fun();
		passthru("/xampp/htdocs/_Ntos/_Trans/PapagoTransOne.Start.py  $PyMode");

	break;
}	//end switch


if($TransUrl != "stop") {

}	//end if
//파일삭제
unlink($dir."/_TransOne_codelist.txt");
unlink($dir."/_TransOne_namelist.txt");



$Chk_Hi = (int)date("Hi");
$Chk_i = (int)date("i");
	
$RandTime = 60;	//초

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);



if(empty($limit)){
	if($Chk_Hi >= "900" && $Chk_Hi <= "925"){
		$SetStartTime = "09:29";

		exec('taskkill /im chrome.exe /f');
		exec('schtasks /delete /tn "'.$sName.'" /f');
		exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\PapagoTransOne.Ready.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);

	} else if($Chk_Hi >= "1010" && $Chk_Hi <= "1030"){
		$SetStartTime = "10:35";

		exec('taskkill /im chrome.exe /f');
		exec('schtasks /delete /tn "'.$sName.'" /f');
		exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\PapagoTransOne.Ready.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);

	} else {
		exec('c:\xampp/php/php.exe -f "c:\xampp\htdocs\_Ntos\_Trans/PapagoTransOne.Start.php"');
	}
} else {
		exec('c:\xampp\php\php.exe -f "c:\xampp\htdocs\_Ntos\_Trans\PapagoTransOne.Start.php"');
}	//end if $limit