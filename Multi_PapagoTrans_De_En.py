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

from bs4 import BeautifulSoup
sys.stdout=codecs.getwriter("utf-8")(sys.stdout.detach())

from urllib.request import urlopen

Pc = sys.argv[1]
Pc = "PC" + Pc

#원문 가져오기
f = open("C:/xampp/htdocs/_Ntos/_Trans/_Multi_PapagoTrans_De_En.txt", "r", encoding="utf8")
TransData = f.read()
f.close()

#번역시작
List = TransData.split("\n\n")
number = 0
itemcodeArr = []
itemnameArr = []

for val in List :
	(itemcode,itemname) = val.split("|@|")
	itemcodeArr.insert(number, itemcode)
	itemnameArr.insert(number, itemname)
	number = number +1

TransItemCode = "|@|".join(itemcodeArr)
TransItemName = "\n\n".join(itemnameArr)
pyperclip.copy(TransItemName)

#원문 입력 클릭
pyautogui.leftClick(x=438, y=340)
#	time.sleep(1)

#원문 입력
pyautogui.hotkey('ctrl', 'a')
time.sleep(1)
pyautogui.hotkey('ctrl', 'v')
time.sleep(5)


pyautogui.hotkey('tab')
time.sleep(1)
pyautogui.hotkey('ctrl', 'a')
time.sleep(1)
pyautogui.hotkey('ctrl', 'c')
#	time.sleep(2)
time.sleep(1)

result = Tk().selection_get(selection="CLIPBOARD")

time.sleep(1)
URL = 'http://amazonde.ntos.co.kr/_Mini_/_WinTrans/Multi_PapagoTrans_De_En.Up.php' 
data = {'CustId': 'amazon', 'Pc':Pc, 'codelist':TransItemCode, 'namelist' : result } 
response = requests.post(URL, data=data)

#	time.sleep(1)
pyautogui.scroll(5000)	#스크롤 상단으로
time.sleep(2)

#번역기록삭제
pyautogui.leftClick(x=1851, y=204)
time.sleep(1)
pyautogui.hotkey('enter')	#엔터

#원문 삭제
#	time.sleep(1)
pyautogui.leftClick(x=754, y=333)
print(response.text)