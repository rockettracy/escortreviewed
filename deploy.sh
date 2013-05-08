#!/bin/bash

function usage {
  echo "./deploy.sh [-h] -e <dev|prod> -p <escort|baobaowiki>"
  exit 0
}

while getopts "he:m:p:" OPTIONS
  do
    case $OPTIONS
    in 
    h)
    usage
    ;;
    e)
    DEPLOY_ENV=$OPTARG
    ;;
    p)
    DEPLOY_PRODUCT=$OPTARG
    ;;
    *)
    usage
    ;;
    esac
  done

if [  -z "$DEPLOY_ENV" ]; then
  usage
fi
if [  -z "$DEPLOY_PRODUCT" ]; then
  usage
fi

echo "ready to start..."

BRANCH=`git branch --no-color 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`
CURRENT_REVISION=`git log --pretty=format:"%h" -n1`
DEPLOY_USER=`who -m | cut -d " " -f 1`

SOURCE_PATH=$(cd $(dirname $0); pwd -P)
if [ "$DEPLOY_ENV" == "prod" ];then
  TARGET_PATH="/var/www/html"
  BACKUP_FOLDER="/var/www/html_bak"
else
    if [ "$DEPLOY_PRODUCT" == "escort" ];then
      TARGET_PATH="/Users/kelinliu/Sites/escortreviewed"
      BACKUP_FOLDER="/Users/kelinliu/Sites/escortreviewed_bak"
    else
      TARGET_PATH="/Users/kelinliu/Sites/baobaowiki"
      BACKUP_FOLDER="/Users/kelinliu/Sites/baobaowiki_bak"
    fi
fi

echo "stop Apache..."
if [ "$DEPLOY_ENV" == "prod" ];then
  sudo /etc/init.d/httpd stop
fi

echo "backup running cache..."
sudo rm -rf "$BACKUP_FOLDER"
sudo cp -r "$TARGET_PATH" "$BACKUP_FOLDER" 

echo "pull latest code..."
sudo git pull
DEPLOY_REV=`git log | grep ^commit | head -1 | cut -d ' ' -f 2`

echo "deploy new branch: $BRANCH, ENV: $DEPLOY_ENV, REV: $DEPLOY_REV ..."
if [ "$DEPLOY_PRODUCT" == "escort" ];then
  cd "$SOURCE_PATH/bbs15eng/upload"
else
  cd "$SOURCE_PATH/baobaowiki/upload"
fi
sudo cp -r * "$TARGET_PATH/" 
cd "$SOURCE_PATH"

echo "start Apache..."
if [ "$DEPLOY_ENV" == "prod" ];then
  sudo /etc/init.d/httpd start
fi

echo "Done. Good Luck!"
