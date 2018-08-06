#!/bin/bash
DIR="/home/kamlesh/cs252/assign1"
PIC=$(ls $DIR/*.jpg | shuf -n1)
echo "oh yeah 1"
gsettings set org.gnome.desktop.background picture-uri "file://$PIC"
echo "oh yeah 2"
