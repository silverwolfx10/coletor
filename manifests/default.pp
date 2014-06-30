# Puppet configurations
 
class base {
 
## Update apt-get ##

  exec { 'python-software-properties':
    command => '/usr/bin/apt-get install python-software-properties -y',
    require => Exec["apt-get update"],
    user=>root
  }

  exec { 'add-apt-repository ppa:ondrej/php5':
    command => '/usr/bin/add-apt-repository ppa:ondrej/php5',
    require => Exec["python-software-properties"],
  }

  exec { 'apt-get update':
    command => '/usr/bin/apt-get update'
  }

  exec { 'apt-get update2':
      command => '/usr/bin/apt-get update',
       require => Exec["add-apt-repository ppa:ondrej/php5"],
    }

   package { "git":
    ensure => present,
  }
}

# class http{
#    package { "apache2":
#        ensure => present,
#    }
 
#    service { "apache2":
#        ensure => running,
#        require => Package["apache2"],
#    }
#}

class http {
 
  package { "apache2":
    ensure => present,
  }
 
  exec { "/usr/sbin/a2enmod rewrite" :
      unless => "/bin/readlink -e /etc/apache2/mods-enabled/rewrite.load",
      notify => Service[apache2]
  }
 

  exec { 'echo ServerName localhost >> /etc/apache2/apache2.conf':
    command => '/bin/echo ServerName localhost >> /etc/apache2/apache2.conf',
    require => Package["apache2"]
  }

  file { "/etc/apache2/sites-available/000-default.conf":
      source => '/vagrant/manifests/virtualhost',
      replace =>true,
      require => Package["apache2"]
    }
  
}

class http_run{
   
  service { "apache2":
    ensure => running,
    require => Class["http"],
  }
}

class php{
 
  package { "php5":
    ensure => present,
  }
 
  package { "php5-cli":
    ensure => present,
  }
 
  package { "php5-xdebug":
    ensure => present,
  }
 
  package { "php5-mysql":
    ensure => present,
  }
 
  package { "php5-imagick":
    ensure => present,
  }
 
  package { "php5-mcrypt":
    ensure => present,
  }
 
  package { "php-pear":
    ensure => present,
  }
 
  package { "php5-dev":
    ensure => present,
  }
 
  package { "php5-curl":
    ensure => present,
  }
 
  package { "php5-sqlite":
    ensure => present,
  }

  package { "php5-intl":
    ensure => present,
  }




 
  package { "libapache2-mod-php5":
    ensure => present,
  }

 # exec { 'cp -R /usr/lib/php5/20100525+lfs /usr/lib/php5/20090626+lfs ':
  #   path  => "/usr/bin:/usr/sbin:/bin"
  #}
 

}

class mysql{
 
  package { "mysql-server":
    ensure => present,
    require => Class["base"],
  }

  file { "/etc/mysql/my.cnf":
        source => '/vagrant/manifests/my.cnf',
        replace =>true,
        mode=>0644,
        require => Package["mysql-server"],
        notify => Exec["mysql-restart"],
      }
 
  service { "mysql":
    ensure => running,
    require => File["/etc/mysql/my.cnf"],
  }

    exec { 'mysql-restart':
         command  => "/etc/init.d/mysql restart",
         require => Package["mysql-server"],
         user=>'root',
    }

    exec { "create-coletor-db":
             unless => "/usr/bin/mysql -uroot rest",
             command => "/usr/bin/mysql -uroot -e \"create database coletor;\"",
             require => Exec["mysql-restart"],
    }



}

class phpunit{
     exec { 'pear config-set':
         command  => "/usr/bin/pear config-set auto_discover 1",
         require => Package["php-pear"],
         user=>'root',
     }
     exec { 'pear install pear.phpunit.de/PHPUnit':
          command  => "/usr/bin/pear install pear.phpunit.de/PHPUnit",
          require => Exec["pear config-set"],
          user=>'root',
     }

}

class crm_provisioning{
    exec { 'php composer.phar selfupdate':
              command  => "/usr/bin/php composer.phar selfupdate",
              path => "/vagrant/app/",
              require => [ Exec["create-rest_test-db"], Package["php5-dev"], Exec["echo ServerName localhost >> /etc/apache2/apache2.conf"]],
              user=>'root',
         }


   exec { 'php composer.phar update':
          command  => "/usr/bin/php  /vagrant/app/composer.phar update",
          require => Exec["php composer.phar selfupdate"],
          user=>'root',
     }
   exec { 'php doctrine-module orm:schema-tool:update --force':
         command  => "/usr/bin/php  /vagrant/app/vendor/bin/doctrine-module orm:schema-tool:update --force",
         require => Exec["php composer.phar update"],
         user=>'root',
    }
    exec { 'php doctrine-module data-fixture:import --append':
            command  => "/usr/bin/php  /vagrant/app/vendor/bin/doctrine-module data-fixture:import --append",
            require => Exec["php doctrine-module orm:schema-tool:update --force"],
            user=>'root',
       }
}
 
include base
include http
include http_run
include php
include mysql
include phpunit
#include crm_provisioning
