<?php
include_once(dirname(__FILE__).'/_common.php');


$Chk_Hi = (int)date("Hi");


list($SetStartDay, $SetStartTime) = SetTime(120);


$sName = "_WinTrans";

$TransName = "Multi_PapagoTrans_En_Kr";

$CustId = "amazon";

$dir = 'C:/xampp/htdocs/_Ntos/_Trans';


$TransData= CF_getDataURL('http://amazon.ntos.co.kr/_Mini_/_WinTrans/'.$TransName.'.List.php?CustId='.$CustId.'&pc='.$pc);

//상단 공통
include_once(dirname(__FILE__).'/_head.php');

//파일삭제
unlink($dir."/_".$TransName.".txt");

$sType = (empty($sType))?"run":$sType;

//하단 공통
include_once(dirname(__FILE__).'/_tail.php');