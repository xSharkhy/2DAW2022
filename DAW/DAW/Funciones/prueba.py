import pyautogui, pyperclip, time, sys


time.sleep(5)
pyperclip.copy('Javier no entregues la práctica')

while True:
    pyautogui.hotkey('ctrl', 'v')
    pyautogui.press('enter')
    time.sleep(1)