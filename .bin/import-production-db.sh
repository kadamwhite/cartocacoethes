#!/usr/bin/env bash

if [[ ! -f '../Vagrantfile' ]]; then
  echo 'Error! Expected to find Vagrantfile one level above current working directory.';
  echo 'Cannot continue.'
  exit;
fi
if [[ ! -f '../wp_emilygarfield.sql' ]]; then
  echo 'Expected SQL file `wp_emilygarfield.sql` in Vagrant root, but none found!';
  echo 'Provide a production database backup in the VM root folder and try again.';
  exit;
fi
vagrant ssh -c '
wp db reset --yes
wp db import /vagrant/wp_emilygarfield.sql

# Clean up database
wp search-replace www.emilygarfield.com ehg.local
wp search-replace emilygarfield.com ehg.local
wp search-replace emilygarfield.wpengine.com ehg.local
wp search-replace ehg.local/wp-content ehg.local/content

# Setup plugins and theme
wp plugin activate artgallery
wp plugin activate featured-item-blocks
wp theme activate cartocacoethes
wp user create admin admin@ehg.local --role=administrator --user_pass=password

# Update Artwork posts
wp artgallery-migrate-acf-meta

# Populate homepage with new content
wp post update $( wp post list --name=homepage --post_type=page --field=ID ) --post_type=page --post_content="$( cat /vagrant/content/homepage-content.txt )" --post_title="Homepage"
'
