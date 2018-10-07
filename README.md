# GeniSys AI Server
[![GeniSys AI Server](images/GeniSys.png)](https://github.com/GeniSysAI/Server)

[![CURRENT RELEASE](https://img.shields.io/badge/CURRENT%20RELEASE-0.0.1-blue.svg)](https://github.com/GeniSysAI/Server/tree/0.0.1)
[![UPCOMING RELEASE](https://img.shields.io/badge/UPCOMING%20RELEASE-0.0.2-blue.svg)](https://github.com/GeniSysAI/Server/tree/0.0.2)

# About GeniSys AI

GeniSys AI is an open source Artificial Intelligence Assistant Network using Computer Vision, Natural Linguistics and the Internet of Things. GeniSys uses a system based on [TASS A.I](https://github.com/TASS-AI/TASS-Facenet "TASS A.I") for [vision](https://github.com/GeniSysAI/Vision "vision"), an [NLU engine](https://github.com/GeniSysAI/NLU "NLU engine") for natural language understanding, in browser speech synthesis and speech recognition for speech and hearing, all homed on a dedicated Linux server in your home and managed via a secure UI.

# About GeniSys AI Server

[GeniSys AI Server](https://github.com/GeniSysAI/Server "GeniSys AI Server") is a customisable management system for [GeniSys AI](https://github.com/GeniSysAI/Server "GeniSys AI") networks. The GeniSys management system is built on top of [Ubuntu 18.04.1 LTS (Bionic Beaver)](http://releases.ubuntu.com/18.04/ "Ubuntu 18.04.1 LTS (Bionic Beaver)"), but there should be no issues using other Linux operating systems. The server uses a secure PHP/MySql Nginx server, [Let’s Encrypt](https://letsencrypt.org/ "Let’s Encrypt") for free SSL encryption, and free IoT connectivity via the [iotJumpWay](https://www.iotJumpWay.tech "iotJumpWay").

[![GeniSys AI Server](images/GeniSysHome.jpg)](https://github.com/GeniSysAI/Server)

Although the completed GeniSys Server will be accessible via the outside world, this is only to help ensure encrypted traffic over your local network. It is suggested that the UI is only accessed on the local IP, the Nginx server will proxy traffic to your internal IPs for features such as the NLU and the internal TASS camera will access the local camera of the device the program is running on.

# What Will We Do?

This tutorial will help you setup the server required for your GeniSys network, and also takes you through setting up iotJumpWay devices and applications. In detail this guide will cover the following:

- Installation: Ubuntu 18.04, Nginx, Let's Encrypt, PHP, MySql, phpMyAdmin, IPTables, iotJumpWay
- Setup: Nginx, PHP, MySql, phpMyAdmin, IPTables, iotJumpWay, Domain name & DNS configuration, router port forwarding, IPTables security, Device Proxies

# Installation & Setup

The following guides will give you the basics of setting up a GeniSys Server. 

# Install Ubuntu 18.04

For this project, the operating system of choice is  [Ubuntu 18.04.1 LTS (Bionic Beaver)](http://releases.ubuntu.com/18.04/ "Ubuntu 18.04.1 LTS (Bionic Beaver)"). To get your operating system installed you can follow the [Create a bootable USB stick on Ubuntu](https://tutorials.ubuntu.com/tutorial/tutorial-create-a-usb-stick-on-ubuntu#0 "Create a bootable USB stick on Ubuntu") tutorial.

# Setup Domain Name

Now is as good a time as any to sort out and configure a domain name. You need to have your domain already hosted on a hosting account, from there edit the DNS zone by adding an A record to your public IP, for this you need a static IP or IP software that will update the IP in the DNZ Zone each time it changes.

Once you have done this your domain name or subdomain will be pointing towards your public IP, if port 80 and 443 are not currently listening for traffic then visiting your domain name will result in a timeout for now.

# Install Nginx

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

# Setup Port Forwarding

Now you have your domain pointing to your public IP, it is time to add a port forward, traffic to your network will be coming from port 80 (insecure) and secure. Although Nginx will bounce the insecure traffic to port 443, we still need to add a port forward for port 80 as well as 443. How you will do this will vary, but you need to find the area of your router that allows you to add port forwards, and then add one port forward for incoming insecure traffic to port 80 of the server, and one for port 443. This will open the HTTP ports on your router and forward the traffic to the same ports on your server. In the case someone tries to access using insecure protocol (http - port 80) they will be automatically be sent to the secure port of the server (https - 443)

# Install Let's Encrypt

Security is everything, and it is even better when security is free ;) To encrypt our network we are going to use SSL provided by [Let’s Encrypt](https://letsencrypt.org/ "Let’s Encrypt"). Follow the commands below to set up Let’s Encrypt.

```
 $ sudo add-apt-repository ppa:certbot/certbot
 $ sudo apt-get update
 $ sudo apt-get install python-certbot-nginx
```

If you have followed above correctly you should now be able to access your website, but only using the secure protocol, 443, ie: https. If you visit your site you should now see the default Nginx page.

# UFW Firewall

Now you will set up your firewall:

```
 $ sudo ufw enable
 $ sudo ufw disable
```
Now add the ports that we will require to be open: (In future updates these rules will be tightened)

```
 $ sudo ufw allow 22
 $ sudo ufw allow 443
 $ sudo ufw allow 3306
```

Finally start and check the status

```
 $ sudo ufw enable
 $ sudo ufw status
```

Output:

```
To                         Action      From
--                         ------      ----
Nginx Full                 ALLOW       Anywhere
3306                       ALLOW       Anywhere
Nginx Full (v6)            ALLOW       Anywhere (v6)
3306 (v6)                  ALLOW       Anywhere (v6)
```

# Install MySql

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
 mysql> GRANT ALL ON *.* TO 'YourNewUsername'@'localhost' IDENTIFIED BY 'YourNewPassword';
```

Also create a user for your application database.

```
 mysql> GRANT SELECT, INSERT, DELETE  ON *.* TO 'YourNewUsername'@'localhost' IDENTIFIED BY 'YourNewPassword';
```

Finally, create the required database:

```
 mysql> CREATE DATABASE YourDatabaseName
```

# Install PHP

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

and match the [example default configuration](https://github.com/GeniSysAI/Server/blob/master/etc/nginx/sites-available/default "example default configuration"), replacing the domain name where relevant. Once you have completed those steps, issue the following commands which will tell you if the configuration is ok and if so you can reload Nginx. 

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

# Install phpMyAdmin

Now you should install phpMyAdmin and upload the default MySql table configuration.
 
```
 $ sudo apt-get install phpmyadmin
```
Press tab -> enter -> yes -> password, then create a link to phpMyAdmin, if you want to home this in a place other than phpmyadmin you can simply rename phpmyadmin in the command below.

```
 $ sudo ln -s /usr/share/phpmyadmin /var/www/html
```

Now you should be able to visit phpMyAdmin by accessing the relevant directory on your website. 

# Import MySql Databases

First you can download the [basic database structure](https://github.com/GeniSysAI/Server/blob/0.0.1/requirements/database.sql "basic database structure") required for the GeniSys server, this structure will change frequently along with the rest of the project so you should keep an eye out for important changes. 

Once you are logged in to phpMyAdmin, visit the import tab and import the sql file you just download and import it into the database you created earlier in the tutorial. 

# Install iotJumpWay

Now you need to install the iotJumpWay and setup some appications and devices. The following part of the tutorial will guide you through this. 

- [Find out about the iotJumpWay](https://www.iotjumpway.tech/how-it-works "Find out about the iotJumpWay") 
- [Find out about the iotJumpWay Dev Program](https://www.iotjumpway.tech/developers/ "Find out about the iotJumpWay Dev Program") 
- [Get started with the iotJumpWay Dev Program](https://www.iotjumpway.tech/developers/getting-started "Get started with the iotJumpWay Dev Program") 

[![iotJumpWay](images/iotJumpWayApplication.jpg)](https://www.iotJumpWay.tech/console)

First of all you should [register your free iotJumpWay account](https://www.iotjumpway.tech/console/register "register your free iotJumpWay account"), all services provided by the iotJumpWay are also entirely free within fair limits. Once you have registered you need to:

- Create your iotJumpWay location [(Documentation)](https://www.iotjumpway.tech/developers/getting-started-locations "(Documentation)") 
- Create your iotJumpWay zones [(Documentation)](https://www.iotjumpway.tech/developers/getting-started-zones "(Documentation)")  
- Create your iotJumpWay application [(Documentation)](https://www.iotjumpway.tech/developers/getting-started-applications "(Documentation)") 

To install the iotJumpWay MQTT software issue the following command on your server:

```
 $ sudo pip install JumpWayMQTT
```

# Install Repository Code

Now you can add the repository code to your server, to do this follow the guide:

- Clone the repo to the desktop of your server, or your preferred location on your server. The repository files have the same paths they would have on your server. 
- [/etc/nginx/sites-available/default](https://github.com/GeniSysAI/Server/blob/master/etc/nginx/sites-available/default  "/etc/nginx/sites-available/default") is an example of how your server NGINX configuration should look, located on your server in the same location as in the repo.
- You can copy the entire contents of the [Server/0.0.1/var/www](https://github.com/GeniSysAI/Server/tree/0.0.1/var/www  "Server/0.0.1/var/www") directory to the /var/www directory on your server.

# Update Configuration

Now it is time to update our server configuration. Open the [/var/www/classes/startup/confs.json](https://github.com/GeniSysAI/Server/blob/0.0.1/var/www/classes/startup/confs.json  "/var/www/classes/startup/confs.json") file on your server and add your database credentials, your iotJumpWay application credentials, iotJumpWay location ID and Application MQTT credentials. You will use your iotJumpWay application credentials to authenticate yourself onto the UI.  

# Connect To Your NLU

For this part you need to have followed the [GeniSys NLU](https://github.com/GeniSysAI/NLU  "GeniSys NLU") tutorial. If you have not completed the set up of your NLU engine you should follow that tutorial and ensure that the NLU engine API is online and listening / processing requests correctly. 

## Server Settings

First we need to visit the the Server Settings page, from the UI menu you can click on Server. Here you need to add the Server Name which is your choice of name to identify your server in the system, this will also be used as the meta title for your UI pages, then you need to update your Server URL, which is your fully qualified domain name (FQDN), and then finally the name that you used whilst setting up NGINX and PHP MyAdmin, now hit submit, if you do not see an error message, all is well.

## iotJumpWay Settings

The iotJumpWay Settings are already configured and pointing to the base URL for the API of http://www.iotJumpWay.tech.

## NLU Settings

Now you need to go to your NLU and attach the iotJumpWay device for the NLU that you created whilst setting up the NLU engine, once attached you will be able to add the base URL for your NLU engine API. Before we do that I will explain some things here, this assumes you used the default NGINX configuration provided, [/etc/nginx/sites-available/default](https://github.com/GeniSysAI/Server/blob/master/etc/nginx/sites-available/default  "/etc/nginx/sites-available/default").

You will notice the following code in your NGINX server configuration:

```
root /var/www/html;
server_name Subdomain.Domain.TLD;

location ~ ^/communicate/ {
    proxy_pass http://###.###.#.###:5824/$uri$is_args$args;
}
```

Basically what this does is proxies any secure traffic to the communicate endpoint to the local flask server serving your NLU engine API. Important to note that you must replace Subdomain.Domain.TLD with your subdomain domain name and TLD (Top Level Domain).

You need to use this URL in your Server Name configuration, so if your domain really was Subdomain.Domain.TLD, then your NLU would be accessible via https://Subdomain.Domain.TLD/communicate/. In our case our NLU API will be listening for JSON posts to the /communicate/infer/USERID endpoint, processing them and returning the classifications, so our full API url would be https://Subdomain.Domain.TLD/communicate/infer/USERID but the application handles the endpoints depending on what action is being taken. 

Now that this is all set up, providing your API is live, you should be able to talk with your AI.

[![NLU Interface](images/NLU-Interface.jpg)](https://github.com/GeniSysAI/Server)

# Connect To Your NLU

For this part you need to have followed the [GeniSys NLU](https://github.com/GeniSysAI/NLU  "GeniSys NLU") tutorial. If you have not completed the set up of your NLU engine you should follow that tutorial and ensure that the NLU engine API is online and listening / processing requests correctly. 

## Server Settings

First we need to visit the the Server Settings page, from the UI menu you can click on Server. Here you need to add the Server Name which is your choice of name to identify your server in the system, this will also be used as the meta title for your UI pages, then you need to update your Server URL, which is your fully qualified domain name (FQDN), and then finally the name that you used whilst setting up NGINX and PHP MyAdmin, now hit submit, if you do not see an error message, all is well.

## iotJumpWay Settings

The iotJumpWay Settings are already configured and pointing to the base URL for the API of http://www.iotJumpWay.tech.

## NLU Settings

Now you need to go to your NLU and attach the iotJumpWay device for the NLU that you created whilst setting up the NLU engine, once attached you will be able to add the base URL for your NLU engine API. Before we do that I will explain some things here, this assumes you used the default NGINX configuration provided, [/etc/nginx/sites-available/default](https://github.com/GeniSysAI/Server/blob/master/etc/nginx/sites-available/default  "/etc/nginx/sites-available/default").

You will notice the following code in your NGINX server configuration:

```
root /var/www/html;
server_name Subdomain.Domain.TLD;

location ~ ^/communicate/ {
    proxy_pass http://###.###.#.###:5824/$uri$is_args$args;
}
```

Basically what this does is proxies any secure traffic to the communicate endpoint to the local flask server serving your NLU engine API. Important to note that you must replace Subdomain.Domain.TLD with your subdomain domain name and TLD (Top Level Domain).

You need to use this URL in your Server Name configuration, so if your domain really was Subdomain.Domain.TLD, then your NLU would be accessible via https://Subdomain.Domain.TLD/communicate/. In our case our NLU API will be listening for JSON posts to the /communicate/infer/USERID endpoint, processing them and returning the classifications, so our full API url would be https://Subdomain.Domain.TLD/communicate/infer/USERID but the application handles the endpoints depending on what action is being taken. 

Now that this is all set up, providing your API is live, you should be able to talk with your AI.

[![NLU Interface](images/NLU-Interface.jpg)](https://github.com/GeniSysAI/Server)

# Interacting With TASS Local Computer Vision

The core and remote computer vision systems used by GeniSys are based on [TASS AI](https://www.tassai.tech "TASS AI"), if you have set up your [GeniSys AI Server](https://github.com/GeniSysAI/Server "GeniSys AI Server") and granted camera permissions to the UI, you will be able to see your self on the new dashboard. You can communicate with the NLU engine via the chat window to the right of the camera stream.

A new feature recently added to the upcoming 0.0.3 release is the ability for you to ask the AI who you are. This feature uses a combination of the iotJumpWay TASS REST API, the local server camera and TASS to determine who it saw in the last 10 seconds. 

[![Interacting With TASS Local Computer Vision](images/computer-vision.jpg)](https://github.com/GeniSysAI/Vision/tree/master/Local)

Each time a TASS device detects a known human or an intruder it updates the iotJumpWay enabling you to keep track as they move around the house, this allows the network to know where people at any one time as long as there are TASS units set up in each room. 

Using an action, the system will contact the iotJumpWay securely and retrieve any and all people it saw in the last five seconds. If it has not seen any one it will ask the user to look at the camera. 

These features are the first steps towards a system wide user management system which will include emotional analysis and a number of other features.

# Managing Your TASS Local Camera

The latest push to 0.0.1 allows you to connect your TASS Local camera to the UI and update the stream URL (Required for the system to work) 

[![Managing Your TASS Local Camera](images/TASS-Settings.jpg)](https://github.com/GeniSysAI/Server/tree/0.0.1/var/www/html/TASS)

You can also watch the live stream of your TASS Local camera:

[![Managing Your TASS Local Camera](images/TASS-Local-View-Main.jpg)](https://github.com/GeniSysAI/Server/tree/0.0.1/var/www/html/TASS)

[![Managing Your TASS Local Camera](images/TASS-Local-View.jpg)](https://github.com/GeniSysAI/Server/tree/0.0.1/var/www/html/TASS)

# Voice Recognition

It is now possible to interact with GeniSys using your voice. This feature is powered by an open source project [annyang](https://github.com/TalAter/annyang "annyang") which is basically a wrapper for the voice recognition feature of the web speech API, according to  [caniuse](https://caniuse.com/#feat=speech-synthesis "caniuse") support seems to be finally much wider including: Edge, Firefox, Chrome, Safari, ios Safari, Chrome for Android and Samsung Internet, but I have not tested anything other than Chrome. In Chrome for Android an alert noise is made every time the voice recognition restarts, this is unavoidable and there has been a long time developer request for Google to remove this feature but Google are adimant that it will remain. 

If you have updated your server code and booted up the server you should get asked for permissions to use the microphone, once you accept you will be able to speak to your NLU providing the NLU is online.
- [PyImageSearch](https://www.pyimagesearch.com/ "PyImageSearch")

# Contributing
Please read [CONTRIBUTING.md](https://github.com/GeniSysAI/Vision/blob/master/CONTRIBUTING.md "CONTRIBUTING.md") for details on our code of conduct, and the process for submitting pull requests to me.

# Versioning
I use SemVer for versioning. For the versions available, see [GeniSysAI/Server/releases](https://github.com/GeniSysAI/Server/releases "GeniSysAI/Server/releases").

# License
This project is licensed under the **MIT License** - see the [LICENSE](https://github.com/GeniSysAI/Server/blob/master/LICENSE "LICENSE") file for details.

# Bugs/Issues
I use the [repo issues](https://github.com/GeniSysAI/Server/issues "repo issues") to track bugs and general requests related to using this project. 

# Author
[![Adam Milton-Barker: BigFinte IoT Network Engineer & Intel® Software Innovator](images/Adam-Milton-Barker.jpg)](https://github.com/AdamMiltonBarker)


