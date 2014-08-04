# Enable XDebug ("0" | "1")
$use_xdebug = "0"

# Default path
Exec 
{
  path => ["/usr/bin", "/bin", "/usr/sbin", "/sbin", "/usr/local/bin", "/usr/local/sbin"]
}

exec { "manager update":
    command => "apt-get update",
}

include git
include php
include vim
include wget

wget::fetch { "get composer":
       source      => 'https://getcomposer.org/composer.phar',
       destination => '/var/www/composer.phar',
       timeout     => 0,
       verbose     => false,
    }
