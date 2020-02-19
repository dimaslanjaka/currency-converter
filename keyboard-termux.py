import os
from time import sleep


a ='\033[92m'
b ='\033[91m'
c ='\033[0m'
os.system('clear')
print(a+'\t Advanced Shortcut Termux ')
print(b+'\t Dimas Lanjaka')
print('\t https://www.webmanajemen.com')
print('\t Facebook : https://fb.me/dimaslanjaka1')
print('\t https://github.com/dimaslanjaka')
print(a+'+'*40)
print('\n Process..')
sleep(1)
print(b+'\n[!] Getting default termux settings')
sleep(1)
try:
      os.mkdir('/data/data/com.termux/files/home/.termux')
except:
      pass
print(a+'[!]Success !')
sleep(1)
print(b+'\n[!] Adding files..')
sleep(1)

key = 'extra-keys = [["ESC", "/", "-", "HOME", "UP", "END", "PGUP"], ["TAB", "CTRL", "ALT", "LEFT", "DOWN", "RIGHT", "PGDN"]]'
Control = open('/data/data/com.termux/files/home/.termux/termux.properties','w')
Control.write(key)
Control.close()
sleep(1)
print(a+'[!] Processing  !')
sleep(1)
print(b+'\n[!] Please wait...')
sleep(2)
os.system('termux-reload-settings')
print(a+'[!] Success')