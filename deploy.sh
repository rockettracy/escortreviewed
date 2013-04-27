#!/bin/bash

BRANCH=`git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`
CURRENT_REVISION=`git log --pretty=format:"%h" -n1`
DEPLOY_USER=`who -m | cut -d " " -f 1`

SOURCE_PATH=$(cd $(dirname $0); pwd -P)
TARGET_PATH="/var/www/html"
BACKUP_FOLDER="/var/www/html_bak"

echo "stop Apache..."
sudo /etc/init.d/httpd stop

echo "backup running cache..."
sudo rm -rf "$BACKUP_FOLDER"
sudo cp -r "$TARGET_PATH" "$BACKUP_FOLDER" 

echo "pull latest code..."
sudo git pull
DEPLOY_REV=`git log | grep ^commit | head -1 | cut -d ' ' -f 2`

echo "deploy new branch: $BRANCH, REV: $DEPLOY_REV ..."
cd "$SOURCE_PATH/bbs15eng/upload"
sudo cp -r * "$TARGET_PATH/" 
cd "$SOURCE_PATH"

echo "start Apache..."
sudo /etc/init.d/httpd start

echo "Done. Good Luck!"
