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

import ctypes
user32 = ctypes.windll.user32
screen_width = user32.GetSystemMetrics(0)
screen_height = user32.GetSystemMetrics(1)

screen_chk = "n"

if screen_width == 1920 and screen_height == 1080 :
	pass
else :
	print("Not Screen")
	exit()


pyautogui.hotkey('win')
time.sleep(1)
pyautogui.leftClick(x=115, y=1057)
time.sleep(1)
pyperclip.copy("chrome")
pyautogui.hotkey('ctrl', 'v')
time.sleep(1)
pyautogui.hotkey('enter')	#엔터


time.sleep(2)
pyautogui.hotkey('alt', 'space')
time.sleep(1)
pyautogui.hotkey('x')
time.sleep(1)



pyautogui.leftClick(x=438, y=340)
time.sleep(1)
pyautogui.hotkey('F6')


time.sleep(1)
pyperclip.copy("translate.google.com")
pyautogui.hotkey('ctrl', 'v')
time.sleep(1)
pyautogui.hotkey('enter')	#엔터
time.sleep(3)



pyautogui.leftClick(x=438, y=340)

#코드 가져오기
f = open("C:/xampp/htdocs/_Ntos/_Trans/_Trans_codelist.txt", 'r', encoding="utf8")
itemcode = f.read()


#내용 가져오기
f = open("C:/xampp/htdocs/_Ntos/_Trans/_Trans_namelist.txt", 'r', encoding="utf8")
itemname = f.read()
time.sleep(2)
pyperclip.copy(itemname)
pyautogui.hotkey('ctrl', 'v')
time.sleep(7)

pyautogui.leftClick(x=1755, y=365)
time.sleep(1)
pyautogui.scroll(-10000)	#스크롤 하단으로

time.sleep(3)
pyautogui.leftClick(x=1461, y=764)


result = Tk().selection_get(selection="CLIPBOARD")

time.sleep(2)
URL = 'http://amazon.ntos.co.kr/_Mini_/_WinTrans/ItemWinTrans.php' 
data = {'CustId': 'amazon', 'mode': 'up', 'TransType':'google', 'codelist':itemcode, 'namelist' : result } 
response = requests.post(URL, data=data)

time.sleep(5)
pyautogui.hotkey('alt', 'F4')