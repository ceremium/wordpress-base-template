# Wordpress Base Template

Boilerplate wordpress instance

## Setup

### Pre-requisites

#### Composer

#### MAMP

#### WP CLI

Install wordpress CLI following these instructions

https://make.wordpress.org/cli/handbook/guides/installing/

## Operations

Dump wordpress

```
MYSQL_PWD=[password] mysqldump -u jeffries wordpress_jeffries > ./data/sql/wordpress_jeffries.sql
```

Import wordpress

```
MYSQL_PWD=[password] mysql -u jeffries wordpress_jeffries < ./data/sql/wordpress_jeffries.sql
```