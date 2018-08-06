#!/bin/sh
url=https://wallpaper-house.com/group/nature-wallpaper-hd-mobile/index.php
#wget $url -o index.php
cat index.php | grep "<img src=" | awk -F "\"" '{print " wget https://wallpaper-house.com/group/nature-wallpaper-hd-mobile/"$2}' > file.txt
$(cat file.txt | awk '{print "wget "$2}')
#cat index.php | grep "<img src=" | awk -F "\"" '{system("wget "$4" -o images/"NR".png")}'
#PIC=$(ls images/*.png | shuf -n1)
#gsettings set org.gnome.desktop.background picture-uri "file://$PIC"
