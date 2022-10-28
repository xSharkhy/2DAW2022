import pyautogui, pyperclip, time


time.sleep(5)
pyperclip.copy('hola aitor te voy a copiar esto')

while True:
    pyautogui.hotkey('ctrl', 'v')
    pyautogui.press('enter')
    time.sleep(0.05)