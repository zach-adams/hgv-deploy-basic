# Getting Started with Mercury Vagrant (HGV)#
This project is intended as a tool for allowing WP Engine users to test their code prior to actual deployment on WP Engine "Mercury" infrastructure. This is not intended as an *exact* replica of WP Engine's infrastructure, but is instead a "simulator" of the conditions and software stack on WPE's Mercury platform, allowing you to develop and test your code with an end goal of stability and compatibility with Mercury.

Mercury differs from standard WordPress hosting in several ways, chief among which is the use of HHVM to serve all PHP code.

To quote HHVM's [website](http://hhvm.com/):

> HHVM is an open-source virtual machine designed for executing programs written in Hack and PHP. HHVM uses a just-in-time (JIT) compilation approach to achieve superior performance while maintaining the development flexibility that PHP provides.

## What you get ##
### Software stack ###
Once Vagrant is done provisioning the VM, you will have a box running [Ubuntu 14.04](http://releases.ubuntu.com/14.04/) (aka Trusty Tahr) containing

* [Percona DB](http://www.percona.com/software/percona-server)
* [PHP-FPM](http://php-fpm.org/)
* [HHVM](http://hhvm.com/)
* [Nginx](http://nginx.org/)
* [Varnish](https://www.varnish-cache.org/)
* [Memcached](http://memcached.org/)

### Sites ###
HGV automatically creates four sites and adds host file entries for them (*if you installed the `vagrant-hostsupdater` plugin, that is*):

* [hgv.dev](http://hgv.dev) -- General documentation and links for all of the tools
* [hhvm.hgv.dev](http://hhvm.hgv.dev) -- A new WordPress installation running on HHVM
* [php.hgv.dev](http://php.hgv.dev) -- A new WordPress installation running on PHP-FPM (PHP 5.5)
* [admin.hgv.dev](http://admin.hgv.dev) -- Useful administrative tools (phpMyAdmin, etc.)

If you did *not* install the `vagrant-hostsupdater` plugin, you will need to manually [add](http://www.howtogeek.com/howto/27350/beginner-geek-how-to-edit-your-hosts-file/) the following host entries to your host operating system's host files:

```
192.168.150.20 hgv.dev
192.168.150.20 admin.hgv.dev
192.168.150.20 hhvm.hgv.dev
192.168.150.20 php.hgv.dev
192.168.150.20 cache.hhvm.hgv.dev
192.168.150.20 cache.php.hgv.dev
```

### WordPress Installations ###
There are two default WordPress installations provided. Both have an admin user `wordpress` with a password `wordpress` (so secure!) already created.

#### php.hgv.dev ####
[php.hgv.dev](http://php.hgv.dev) is a basic WordPress install running the latest stable version of WordPress on a fairly standard [LEMP stack](https://lemp.io/) consisting of Nginx, PHP-FPM, and Percona DB.

#### hhvm.hgv.dev ####
[hhvm.hgv.dev](http://hvm.hgv.dev) is a basic WordPress install running the latest stable version of WordPress on top of an Nginx + HHVM + Percona DB stack.

#### WordPress developer tools ####
The following WordPress tools and plugins are installed on each WP site (but are **not** enabled) by default:

* [query-monitor](https://wordpress.org/plugins/query-monitor/)
* [debug-objects](https://wordpress.org/plugins/debug-objects/)
* [debug-bar](https://wordpress.org/plugins/debug-bar/)
* [p3-profiler](https://wordpress.org/plugins/p3-profiler/)

#### Accessing the sites on-disk ####
When you Users can access the WP installations directly by going to `[HGV directory]/hgv_data/sites/hhvm` and `[HGV directory]/hgv_data/sites/php` in the Finder (Mac)/Explorer (Windows)/filesystem navigator of choice (Linux, Free/Open/NetBSD, etc.)

#### Installing plugins and themes ####
Installing new plugins and themes is as simple as putting themes in `[HGV directory]/hgv_data/sites/[hhvm|php]/wp-content/[plugins|themes]`

## Admin Tools ##
HGV contains several useful tools for gathering system state and for administering individual aspects of the system.

### Database ###
phpMyAdmin is available at [admin.hgv.dev/phpmyadmin/](http://admin.hgv.dev/phpmyadmin/). The username is `root` and the  password is blank.

### Object Cache/Memcached ###
phpMemcachedAdmin is available at [admin.hgv.dev/phpmemcachedadmin/](http://admin.hgv.dev/phpmemcachedadmin/). You may use this tool to check on the status of the WordPress [object cache](http://codex.wordpress.org/Class_Reference/WP_Object_Cache).

## Development and debugging ##
### Command line (CLI) access ###
To connect to the Vagrant instance, type `vagrant ssh` from inside of the HGV directory. This will place you in the CLI on the VM. For example:

```bash
hostname:hgv username$ vagrant ssh
Welcome to Ubuntu 14.04 LTS (GNU/Linux 3.13.0-29-generic x86_64)

 * Documentation:  https://help.ubuntu.com/

  System information as of Mon Dec 15 17:30:03 UTC 2014

  System load:  0.01              Processes:           102
  Usage of /:   5.0% of 39.34GB   Users logged in:     1
  Memory usage: 76%               IP address for eth0: 10.0.2.15
  Swap usage:   0%                IP address for eth1: 192.168.150.20

  Graph this data and manage this system at:
    https://landscape.canonical.com/

  Get cloud support with Ubuntu Advantage Cloud Guest:
    http://www.ubuntu.com/business/services/cloud

122 packages can be updated.
59 updates are security updates.


Last login: Mon Dec 15 07:05:21 2014 from 10.0.2.2
vagrant@wpengine:~$
```

### Viewing log files ###
Once you are connected to the HGV virtual machine, system and web server logs can be viewed in `/var/log`. You may view the contents of the system log by typing `sudo less /var/log/syslog`.

Web server logs are stored in `/var/log/nginx`, with separate log files for every site. Each site has several log files associated with it:

* `[site].hgv.dev.access.log`
* `[site].hgv.dev.apachestyle.access.log`
* `[site].hgv.dev.error.log`

The first two logs track web requests to the sites, while the third log tracks errors reported, both by Nginx and by "upstream" PHP and HHVM processes.

HHVM logs are in `/var/log/hhvm`. PHP-FPM writes all of its logging information into `/var/log/php5-fpm.log`.

Sometimes, keeping tabs on a log file while hitting a site to view log messages in real-time can be helpful. To do so, run `sudo tail -f [log file]` from your SSH session. For example, `sudo tail -f /var/log/nginx/php.hgv.dev.error.log` would give you an always-updating view of the error log file for the PHP-FPM-based site.

### Database access ###
You may easily use the phpMyAdmin installation at [admin.hgv.dev/phpmyadmin/](http://admin.hgv.dev/phpmyadmin/) (as listed above) in order to view and interact with the underlying database. However, if you are used to using a third-party GUI, such as
[Sequel Pro](http://www.sequelpro.com/) or [MySQL Workbench](http://www.mysql.com/products/workbench/), TCP port 3306 (the MySQL/Percona port) is forwarded from the Vagrant VM to TCP port 23306 on your actual machine. You would then configure MySQL WB or Sequel Pro to connect to `localhost:23306`.

### Developer tools ###
The following developer tools are installed by default:

* Git
* Subversion
* Curl
* Ack
* Autojump
* Siege
* Composer
* PsySH
* Boris
* Xdebug
* XHProf
* PHPUnit

### Xdebug ###
PHP's Xdebug extension is enabled by default for the site based on PHP-FPM. Additionally, the WordPress installs have the following constants defined:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', true);
```

Enabling the Query Monitor WordPress plugin will allow logged-in users to view the useful debug information output by Xdebug, such as number of queries, number of objects, page render time, etc.

## FAQs ##
### I already use VVV, why do I need HGV? ###
One of the great features of Vagrant is it allows developers to work locally on an environment that is as close as possible to their production environment.  While VVV is an excellent WordPress development environment, it does not match any one hosting provider’s stack, it simply offers a common configuration.  HGV allows you to code locally on an environment that simulates the WPEngine Mercury platform, a highly tuned WordPress stack with forward looking technology not widely offered in the hosting ecosystem.  WPEngine has worked closely with Facebook to tune HHVM for the needs of WordPress, so you won’t get these constantly updating and improving configurations anywhere else.  

### What is the license for HGV? ###
HGV is Open Source and GPLv2.

### How do I use my own domain? ###
You can set that up manually, but currently there’s no automatic way to provision this and it is not supported in our documentation at this time.

### How do I remove HGV from my system? ###
From within the same directory you did “vagrant up” originally, type “vagrant destroy”.  The virtual machine will be destroyed (along with anything in it, so be sure to backup your databases!) and you can safely delete the directory if you don’t need to save any files within it.  HGV is continually improving, so feel free to reinstall and “destroy” as many times as you’d like!

### Can I contribute back to HGV? ###
Yes! HGV is open-sourced and hosted on GitHub. We encourage all users to submit bug reports and pull requests with features they would like to see.

### What does “stdin: is not a tty” mean? ###
Due to the way that Ubuntu configures its users, you may encounter this error the first time you run vagrant up or vagrant provision. It can safely be ignored and the provisioning process itself should remove the error on subsequent runs.
