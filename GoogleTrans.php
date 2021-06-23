<?php
set_time_limit(0);
date_default_timezone_set('Asia/Seoul');
include_once(dirname(__FILE__).'/_common.php');

if($TransUrl != "stop") {

	$dir = 'C:/xampp/htdocs/_Ntos/_Trans';


	$pattern = '@<code>(?P<Code>[^<]+)</code>@Us';
	preg_match_all($pattern, $TransUrl, $matches);
	$Code = $matches['Code'];
	$CodeTxt = array();
	foreach($Code as $Key => $Val){
		if($Val) $CodeTxt[] = $Val;
	}
	$CodeTxt = implode("\n\n", $CodeTxt);
	$dest_file = $dir."/_Trans_codelist.txt";
	$source_file = fopen($dest_file, "w") or die("Unable to open file!");
	fwrite($source_file, $CodeTxt);
	fclose($source_file);



	$pattern = '@<name>(?P<Name>[^<]+)</name>@Us';
	preg_match_all($pattern, $TransUrl, $matches);
	$Name = $matches['Name'];
	$NameTxt = array();
	foreach($Name as $Key => $Val){
		if($Val) $NameTxt[] = $Val;
	}
	$NameTxt = implode("\n\n", $NameTxt);
	$dest_file = $dir."/_Trans_namelist.txt";
	$source_file = fopen($dest_file, "w") or die("Unable to open file!");
	fwrite($source_file, $NameTxt);
	fclose($source_file);

	exec('taskkill /im chrome.exe /f');
	Sleep_fun();

	ob_start();
	passthru("/xampp/htdocs/_Ntos/_Trans/GoogleTrans.py");
	$Result = ob_get_clean(); 
}
//파일삭제
$dir = 'C:/xampp/htdocs/_Ntos/_Trans';
unlink($dir."/_Trans_codelist.txt");
unlink($dir."/_Trans_namelist.txt");


//재등록
$sName = "_Trans";

$Hi = (int)date("Hi");
	
$RandTime = 61;	//초

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);

if(empty($limit)){
	if($Hi >= "900" && $Hi <= "925"){
		$SetStartTime = "09:29";;
	} else if($Hi >= "1010" && $Hi <= "1030"){
		$SetStartTime = "10:31";;
	} else {
		$SetStartTime = date('H:i', $SetStart);
	}
} else {
	$SetStartTime = date('H:i', $SetStart);
}	//end if $limit



exec('schtasks /delete /tn "'.$sName.'" /f');
sleep(1);
exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\GoogleTrans.bat /sc once /st '.$SetStartTime.' /sd '.$SetStartDay);