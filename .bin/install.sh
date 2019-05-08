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

# echo "Swapping 'cartocacoethes' remote from HTTP to SSH..."
cd wp-content/themes/cartocacoethes;
echo $PWD;
setup-remotes kadamwhite/cartocacoethes
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

# echo "Swapping 'artgallery' remote from HTTP to SSH..."
cd wp-content/plugins/artgallery;
echo $PWD;
setup-remotes kadamwhite/artgallery
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

# echo "Swapping 'featured-item-blocks' remote from HTTP to SSH..."
cd wp-content/plugins/featured-item-blocks;
echo $PWD;
setup-remotes kadamwhite/featured-item-blocks
maybe-initialize-submodules
npm install
composer install
cd - > /dev/null

# echo "Swapping 'asset-loader' remote from HTTP to SSH..."
cd wp-content/plugins/asset-loader;
echo $PWD;
setup-remotes humanmade/asset-loader.git
# Very important: NO `npm install` in this directory!
composer install
cd - > /dev/null
