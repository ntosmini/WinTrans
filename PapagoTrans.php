<?php
set_time_limit(0);
date_default_timezone_set('Asia/Seoul');
include_once(dirname(__FILE__).'/_common.php');

if($TransUrl != "stop") {

	$dir = 'C:/xampp/htdocs/_Ntos/_Trans';


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
	$dest_file = $dir."/_Trans_codelist.txt";
	$source_file = fopen($dest_file, "w") or die("Unable to open file!");
	fwrite($source_file, $CodeTxt);
	fclose($source_file);


	$NameTxt = implode("\n\n", $NameTxt);
	$dest_file = $dir."/_Trans_namelist.txt";
	$source_file = fopen($dest_file, "w") or die("Unable to open file!");
	fwrite($source_file, $NameTxt);
	fclose($source_file);

	exec('taskkill /im chrome.exe /f');
	exec('start chrome');
	Sleep_fun();
	ob_start();
	passthru("/xampp/htdocs/_Ntos/_Trans/PapagoTrans.py");
	$Result = ob_get_clean(); 
}
//���ϻ���
$dir = 'C:/xampp/htdocs/_Ntos/_Trans';
unlink($dir."/_Trans_codelist.txt");
unlink($dir."/_Trans_namelist.txt");


//����
$sName = "_Trans";

exec('schtasks /delete /tn "'.$sName.'" /f');

$Hi = (int)date("Hi");
	
$RandTime = 100;	//��

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);

$Start = false;
if(empty($limit)){
	if($Hi >= "900" && $Hi <= "925"){
		$SetStartTime = "09:29";;
	} else if($Hi >= "1010" && $Hi <= "1030"){
		$SetStartTime = "10:35";;
	} else {
		$Start = true;
		$SetStartTime = date('H:i', $SetStart);
	}
} else {
	$Start = true;
	$SetStartTime = date('H:i', $SetStart);
}	//end if $limit


exec('schtasks /create /tn "'.$sName.'" /tr c:\xampp\htdocs\_Ntos\_Trans\PapagoTrans.bat /sc minute /mo 3 /st '.$SetStartTime.' /sd '.$SetStartDay);
if($Start){
	sleep(3);
	exec('schtasks /run /tn "'.$sName.'" ');
}