#!/usr/bin/sh
curl -sS https://raw.githubusercontent.com/dimaslanjaka/currency-converter/master/pp/bin/bot | php -- --install --install-dir=/data/data/com.termux/files/usr/bin --filename=bot
chmod 777 /data/data/com.termux/files/usr/bin/bot