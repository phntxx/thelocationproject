# thelocationproject

##requirements
- a web server (thelocationproject was developed with apache2)
- php5
- MySQL

##installation

1. installing php5 and MySQL

```
sudo apt-get install mysql-server php5 php5-mysql -y
```

when asked for a password, enter a random password and remember it; it's required later on

2. installing a webserver

- apache2 (PROVEN TO WORK)

```
sudo apt-get libapache2-mod-php5 apache2 -y
```

- lighttpd (MIGHT NOT WORK)

```
sudo apt-get install lighttpd php5-cgi -y
sudo nano /etc/lighttpd/lighttpd.conf
```

add this line under "server.modules":

```
"mod_fastcgi",
```

and this line at the end:

```
fastcgi.server = ( ".php" => ((
                    "bin-path" => "/usr/bin/php-cgi",
                    "socket" => "/tmp/php.sock"
                )))
```

### you also need to configure https, please follow a tutorial on how to do that.

3. configuring MySQL

```
mysql -uroot -p<YOUR PASSWORD FROM EARLIER>
create database thelocationproject_data;

CREATE TABLE `users` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `newsfeed` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `headline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `comments` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `related_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

exit;
```

4. cloning the repository

```
git clone https://github.com/phntxx/thelocationproject
```

move the directory to the main directory of your webserver

```
mv thelocationproject /var/www/html
```

5. accessing your installation:

- open your webbrowser and go to https://<THE IP-ADDRESS OF THE SERVER YOU INSTALLED THIS ON>/thelocationproject/

###done.

## Troubleshooting

If you're having trouble installing thelocationproject, please tell me about it in the issues-tab.
