echo "Ensuring submodules are initialized"
git submodule init
git submodule update --recursive

echo "Swapping 'cartocacoethes' remote from HTTP to SSH..."
cd wp-content/themes/cartocacoethes
git remote rm origin
git remote add origin git@github.com:kadamwhite/cartocacoethes.git
git fetch origin
cd - > /dev/null

echo "Swapping 'artgallery' remote from HTTP to SSH..."
cd wp-content/plugins/artgallery
git remote rm origin
git remote add origin git@github.com:kadamwhite/artgallery.git
git fetch origin
cd - > /dev/null

echo "Swapping 'featured-item-blocks' remote from HTTP to SSH..."
cd wp-content/plugins/featured-item-blocks
git remote rm origin
git remote add origin git@github.com:kadamwhite/featured-item-blocks.git
git fetch origin
cd - > /dev/null

echo "Swapping 'asset-loader' remote from HTTP to SSH..."
cd wp-content/plugins/asset-loader
git remote rm origin
git remote add origin git@github.com:humanmade/asset-loader.git
git fetch origin
cd - /dev/null
