# GeniSys AI Server
[![GeniSys AI Server](images/GeniSys.png)](https://github.com/GeniSysAI/Server)

[![UPCOMING RELEASE](https://img.shields.io/badge/UPCOMING%20RELEASE-0.0.1-blue.svg)](https://github.com/GeniSysAI/Server/tree/0.0.1)

## About GeniSys AI

GeniSys AI is an open source Artificial Intelligence Assistant Network using Computer Vision, Natural Linguistics and the Internet of Things. GeniSys uses a system based on [TASS A.I](https://github.com/TASS-AI/TASS-Facenet "TASS A.I") for [vision](https://github.com/GeniSysAI/Vision "vision"), an [NLU engine](https://github.com/GeniSysAI/NLU "NLU engine") for natural language understanding, in browser speech synthesis and speech recognition for speech and hearing, all homed on a dedicated Linux server in your home and managed via a secure UI.

[![GeniSys AI Structure](images/GeniSys-Structure.png)](https://github.com/GeniSysAI)

## About GeniSys AI Server

[GeniSys AI Server](https://github.com/GeniSysAI/Server "GeniSys AI Server") is a customisable management system for [GeniSys AI](https://github.com/GeniSysAI/Server "GeniSys AI") networks. The GeniSys management system is built on top of [Ubuntu 18.04.1 LTS (Bionic Beaver)](http://releases.ubuntu.com/18.04/ "Ubuntu 18.04.1 LTS (Bionic Beaver)"), but there should be no issues using other Linux operating systems. The server uses a secure PHP/MySql Nginx server, [Let’s Encrypt](https://letsencrypt.org/ "Let’s Encrypt") for free SSL encryption, and free IoT connectivity via the [iotJumpWay](https://www.iotJumpWay.tech "iotJumpWay").

[![GeniSys AI Server](images/GeniSysHome.jpg)](https://github.com/GeniSysAI/Server)

Although the completed GeniSys Server will be accessible via the outside world, this is only to help ensure encrypted traffic over your local network. It is suggested that the UI is only accessed on the local IP, the Nginx server will proxy traffic to your internal IPs for features such as the NLU and the internal TASS camera will access the local camera of the device the program is running on.

# What Will We Do?

This tutorial will help you setup the server required for your GeniSys network, and also takes you through setting up iotJumpWay devices and applications. In detail this guide will cover the following:

- Installation: Ubuntu 18.04, Nginx, Let's Encrypt, PHP, MySql, phpMyAdmin, IP tables
- Setup: Domain name & DNS configuration, router port forwarding, IP tables security, Device Proxy

# Installation & Setup

The following guides will give you the basics of setting up a GeniSys Server. 

## Install Ubuntu 18.04

For this project, the operating system of choice is  [Ubuntu 18.04.1 LTS (Bionic Beaver)](http://releases.ubuntu.com/18.04/ "Ubuntu 18.04.1 LTS (Bionic Beaver)"). To get your operating system installed you can follow the [Create a bootable USB stick on Ubuntu](https://tutorials.ubuntu.com/tutorial/tutorial-create-a-usb-stick-on-ubuntu#0 "Create a bootable USB stick on Ubuntu") tutorial.

## Setup Domain Name

Now is as good a time as any to sort out and configure a domain name. You need to have your domain already hosted on a hosting account, from there edit the DNS zone by adding an A record to your public IP, for this you need a static IP or IP software that will update the IP in the DNZ Zone each time it changes.

Once you have done this your domain name or subdomain will be pointing towards your public IP, if port 80 and 443 are not currently listening for traffic then visiting your domain name will result in a timeout for now.

## Install Nginx

Now it is time to install Nginx, follow the commands below to install the required software.

```
 $ sudo apt-get install nginx
 $ sudo cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup
 $ sudo systemctl status nginx.service
 $ sudo nano /etc/nginx/sites-available/default 
 $ sudo nginx -t
 $ sudo systemctl reload nginx
```

What the above commands do is:

- Installs Nginx
- Makes a copy of the default Nginx configuration named default.backup
- Checks the status of the service (server)
- Here you need to edit the default Nginx configuration replacing example.com in server_name (example.com www.example.com)
- Checks if the configuration is OK
- Reloads the Nginx service

You can check the Nginx logs by using the following command:

```
cat /var/log/nginx/error.log
```

## Setup Port Forwarding

Now you have your domain pointing to your public IP, it is time to add a port forward, traffic to your network will be coming from port 80 (insecure) and secure. Although Nginx will bounce the insecure traffic to port 443, we still need to add a port forward for port 80 as well as 443. How you will do this will vary, but you need to find the area of your router that allows you to add port forwards, and then add one port forward for incoming insecure traffic to port 80 of the server, and one for port 443. This will open the HTTP ports on your router and forward the traffic to the same ports on your server. In the case someone tries to access using insecure protocol (http - port 80) they will be automatically be sent to the secure port of the server (https - 443)

## Install Let's Encrypt

Security is everything, and it is even better when security is free ;) To encrypt our network we are going to use SSL provided by [Let’s Encrypt](https://letsencrypt.org/ "Let’s Encrypt"). Follow the commands below to set up Let’s Encrypt.

```
 $ sudo add-apt-repository ppa:certbot/certbot
 $ sudo apt-get update
 $ sudo apt-get install python-certbot-nginx
```

If you have followed above correctly you should now be able to access your website, but only using the secure protocol, 443, ie: https. If you visit your site you should now see the default Nginx page.

## Install IPTables

Now you should install IPTables, to do this execute the following code:

```
 $ sudo apt-get install iptables-persistent
 $ sudo apt-get install netfilter-persistent
```

Once installed,  you can check the current configuration with the following command:

```
 $ sudo iptables -L
```

Open the configuration file, use the **/etc/iptables/rules.v4** example in the project repo to replace the configuration after copying the default config.

```
 $ sudo cp /etc/iptables/rules.v4 sudo cp /etc/iptables/rules.v4.copy
 $ sudo nano /etc/iptables/rules.v4
```

You should notice the rules that allow traffic to the server, the ports that are accepted can be found in the **Acceptable TCP traffic** block:

```
-A TCP -p tcp --dport 22  -j ACCEPT
-A TCP -p tcp --dport 80  -j ACCEPT
-A TCP -p tcp --dport 443 -j ACCEPT
```

Then save and reload:

```
 $ sudo service netfilter-persistent save
 $ sudo service netfilter-persistent reload
```

## Install MySql

Now it is time to install MySql on your server. Follow the commands below and complete any required steps for the installation to accomplish this.

```
 $ sudo apt-get install mysql-server
 $ sudo mysql_secure_installation
```

Now create a user and password that we will use for phpMyAdmin, first login in with the root MySql username you created earlier and then enter the password when prompted, this will log you into MySql as that user.

```
 mysql -u YourMySqlRootUser -p
```

Now we can create a user with the required permissions to manage phpMyAdmin, make sure you remember the credentials you create with the below command.

```
 mysql> GRANT SELECT, INSERT, DELETE, CREATE  ON *.* TO 'YourNewUsername'@'localhost' IDENTIFIED BY 'YourNewPassword';
```

Also create a user for your application database.

```
 mysql> GRANT SELECT, INSERT, DELETE, CREATE  ON *.* TO 'YourNewUsername'@'localhost' IDENTIFIED BY 'YourNewPassword';
```

## Install PHP

Now you will install PHP on your server. Follow the commands below and complete any required steps for the installation to accomplish this. You may need to swap 7.2 in the second command depending on what version of php-fpm is installed.

```
 $ sudo apt-get install php-fpm php-mysql
 $ sudo nano /etc/php/7.2/fpm/php.ini
```

You should now be in the nano editing window, find  **cgi.fix_pathinfo** and change the value to 0

```
cgi.fix_pathinfo=0
```

Then restart PHP:

```
 $ sudo systemctl restart php7.2-fpm
```

Now you need to open the default configuration:

```
 $ sudo nano /etc/nginx/sites-available/default
```

and match the [example default configuration](https://github.com/GeniSysAI/Server/blob/0.0.1/etc/nginx/sites-available/default "example default configuration"), replacing the domain name where relevant. Once you have completed those steps, issue the following commands which will tell you if the configuration is ok and if so you can reload Nginx. 

```
 $ sudo nginx -t
 $ sudo systemctl reload nginx
```

Now create a file in the public html directory called info.php. The following command will open the new file for editing:

```
 $ sudo nano /var/www/html/info.php
```

Then you need to add the following code:

```
<?php
    phpinfo();
```

If you now visit the info page your website ie: https://www.YourDomain.com/info you should see the PHP configuration of your server.

![GeniSys AI Server PHP config](images/PHP.jpg)

## Install phpMyAdmin

Now you should install phpMyAdmin and upload the default MySql table configuration.
 
```
 $ sudo apt-get install phpmyadmin
```
Press tab -> enter -> yes -> password, then create a link to phpMyAdmin, if you want to home this in a place other than phpmyadmin you can simply rename phpmyadmin in the command below.

```
 $ sudo ln -s /usr/share/phpmyadmin /var/www/html
```

Now you should be able to visit phpMyAdmin by accessing the relevant directory on your website.

# Contributing
Please read **CONTRIBUTING.md** for details on our code of conduct, and the process for submitting pull requests to us.

# Versioning
We use SemVer for versioning. For the versions available, see the tags on this repository.

# License
This project is licensed under the **MIT License** - see the **LICENSE.md** file for details

# Bugs/Issues

We use issues to track bugs and general requests related to using this project.

# Author

[![Adam Milton-Barker: BigFinte IoT Network Engineer & Intel® Software Innovator](images/Adam-Milton-Barker.jpg)](https://github.com/AdamMiltonBarker)


