#!/usr/bin/env bash

function setup-remotes() {
  git remote rm origin
  git remote add origin git@github.com:$1.git
  git fetch origin
}

function maybe-initialize-submodules() {
  git submodule init
  git submodule update --recursive
}

echo "Installing root project"
composer install

echo ""
echo "\ Swapping 'cartocacoethes' remote to SSH..."
echo "/------------------------------------------------------"
cd wp-content/themes/cartocacoethes
echo $PWD
setup-remotes kadamwhite/cartocacoethes
git checkout release
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

echo ""
echo "\ Swapping 'artgallery' remote to SSH..."
echo "/------------------------------------------------------"
cd wp-content/plugins/artgallery
echo $PWD
setup-remotes kadamwhite/artgallery
git checkout release
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

echo ""
echo "\ Swapping 'featured-item-blocks' remote to SSH..."
echo "/------------------------------------------------------"
cd wp-content/plugins/featured-item-blocks
echo $PWD
setup-remotes kadamwhite/featured-item-blocks
git checkout release
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

echo ""
echo "\ Swapping 'asset-loader' remote to SSH..."
echo "/------------------------------------------------------"
cd wp-content/plugins/asset-loader
echo $PWD
setup-remotes humanmade/asset-loader.git
git checkout master
# Very important: NO `npm install` in this directory!
# It would cause another top-level npm install, which would run this script,
# which would cause another top-level install, and so on... forever.
composer install
cd - > /dev/null

echo ""
echo "\ Initializing Virtual Machine..."
echo "/------------------------------------------------------"
vagrant up

echo ""
echo "\ Attempt to restore database..."
echo "/------------------------------------------------------"
echo "\ (you DID copy down the wp_emilygarfield.sql, right?)"
npm run import-production-db
