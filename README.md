# Mercury Vagrant (HGV) Deployment Playbook

[Click here for the full version](https://github.com/zach-adams/hgv-deploy-full)

## Introduction

This Ansible Playbook is designed to setup a [Mercury-Like](https://github.com/wpengine/hgv/) environment on a Production server without the configuration hassle. This playbook was forked from [WPEngine's Mercury Vagrant](https://github.com/wpengine/hgv/).

*Note: Remeber not to run weird scripts on your server as root without reviewing them first. Please review this playbook to ensure I'm not installing malicious software.*

This Playbook will setup:

- **Percona DB** (MySQL)
- **HHVM** (Default)
- **PHP-FPM** (Backup)
- **Nginx** (Customized for WordPress)
- **Clean WordPress Install** (Latest Version)
- **WP-CLI**

*Basic version does not include Varnish, Memcached and APC*

## Installation

1. SSH onto a newly created server
2. Add Ansible with `sudo add-apt-repository ppa:rquillo/ansible`
3. Update Apt with `sudo apt-get update && sudo apt-get upgrade`
4. Install Git and Ansible with `sudo apt-get install ansible git`
5. Clone this repository with `git clone https://github.com/zach-adams/hgv-deploy-basic/`
6. **IMPORTANT**: Change your settings inside `all` and `hosts` with `vim|nano|emacs group_vars/all` and `vim|nano|emacs hosts`
7. Run Ansible with `ansible-playbook -i hosts playbook.yml`
8. Remove the cloned git directory from your server
9. You're good to go! A new WordPress install running HHVM should be waiting for you at your hostname!

## Details

- You can find specific details of the site install in `group_vars/all`
- This setup currently works on Ubuntu 14.04 LTS and I cannot guarantee it will run on anything else (testing other distros soon!)
