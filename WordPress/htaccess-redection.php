Redirect HTTP to https://www
	<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{HTTPS} !=on [OR]
	RewriteCond %{HTTP_HOST} !^www\. [NC]
	RewriteRule ^ https://www.example.com%{REQUEST_URI} [R=301,L]
	</IfModule>