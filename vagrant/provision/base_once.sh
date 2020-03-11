#!/usr/bin/env bash

# Check If Base script Has Been Installed
if [[ -f /home/vagrant/.homestead-features/base ]]; then
    echo "Base scripts already installed."
    exit 0
fi

mkdir -p /home/vagrant/.homestead-features

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

touch /home/vagrant/.homestead-features/base
chown -Rf vagrant:vagrant /home/vagrant/.homestead-features

info "Configure timezone"
timedatectl set-timezone UTC --no-ask-password

info "Update OS software"
apt-get update
apt-get upgrade -y

# Install Some PPAs
apt-get install -y software-properties-common curl

apt-add-repository ppa:nginx/development -y
apt-add-repository ppa:ondrej/php -y
apt-add-repository ppa:chris-lea/redis-server -y

curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -

sudo tee /etc/apt/sources.list.d/pgdg.list <<END
deb http://apt.postgresql.org/pub/repos/apt/ bionic-pgdg main
END

wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -

# Update Package Lists
apt-get update

# Install Some Basic Packages
apt-get install -y build-essential dos2unix gcc git libmcrypt4 libpcre3-dev libpng-dev chrony unzip make python2.7-dev \
python-pip re2c supervisor unattended-upgrades whois vim libnotify-bin pv cifs-utils mcrypt bash-completion zsh \
graphviz avahi-daemon tshark
#Old
#imagemagick

# Set My Timezone
ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Install Generic PHP packages
apt-get install -y --allow-change-held-packages \
php-redis php-xdebug php-dev php-mongodb
#Old
#php-imagick php-memcached

# PHP 7.3
apt-get install -y --allow-change-held-packages \
php7.3 php7.3-bcmath php7.3-bz2 php7.3-cgi php7.3-cli php7.3-common php7.3-curl php7.3-dba php7.3-dev php7.3-enchant \
php7.3-fpm php7.3-gd php7.3-gmp php7.3-interbase php7.3-intl php7.3-json php7.3-ldap php7.3-mbstring \
php7.3-mysql php7.3-odbc php7.3-opcache php7.3-phpdbg php7.3-pspell php7.3-readline php7.3-recode \
php7.3-snmp php7.3-soap php7.3-tidy php7.3-xml php7.3-xmlrpc php7.3-xsl php7.3-zip
#Old
#php7.3-pgsql php7.3-imap php7.3-sqlite3 php7.3-sybase

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Set Some PHP CLI Settings
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.3/cli/php.ini

# Install Nginx
apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
nginx

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default

# Create a configuration file for Nginx overrides.
sudo mkdir -p /home/vagrant/.config/nginx
sudo chown -R vagrant:vagrant /home/vagrant
touch /home/vagrant/.config/nginx/nginx.conf
sudo ln -sf /home/vagrant/.config/nginx/nginx.conf /etc/nginx/conf.d/nginx.conf

echo "xdebug.remote_enable = 1" >> /etc/php/7.3/mods-available/xdebug.ini
echo "xdebug.remote_connect_back = 1" >> /etc/php/7.3/mods-available/xdebug.ini
echo "xdebug.remote_port = 9000" >> /etc/php/7.3/mods-available/xdebug.ini
echo "xdebug.max_nesting_level = 512" >> /etc/php/7.3/mods-available/xdebug.ini
echo "opcache.revalidate_freq = 0" >> /etc/php/7.3/mods-available/opcache.ini

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.3/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.3/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.3/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.3/fpm/php.ini
sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/7.3/fpm/php.ini
sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/7.3/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.3/fpm/php.ini

printf "[openssl]\n" | tee -a /etc/php/7.3/fpm/php.ini
printf "openssl.cainfo = /etc/ssl/certs/ca-certificates.crt\n" | tee -a /etc/php/7.3/fpm/php.ini

# Disable XDebug On The CLI
sudo phpdismod -s cli xdebug

# Copy fastcgi_params to Nginx because they broke it on the PPA
cat > /etc/nginx/fastcgi_params << EOF
fastcgi_param	QUERY_STRING		\$query_string;
fastcgi_param	REQUEST_METHOD		\$request_method;
fastcgi_param	CONTENT_TYPE		\$content_type;
fastcgi_param	CONTENT_LENGTH		\$content_length;
fastcgi_param	SCRIPT_FILENAME		\$request_filename;
fastcgi_param	SCRIPT_NAME		\$fastcgi_script_name;
fastcgi_param	REQUEST_URI		\$request_uri;
fastcgi_param	DOCUMENT_URI		\$document_uri;
fastcgi_param	DOCUMENT_ROOT		\$document_root;
fastcgi_param	SERVER_PROTOCOL		\$server_protocol;
fastcgi_param	GATEWAY_INTERFACE	CGI/1.1;
fastcgi_param	SERVER_SOFTWARE		nginx/\$nginx_version;
fastcgi_param	REMOTE_ADDR		\$remote_addr;
fastcgi_param	REMOTE_PORT		\$remote_port;
fastcgi_param	SERVER_ADDR		\$server_addr;
fastcgi_param	SERVER_PORT		\$server_port;
fastcgi_param	SERVER_NAME		\$server_name;
fastcgi_param	HTTPS			\$https if_not_empty;
fastcgi_param	REDIRECT_STATUS		200;
EOF

# Set The Nginx & PHP-FPM User
sed -i "s/user www-data;/user vagrant;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 64;/" /etc/nginx/nginx.conf

sed -i "s/user = www-data/user = vagrant/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/group = www-data/group = vagrant/" /etc/php/7.3/fpm/pool.d/www.conf

sed -i "s/listen\.owner.*/listen.owner = vagrant/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/listen\.group.*/listen.group = vagrant/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.3/fpm/pool.d/www.conf

sudo update-alternatives --set php /usr/bin/php7.3

service nginx restart
service php7.3-fpm restart

# Add Vagrant User To WWW-Data
usermod -a -G www-data vagrant
id vagrant
groups vagrant

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"