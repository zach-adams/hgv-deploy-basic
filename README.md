# WARNING: DEPRECATED

Unfortunately I don't have the time to upkeep this project or provide updates for issues. I'd recommend using Carl Alexander's DebOps for WordPress project which does the same thing as this project. You can find it here:

https://github.com/carlalexander/debops-wordpress

# Mercury Vagrant (HGV) Deployment Playbook

[Click here for the full version](https://github.com/zach-adams/hgv-deploy-full)

## Introduction

This Ansible Playbook is designed to setup a [Mercury-Like](https://github.com/wpengine/hgv/) environment on a Production server without the configuration hassle. This playbook was forked from [WPEngine's Mercury Vagrant](https://github.com/wpengine/hgv/).

Essentially this server setup is a LEMP server except it runs HHVM by default instead of PHP-FPM.

*Note: Remeber not to run weird scripts on your server as root without reviewing them first. Please review this playbook to ensure I'm not installing malicious software.*

This Playbook will setup:

- **Percona DB** (MySQL)
- **HHVM** (Default)
- **PHP-FPM** (Backup)
- **Nginx** (Customized for WordPress)
- **Clean WordPress Install** (Latest Version)
- **WP-CLI**

*Basic version does not include Varnish, Memcached and APC*

#### This playbook will only run on Ubuntu 14.04 LTS or later

## Installation

1. SSH onto a newly created server
2. Add Ansible with `sudo add-apt-repository ppa:ansible/ansible`
3. Update Apt with `sudo apt-get update && sudo apt-get upgrade`
4. Install Git and Ansible with `sudo apt-get install ansible git`
5. Clone this repository with `git clone https://github.com/zach-adams/hgv-deploy-basic`
6. Edit `group_vars/all` with your specific details with `vim|emacs|nano group_vars/all`
7. Edit `hosts` with your specific hostname `vim|emacs|nano hosts`
8. Run Ansible with `ansible-playbook -i hosts playbook.yml`
9. Remove the cloned git directory from your server
10. You're good to go! A new WordPress install running HHVM and Varnish should be waiting for you at your hostname!

## Switching HHVM back to PHP-FPM

Your Nginx configuration should automatically facilitate switching to PHP-FPM if there's an issue with HHVM, however if you want to switch back manually you can do so like this:

1. Open your Nginx configuration with `vim|emacs|nano /etc/nginx/sites-available/( Your Hostname )`
2. Find the following section towards the bottom:

```
    location ~ \.php$ {
        proxy_intercept_errors on;
        error_page 500 501 502 503 = @fallback;
        fastcgi_buffers 8 256k;
        fastcgi_buffer_size 128k;
        fastcgi_intercept_errors on;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass hhvm;
    }
```

3. Change `fastcgi_pass hhvm;` to `fastcgi_pass php;`
4. Restart Nginx with `sudo service nginx restart`
5. You should now be running PHP-FPM! Check to make sure using `phpinfo();`

## Issues

Please report any issues through Github or email me at zach@zach-adams.com and I'll do my best to get back to you!
