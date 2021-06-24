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
#pyautogui.hotkey('enter')	#엔터

time.sleep(1)
pyautogui.hotkey('alt', 'space')
time.sleep(1)
pyautogui.hotkey('x')
time.sleep(1)
pyautogui.leftClick(x=1866, y=160)
time.sleep(2)

pyautogui.leftClick(x=78, y=242)
pyautogui.hotkey('F6')
time.sleep(1)
pyperclip.copy("papago.naver.com/?sk=en&tk=ko")
pyautogui.hotkey('ctrl', 'v')
time.sleep(1)
#pyautogui.hotkey('del')	#del
pyautogui.hotkey('enter')	#엔터
time.sleep(3)

"""
pyperclip.copy("papago.naver.com/?sk=en&tk=ko")
time.sleep(1)

pyautogui.leftClick(x=68, y=154)
time.sleep(1)
pyautogui.hotkey('F6')


time.sleep(1)
pyautogui.hotkey('ctrl', 'v')
time.sleep(1)
pyautogui.hotkey('enter')	#엔터
time.sleep(3)
"""
"""
pyautogui.leftClick(x=388, y=267)
time.sleep(2)
pyautogui.leftClick(x=773, y=336)
time.sleep(2)
"""

#번역기록 창
pyautogui.leftClick(x=1889, y=217)