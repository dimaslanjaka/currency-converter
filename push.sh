#!/data/data/com.termux/files/usr/bin/sh
git config --global gui.encoding utf-8

git config --global credential.helper store
git config --global user.name "dimaslanjaka"
git config --global user.email "dimaslanjaka@gmail.com"
git config --global github.user dimaslanjaka
#git config --global user.signingkey 1DEDA67CD4106FF5
t=`cat key.txt`
git config --global github.token $t

git remote -v 
git remote remove origin 
git remote add origin https://github.com/dimaslanjaka/currency-converter.git

git add --all
gdt=date
git commit -m "Changes ${gdt}"
#git rebase origin/master
#git pull
#git push -u origin master
git push --set-upstream origin master