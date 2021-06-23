# -*- coding: utf-8 -*- 

# 모니터 해상도 : 1920 * 1080
import time
import sys
import codecs
import requests
#pip install pyperclip	클립
import pyperclip

#pip install pyautogui	키보드
import pyautogui  

from tkinter import Tk

PyMode = sys.argv[1]


if PyMode == "stop" :
	pyautogui.leftClick(x=438, y=340)
	time.sleep(2)
	pyautogui.hotkey('alt', 'F4')
	exit()
else :

	#번역기록삭제
	pyautogui.leftClick(x=1851, y=204)
	time.sleep(1)
	pyautogui.hotkey('enter')	#엔터
	time.sleep(1)




	pyautogui.leftClick(x=438, y=340)
	time.sleep(1)
	pyautogui.hotkey('ctrl', 'a')


	#코드 가져오기
	f = open("C:/xampp/htdocs/_Ntos/_Trans/_TransOne_codelist.txt", "r", encoding="utf8")
	itemcode = f.read()
	f.close()

	#내용 가져오기
	f = open("C:/xampp/htdocs/_Ntos/_Trans/_TransOne_namelist.txt", "r", encoding="utf8")
	itemname = f.read()
	f.close()
	time.sleep(2)
	pyperclip.copy(itemname)
	pyautogui.hotkey('ctrl', 'v')
	time.sleep(2)


	pyautogui.hotkey('tab')
	time.sleep(1)
	pyautogui.hotkey('ctrl', 'a')
	time.sleep(1)
	pyautogui.hotkey('ctrl', 'c')


	result = Tk().selection_get(selection="CLIPBOARD")

	time.sleep(1)
	URL = 'http://amazon.ntos.co.kr/_Mini_/_WinTrans/ItemWinTrans.php' 
	data = {'CustId': 'amazon', 'mode': 'up', 'TransType':'papago', 'codelist':itemcode, 'namelist' : result } 
	response = requests.post(URL, data=data)