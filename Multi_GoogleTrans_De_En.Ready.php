<?php
include_once(dirname(__FILE__).'/_common.php');

exec('taskkill /im chrome.exe /f');
//exec('taskkill /im cmd.exe /f');
sleep(3);
exec('start chrome');

$sName = "_WinTrans";
exec('schtasks /delete /tn "'.$sName.'" /f');

passthru("/xampp/htdocs/_Ntos/_Trans/Multi_GoogleTrans_De_En.Ready.py");

exec('c:/xampp/php/php.exe -f "c:/xampp/htdocs/_Ntos/_Trans/Multi_GoogleTrans_De_En.php"');