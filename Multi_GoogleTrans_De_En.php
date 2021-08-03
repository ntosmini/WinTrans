<?php
include_once(dirname(__FILE__).'/_common.php');


$Chk_Hi = (int)date("Hi");

$RandTime = 120;	//초

$SetStart = mktime(date('H'),date('i'),date('s')+$RandTime,date('m'),date('d'),date('Y'));
$SetStartDay = date('Y/m/d', $SetStart);
$SetStartTime = date('H:i', $SetStart);

$sName = "_WinTrans";

$TransName = "Multi_GoogleTrans_De_En";

$CustId = "amazon";

$dir = 'C:/xampp/htdocs/_Ntos/_Trans';


$TransData= CF_getDataURL('http://amazonde.ntos.co.kr/_Mini_/_WinTrans/'.$TransName.'.List.php?CustId='.$CustId.'&pc='.$pc);

//상단 공통
include_once(dirname(__FILE__).'/_head.php');

//파일삭제
unlink($dir."/_".$TransName.".txt");

$sType = (empty($sType))?"run":$sType;

//하단 공통
include_once(dirname(__FILE__).'/_tail.php');