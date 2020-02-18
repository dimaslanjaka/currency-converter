#git config --global credential.helper store
#git config credential.helper store 
git config --global credential.helper 'cache --timeout=360090' 
git config --global user.name "dimaslanjaka"
git config --global user.email "dimaslanjaka@gmail.com"
git config --global github.user dimaslanjaka
#git config --global user.signingkey 1DEDA67CD4106FF5
t=`cat key.txt`
git config --global github.token $t
#curl -u dimaslanjaka:$t https://api.github.com/user
#curl -v -H "Authorization: token ${t}" https://api.github.com/user/issues