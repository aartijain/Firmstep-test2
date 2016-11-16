# Firmstep-test2

Below command will download dependencies mentioned in composer.json file.

composer install

create host in httpd-vhosts.conf

<VirtualHost *:80>
   ServerName fscustomer.local
   DocumentRoot "C:/GITWORK/mvc/fsqueue/public"

   <Directory "C:/GITWORK/mvc/fsqueue/public">
       AllowOverride All
       Require all granted
   </Directory>
</VirtualHost>
