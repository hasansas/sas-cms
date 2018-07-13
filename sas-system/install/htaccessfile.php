<?php

$htaccess = '# BEGIN GZIP ##
<ifmodule mod_deflate.c>
AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css text/javascript application/x-javascript application/javascript image/svg+xml
</ifmodule>
# END GZIP ##

# EXPIRES CACHING ##
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access 1 year"
ExpiresByType image/jpeg "access 1 year"
ExpiresByType image/gif "access 1 year"
ExpiresByType image/png "access 1 year"
ExpiresByType text/css "access 1 month"
ExpiresByType text/html "access 1 month"
ExpiresByType application/pdf "access 1 month"
ExpiresByType text/x-javascript "access 1 month"
ExpiresByType application/x-shockwave-flash "access 1 month"
ExpiresByType image/x-icon "access 1 year"
ExpiresDefault "access 1 month"
</IfModule>
# END EXPIRES CACHING ##


RewriteEngine on
RewriteCond $1 !^(index\.php|sas-admin/themes|sas-system/plugins|sas-system/form/ckeditor|sas-system/form/tree|sas-system/form/icons|sas-content/themes|sas-content/uploads|\/)
RewriteRule ^(.*)$ /'.$baseURL.'index.php?$1 [L]';

$hFile	= fopen(basePath.'.htaccess','w');
if(!fwrite($hFile,$htaccess)){
	$errorInstall = true;
}
fclose($hFile);
?>
