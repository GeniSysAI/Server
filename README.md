# GeniSys AI Server
[![GeniSys AI Server](Media/Images/GeniSys.png)](https://github.com/GeniSysAI/Server)

[![CURRENT RELEASE](https://img.shields.io/badge/CURRENT%20RELEASE-0.0.2-blue.svg)](https://github.com/GeniSysAI/Server/tree/0.0.2)
[![UPCOMING RELEASE](https://img.shields.io/badge/UPCOMING%20RELEASE-0.0.3-blue.svg)](https://github.com/GeniSysAI/Server/tree/0.0.3)

# About GeniSys AI
GeniSys AI is an open source Artificial Intelligence Assistant Network using Computer Vision, Natural Linguistics and the Internet of Things. GeniSys uses a system based on [TASS A.I](https://github.com/TASS-AI/TASS-Facenet "TASS A.I") for [vision](https://github.com/GeniSysAI/Vision "vision"), an [NLU engine](https://github.com/GeniSysAI/NLU "NLU engine") for natural language understanding, in browser speech synthesis and speech recognition for speech and hearing, all homed on a dedicated Linux server in your home and managed via a secure UI.

# About GeniSys AI Server
[GeniSys AI Server](https://github.com/GeniSysAI/Server "GeniSys AI Server") is a customisable management system for [GeniSys AI](https://github.com/GeniSysAI/Server "GeniSys AI") networks. The GeniSys management system is built on top of [Ubuntu 18.04.1 LTS (Bionic Beaver)](http://releases.ubuntu.com/18.04/ "Ubuntu 18.04.1 LTS (Bionic Beaver)"), but there should be no issues using other Linux operating systems. The server uses a secure PHP/MySql Nginx server, [Let’s Encrypt](https://letsencrypt.org/ "Let’s Encrypt") for free SSL encryption, and free IoT connectivity via the [iotJumpWay](https://www.iotJumpWay.tech "iotJumpWay").

[![GeniSys AI Server](Media/Images/GeniSysHome.jpg)](https://github.com/GeniSysAI/Server)

Although the completed GeniSys Server will be accessible via the outside world, this is only to help ensure encrypted traffic over your local network. The Nginx server will proxy traffic to your internal IPs for features such as the local NLU, the local TASS system is designed to access the local camera of the device the program is running on.

[![GeniSys AI Server](Media/Images/GeniSysDashboard.jpg)](https://github.com/GeniSysAI/Server)

# What Will We Do?
This tutorial will help you setup the server required for your GeniSys network, and also takes you through setting up iotJumpWay devices and applications. In detail this guide will cover the following:

- Installation: Ubuntu 18.04, Nginx, Let's Encrypt, PHP, MySql, phpMyAdmin, UFW, iotJumpWay
- Setup: Nginx, PHP, MySql, phpMyAdmin, IPTables, iotJumpWay, Domain name & DNS configuration, router port forwarding, UFW security, Device Proxies

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
 $ sudo certbot --nginx
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
 $ sudo ufw allow 80
 $ sudo ufw allow 443
```

Finally start and check the status

```
 $ sudo ufw enable
 $ sudo ufw status
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

and match the [example default configuration](https://github.com/GeniSysAI/Server/blob/master/etc/nginx/sites-available/default "example default configuration"), replacing **YourSubdomain.YourDomain.TLD** where relevant and updating the endpoint names. Once you have completed those steps, issue the following commands which will tell you if the configuration is ok and if so you can reload Nginx. 

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

![GeniSys AI Server PHP config](Media/Images/PHP.jpg)

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
First you can download the [basic database structure](https://github.com/GeniSysAI/Server/blob/requirements/database.sql "basic database structure") required for the GeniSys server, this structure will change frequently along with the rest of the project so you should keep an eye out for important changes. 

Once you are logged in to phpMyAdmin, visit the import tab and import the sql file you just download and import it into the database you created earlier in the tutorial. 

# Install iotJumpWay
Now you need to install the iotJumpWay and setup some appications and devices. The following part of the tutorial will guide you through this. 

- [Find out about the iotJumpWay](https://www.iotjumpway.tech/how-it-works "Find out about the iotJumpWay") 
- [Find out about the iotJumpWay Dev Program](https://www.iotjumpway.tech/developers/ "Find out about the iotJumpWay Dev Program") 
- [Get started with the iotJumpWay Dev Program](https://www.iotjumpway.tech/developers/getting-started "Get started with the iotJumpWay Dev Program") 

[![iotJumpWay](Media/Images/iotJumpWayApplication.jpg)](https://www.iotJumpWay.tech/console)

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
- You can copy the entire contents of the [Server/Media/Images/var/www](https://github.com/GeniSysAI/Server/tree/Media/Images/var/www  "Server/Media/Images/var/www") directory to the /var/www directory on your server.

# Extensions
The GeniSys Server is only the hub of the GeniSys network. Through the UI you can manage various aspects of your AI network including the local NLU Engine and TASS system, as well as other AI / IoT smart home devices. 

## Local NLU Engine
After following the [GeniSys NLU Engine](https://github.com/GeniSysAI/NLU "GeniSys NLU Engine") tutorial you will be able to manage,sss train and infer using the UI. 

## Local TASS Engine
After following the [GeniSys TASS Engine](https://github.com/GeniSysAI/Vision "GeniSys TASS Engine") tutorial you will be able to manage, train and infer using the UI.

## Future Extensions
Further extensions are planned / under development including a management system for the IDC Classifier ([Breast Cancer AI](https://www.facebook.com/BreastCancerAI "Breast Cancer AI")) & the AML Classifier ([Peter Moss Acute Myeloid Leukemia Research Project](https://www.facebook.com/AMLResearchProject/ "Peter Moss Acute Myeloid Leukemia Research Project")).

# Update Configuration
Now it is time to update our server configuration. Open the [/var/www/classes/startup/confs.json](https://github.com/GeniSysAI/Server/blob/var/www/classes/startup/confs.json  "/var/www/classes/startup/confs.json") file on your server and add your database credentials, your iotJumpWay application credentials, iotJumpWay location ID and Application MQTT credentials. You will use your iotJumpWay application credentials to authenticate yourself onto the UI.  

# Voice Recognition
It is now possible to interact with GeniSys using your voice. This feature is powered by an open source project [annyang](https://github.com/TalAter/annyang "annyang") which is basically a wrapper for the voice recognition feature of the web speech API, according to  [caniuse](https://caniuse.com/#feat=speech-synthesis "caniuse") support seems to be finally much wider including: Edge, Firefox, Chrome, Safari, ios Safari, Chrome for Android and Samsung Internet, but I have not tested anything other than Chrome. In Chrome for Android an alert noise is made every time the voice recognition restarts, this is unavoidable and there has been a long time developer request for Google to remove this feature but Google are adimant that it will remain. 

If you have updated your server code and booted up the server you should get asked for permissions to use the microphone, once you accept you will be able to speak to your NLU providing the NLU is online.

# Contributing
Please read [CONTRIBUTING.md](https://github.com/GeniSysAI/Vision/blob/master/CONTRIBUTING.md "CONTRIBUTING.md") for details on our code of conduct, and the process for submitting pull requests to me.

# Versioning
I use SemVer for versioning. For the versions available, see [GeniSysAI/Server/releases](https://github.com/GeniSysAI/Server/releases "GeniSysAI/Server/releases").

# License
This project is licensed under the **MIT License** - see the [LICENSE](https://github.com/GeniSysAI/Server/blob/master/LICENSE "LICENSE") file for details.

# Bugs/Issues
I use the [repo issues](https://github.com/GeniSysAI/Server/issues "repo issues") to track bugs and general requests related to using this project. 

# About The Author
Adam is a [BigFinite](https://www.bigfinite.com "BigFinite") IoT Network Engineer, part of the team that works on the core IoT software. In his spare time he is an [Intel Software Innovator](https://software.intel.com/en-us/intel-software-innovators/overview "Intel Software Innovator") in the fields of Internet of Things, Artificial Intelligence and Virtual Reality.

[![Adam Milton-Barker: BigFinte IoT Network Engineer & Intel® Software Innovator](Media/Images/Adam-Milton-Barker.jpg)](https://github.com/AdamMiltonBarker)


