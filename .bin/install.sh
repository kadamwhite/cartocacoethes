function setup-remotes() {
  git remote rm origin
  git remote add origin git@github.com:$1.git
  git fetch origin
}

function install() {
  npm install
  composer install
  git submodule init
  git submodule update --recursive
}

echo "Installing root project"
install

echo "Swapping 'cartocacoethes' remote from HTTP to SSH..."
cd wp-content/themes/cartocacoethes
setup-remotes kadamwhite/cartocacoethes
install
cd - > /dev/null

echo "Swapping 'artgallery' remote from HTTP to SSH..."
cd wp-content/plugins/artgallery
setup-remotes kadamwhite/artgallery
install
cd - > /dev/null

echo "Swapping 'featured-item-blocks' remote from HTTP to SSH..."
cd wp-content/plugins/featured-item-blocks
setup-remotes kadamwhite/featured-item-blocks
install
cd - > /dev/null

echo "Swapping 'asset-loader' remote from HTTP to SSH..."
cd wp-content/plugins/asset-loader
setup-remotes humanmade/asset-loader.git
install
cd - /dev/null
