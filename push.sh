#!/data/data/com.termux/files/usr/bin/sh
gdt=date '+%A %W %Y %X'
git config --global user.name "dimaslanjaka"
git config --global user.email "dimaslanjaka@gmail.com"
git config --global github.user dimaslanjaka
t=`cat key.txt`
git config --global github.token $t
git add *
git commit -m "Changes ${gdt}"
git push