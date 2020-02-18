#!/data/data/com.termux/files/usr/bin/sh
git config --global gui.encoding utf-8git remote -vgit add --all
gdt=date
git config --global user.name "dimaslanjaka"
git config --global user.email "dimaslanjaka@gmail.com"
git config --global github.user dimaslanjaka
t=`cat key.txt`
git config --global github.token $t
git add *
git commit -m "Changes ${gdt}"
git push