server.modules = (
	"mod_indexfile",
	"mod_access",
	"mod_alias",
 	"mod_redirect",
	"mod_accesslog",
	"mod_compress",
	"mod_redirect",
	"mod_fastcgi",
)

server.document-root        = "/var/www/html"
server.upload-dirs          = ( "/var/cache/lighttpd/uploads" )
server.errorlog             = "/var/log/lighttpd/error.log"
server.pid-file             = "/var/run/lighttpd.pid"
server.username             = "www-data"
server.groupname            = "www-data"
server.port                 = 80

# strict parsing and normalization of URL for consistency and security
# https://redmine.lighttpd.net/projects/lighttpd/wiki/Server_http-parseoptsDetails
# (might need to explicitly set "url-path-2f-decode" = "disable"
#  if a specific application is encoding URLs inside url-path)
server.http-parseopts = (
  "header-strict"           => "enable",# default
  "host-strict"             => "enable",# default
  "host-normalize"          => "enable",# default
  "url-normalize-unreserved"=> "enable",# recommended highly
  "url-normalize-required"  => "enable",# recommended
  "url-ctrls-reject"        => "enable",# recommended
  "url-path-2f-decode"      => "enable",# recommended highly (unless breaks app)
 #"url-path-2f-reject"      => "enable",
  "url-path-dotseg-remove"  => "enable",# recommended highly (unless breaks app)
 #"url-path-dotseg-reject"  => "enable",
 #"url-query-20-plus"       => "enable",# consistency in query string
)

index-file.names            = ( "index.php", "index.html" )
url.access-deny             = ( "~", ".inc" )
static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

compress.cache-dir          = "/var/cache/lighttpd/compress/"
compress.filetype           = ( "application/javascript", "text/css", "text/html", "text/plain" )
fastcgi.server = ( ".php" =>
( "localhost" =>
(
"socket" => "/var/run/lighttpd/php-fastcgi.socket",
"bin-path" => "/usr/bin/php-cgi"
)
)
)

# default listening port for IPv6 falls back to the IPv4 port
include_shell "/usr/share/lighttpd/use-ipv6.pl " + server.port
include_shell "/usr/share/lighttpd/create-mime.conf.pl"
include "/etc/lighttpd/conf-enabled/*.conf"

#server.compat-module-load   = "disable"
server.modules += (
	"mod_compress",
	"mod_dirlisting",
	"mod_staticfile",
)
# Lighttpd
# Lighttpd
# Lighttpd
# Lighttpd
