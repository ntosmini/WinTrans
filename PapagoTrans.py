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

"""
pyautogui.hotkey('win')
time.sleep(1)
pyautogui.leftClick(x=115, y=1057)
time.sleep(1)
pyperclip.copy("chrome")
pyautogui.hotkey('ctrl', 'v')
time.sleep(2)
pyautogui.hotkey('enter')	#엔터
"""

time.sleep(3)
pyautogui.hotkey('alt', 'space')
time.sleep(1)
pyautogui.hotkey('x')
time.sleep(1)



pyautogui.leftClick(x=438, y=340)
time.sleep(1)
pyautogui.hotkey('F6')


time.sleep(1)
pyperclip.copy("papago.naver.com")
pyautogui.hotkey('ctrl', 'v')
#time.sleep(1)
pyautogui.hotkey('enter')	#엔터
time.sleep(3)

#언어선택
"""
pyautogui.leftClick(x=388, y=267)
time.sleep(2)
pyautogui.leftClick(x=773, y=336)
time.sleep(2)
"""

#번역기록삭제
pyautogui.leftClick(x=1889, y=217)
time.sleep(2)
pyautogui.leftClick(x=1851, y=204)
time.sleep(2)
pyautogui.hotkey('enter')	#엔터
time.sleep(2)




pyautogui.leftClick(x=438, y=340)


#코드 가져오기
f = open("C:/xampp/htdocs/_Ntos/_Trans/_Trans_codelist.txt", "r", encoding="utf8")
itemcode = f.read()
f.close()

#내용 가져오기
f = open("C:/xampp/htdocs/_Ntos/_Trans/_Trans_namelist.txt", "r", encoding="utf8")
itemname = f.read()
f.close()
time.sleep(2)
pyperclip.copy(itemname)
pyautogui.hotkey('ctrl', 'v')
time.sleep(2)

pyautogui.hotkey('ctrl', 'a')
time.sleep(1)
pyautogui.hotkey('ctrl', 'v')
time.sleep(6)


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

time.sleep(3)
pyautogui.hotkey('alt', 'F4')

#import os
#os.remove(r"./_Trans_codelist.txt")
#os.remove(r"./_Trans_namelist.txt")