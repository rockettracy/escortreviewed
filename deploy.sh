#!/bin/bash

DEPLOY_REV=`git log | grep ^commit | head -1 | cut -d ' ' -f 2`
BRANCH=`git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`
CURRENT_REVISION=`git log --pretty=format:"%h" -n1`
DEPLOY_USER=`who -m | cut -d " " -f 1`

SOURCE_PATH=$(cd $(dirname $0); pwd -P)
TARGET_PATH="/var/www/html"

echo "stop Apache..."
sudo /etc/init.d/httpd stop

echo "backup running code: REV: $CURRENT_REVISION ..."
sudo rm -rf "$TARGET_PATH/bbs_old"
sudo cp -r "$TARGET_PATH/bbs" "$TARGET_PATH/bbs_old"

echo "pull latest code..."
sudo git pull

echo "deploy new branch: $BRANCH, REV: $DEPLOY_REV ..."
sudo cp -r "$SOURCE_PATH/bbs" "$TARGET_PATH/" 

echo "start Apache..."
sudo /etc/init.d/httpd start

echo "Done. Good Luck!"
