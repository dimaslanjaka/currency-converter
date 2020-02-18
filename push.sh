#!/data/data/com.termux/files/usr/bin/sh
am start -a android.intent.action.VIEW -d https://github.com/settings/tokens
git config --global gui.encoding utf-8
git remote -v 
git remote remove origin 
git remote add origin https://github.com/dimaslanjaka/currency-converter.git

git add --all
git commit -m "Changes ${date}"
#git rebase origin/master
#git pull
#git push -u origin master
git push --set-upstream origin master