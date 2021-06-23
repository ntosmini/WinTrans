<?php
include_once(dirname(__FILE__).'/_common.php');

exec('taskkill /im chrome.exe /f');
exec('start chrome');


passthru("/xampp/htdocs/_Ntos/_Trans/PapagoTransOne.Ready.py");

exec('c:/xampp/php/php.exe -f "c:/xampp/htdocs/_Ntos/_Trans/PapagoTransOne.Start.php"');