# EmilyGarfield.com

## Local Development

We use [Chassis](http://docs.chassis.io) for local development. You will need the latest versions of [VirtualBox](https://www.virtualbox.org/) and [Vagrant](https://www.vagrantup.com/) installed.

1. To get started, set up the project repositories: The commands below will pull down a local Chassis install, then clone this project into the `content` directory within the Chassis project root.
```bash
# Clone Chassis into `ehg.local`: This will be your local project root folder.
git clone --recursive https://github.com/Chassis/Chassis ehg.local

# Enter the newly-created ehg.local directory.
cd ehg.local

# Clone this repository as `/content`.
git clone --recursive git@github.com:kadamwhite/emilygarfield.com.git content

# Initialize the VM
vagrant up

# Re-run the provisioner to download plugins declared in config.local.yaml
vagrant provision
```

2. Download a full site backup from the WP Engine control panel, and move the `uploads` folder from the backup into `content/wp-content/uploads`.

3. Retrieve a backup of the production database from the WP Engine control panel, and copy that database file as `chassis-backup.sql` in the Chassis project root folder.

4. Delete the database that Vagrant set up on the initial `up`, then run the provisioner one final time to trigger the content import. Once the database has been imported, we use WP-CLI to activate plugins, rewrite the production site URLs to use the local VM's hostname, and create a local admin user.
```bash
# Delete original database.
vagrant ssh -c 'mysql --user="wordpress" --password="vagrantpassword" --database="wordpress" --execute="DROP DATABASE wordpress; CREATE DATABASE wordpress;"'

# Re-provision to import database.
vagrant provision

# Modify database for local use & activate all plugins.
vagrant ssh -c '
wp search-replace https://www.emilygarfield.com http://ehg.local;
wp search-replace https://emilygarfield.com http://ehg.local;
wp search-replace http://www.emilygarfield.com http://ehg.local;
wp search-replace http://emilygarfield.com http://ehg.local;

wp user create admin admin@ehg.local --role=administrator --user_pass=password;

wp plugin activate --all;
'

# Finally, regenerate thumbnails to force use of local files instead of Jetpack's CDN.
# (This will take a long time.)
vagrant ssh -c 'wp media regenerate --yes'
```

5. Once you have varified that the site is working correctly, delete the database backup file (`chassis-backup.sql`).

You may now access the site at [ehg.local](http://ehg.local), and administer the local copy with username `admin` and password `password`. Happy coding!
