WordPress Keystone 
===================

Wordpress Keystone is a WordPress boilerplate designed for quickly building effective 
[twelve-factor applications](https://12factor.net/) 

It is built on top of many existing projects:
- [Laradock](https://github.com/laradock/laradock) (docker setup)
- [Sage](https://github.com/roots/bedrock) - Architecture and Webpack
- [Bedrock](https://github.com/roots/bedrock) - Architecture
- [Laravel components](https://github.com/mattstauffer/Torch)
- [Wordhat](https://github.com/paulgibbs/behat-wordpress-extension/)
- [WP Function Me](http://www.wpfunction.me/)

Setup
-------------

#### **Environment**

This project utilizes docker for all its local development. 

Before starting the setup make sure you have:
- [docker](https://www.docker.com/)
- [docker proxy](https://4mation.atlassian.net/wiki/display/PD/Docker+Proxy) 
```
docker network create -d bridge proxy
docker run -d --name proxy -p 80:80 --network="proxy" -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
```
- [yarn](https://yarnpkg.com/en/) `npm install -g yarn`
- [wp-cli](http://wp-cli.org/#installing) `curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar`


#### **Boilerplate Instructions**

First Run a search & replace for the following:
 - Your site url: `local.wp-keystone` -> local.your-domain
 - Your project title: `Wordpress Keystone` -> Your Project Name
 - Your project slug (docker): `wp-keystone` -> your-project-slug 
 
Then delete this section from the readme.

#### **Instructions**
Local Setup
1. Copy over the env file `cp -n env/.env.local .env`
2. Copy over the htaccess `cp -n web/.htaccess.local web/.htaccess`
3. Setup docker containers `docker-compose up -d`
4. Setup your hosts file. `sudo sh -c 'echo "127.0.0.1       local.wp-keystone" >> /etc/hosts'`
5. Mount yourself to the workspace `./env/mount-workspace.sh`
6. Run the deployment script `composer build`


Development 
-------------

#### **Docker**

This project uses a docker container which will host our site for us and be able to build all of our assets for us. Some useful commands:
- `docker-compose restart` - Restart the container
- `docker exec -it project-slug bash` - Attach yourself to the container

#### **Plugins**

All 3rd party plugins are ideally included via composer within the `composer.json` file. For finding plugins check out the [wpackagist](https://wpackagist.org/). 
If you are working on a custom plugin checkout the plugin boilerplate that's available [here](https://bitbucket.org/harlan_wilton/plugin-boilerplate/overview).

#### **WP-CLI**

If you setup your ssh credentials in the `wp-cli.yml` file you are able to alias your environments and perform commands on them! Below are a few handy commands.

#### **Migrations**

Copy live data to your local environment
`wp @live db export - | wp @local db import -`


Testing 
-------------

#### **Automated Testing**

Automated tested is setup using behat. To get it working properly you need to run a selenium server which 
has been supplied in the form of a composer package. For this to work you'll need to copy over
the drivers. This has to be done outside of docker at the moment. 

1. Run the server `composer selenium`
2. Run tests `composer test`


Deployment
-------------

#### **ElasticBeanstalk**

This boilerplate comes equipped with boilerplate configuration files for deployment to ElasticBeanstalk. It leverages 
BitBucket Pipelines to build the application, package it, upload it to an S3 bucket and then deploy it to ElasticBeanstalk.

By default the `bitbucket-pipelines.yml` file lints and builds the application for testing purposes.
Replace it with the `bitbucket-pipelines.yml.elastic-beanstalk.sample` file to deploy to ElasticBeanstalk. As specified
within the file, you need to set the BitBucket Pipelines environment variables for the deployment environment to 
successfully deploy to your ElasticBeanstalk setup.
