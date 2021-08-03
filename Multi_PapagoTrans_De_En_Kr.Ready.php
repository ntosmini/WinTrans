<?php
include_once(dirname(__FILE__).'/_common.php');


if(!empty($pid)){
	exec('taskkill /f /pid '.$pid);
}
exec('taskkill /im chrome.exe /f');
//exec('taskkill /im cmd.exe /f');
sleep(3);
exec('start chrome');

$sName = "_WinTrans";
$TransName = "Multi_PapagoTrans_De_En_Kr";

exec('schtasks /delete /tn "'.$sName.'" /f');

passthru("/xampp/htdocs/_Ntos/_Trans/".$TransName.".Ready.py");

exec('c:/xampp/php/php.exe -f "c:/xampp/htdocs/_Ntos/_Trans/'.$TransName.'.php"');