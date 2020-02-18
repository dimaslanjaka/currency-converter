#!/data/data/com.termux/files/usr/bin/sh
gdt=date '+%A %W %Y %X'
git add *
git commit -m "Changes ${gdt}"