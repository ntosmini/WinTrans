<?php
set_time_limit(0);
date_default_timezone_set('Asia/Seoul');
include_once(dirname(__FILE__).'/_common.php');

//�����ٷ� ���� 
$sName = "_Trans";

exec('schtasks /delete /tn "'.$sName.'" /f');