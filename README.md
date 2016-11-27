Bug Tracker
===========

[![Build Status](https://travis-ci.org/resurtm/bug-tracker.svg?branch=master)](https://travis-ci.org/resurtm/bug-tracker)

How to install the project
--------------------------

1. `mkdir -p ~/dev/bug-tracker`
2. `cd ~/dev/bug-tracker`
3. `git clone git@github.com:resurtm/bug-tracker.git .`
4. `composer install`
5. Answer some questions regarding your environment.
6. `npm install`
7. Now you can launch the project.

How to run the project
----------------------

1. Change directory where you installed it before: `cd ~/dev/bug-tracker`
2. Open new terminal tab in that directory.
3. `npm run start`
4. Open another one terminal tab with the same directory.
5. `php bin/console server:run`
6. You should have three terminal tabs: one for Webpack dev server, another one for PHP dev server, and the last one to work with the project with.
7. Open your browser at URL `http://127.0.0.1:8000`
8. That's all!

How to build project for staging/prod envs
------------------------------------------

TODO: finish this section

1. `./node_modules/webpack/bin/webpack.js`

How to update the project
-------------------------

First of all:

1. `cd ~/dev/bug-tracker`
2. `git fetch --all`
3. `git pull origin master`

PHP part:

1. `cd ~/dev/bug-tracker`
2. `composer update`
3. `php bin/console security:check`

JS part:

1. `cd ~/dev/bug-tracker`
2. `sudo npm install -g npm-check-updates`
3. `npm-check-updates -u`
4. `npm install`

How to execute tests
--------------------

PHPUnit installation:

1. `cd ~/dev/bug-tracker`
2. `wget https://phar.phpunit.de/phpunit.phar`
3. `chmod a+x phpunit.phar`
4. `./phpunit.phar --version`

Running tests:

1. `cd ~/dev/bug-tracker`
2. `./phpunit.phar`

What has been used
------------------

* Webpack boilerplate project:
[jamesknelson/webpack-black-triangle](https://github.com/jamesknelson/webpack-black-triangle)
* Webpack boilerplate article:
[Webpack Made Simple: Building ES6 & LESS with autorefresh](http://jamesknelson.com/webpack-made-simple-build-es6-less-with-autorefresh-in-26-lines/)
