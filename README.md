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

Update with your local details and use the following to import and export the wordpress database

Dump wordpress

```
MYSQL_PWD=[password] mysqldump -u base wordpress_base > ./data/sql/wordpress_base.sql
```

Import wordpress

```
MYSQL_PWD=[password] mysql -u base wordpress_base < ./data/sql/wordpress_base.sql
```

## Repository configuration

### Namesace

Update the composer.json with your namespace

```
"autoload": {
    "psr-4": {
        "Ceremium\\WordpressBaseTemplate\\": "src/"
    }
},
```