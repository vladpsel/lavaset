# lavaset
Laravel based web application with some basic functions. For example simple user roles, some universal migration files and other.

## Anti-toxic copyright

This is not new bicycle. This is just my own vision on Laravel web-abb. Web app with simple user-roles, notifications 
and other things. Without complication function and logic. And withour third-party packages for some features.

I create this repo only for my work and pet projects. And if some developer will serve project written by me, this repo 
should help him to understand my code and logic. Also i can develop my projects faster and maybe someone will find my preset useful.

Main idea for this repo is "pull - change setting - develop". For now this repo contains last version of Laravel (9.x.x). And i hope
I will support this preset.

## Instalation "from scratch"
 - download master branch
 - unzip files to your own directory

### If you develop with docker (optional)
 - go to "docker" directory and change .env.docker data to your own. !!!ATTENTION!! for "quickstart" youn need to
change "lavaset"-prefix in every file to your own prefix.
 - run **set -a**
 - run source .docker.env
 - run docker-compose up -d --build
 - go to php container 
 - run composer install
 - run chmod -R 777 .
 - open localhost:8080

### Setup
 - go to "project_dir/.env" and change variables to your own
 - run composer install
 - run npm install
 - use npx mix watch -- --watch-options-poll=1000
     for frontend compiler

 
## Run app in "every day" mode

### If you develop with docker (optional)
- run **set -a**
- run source .docker.env
- run docker-compose up -d
- open localhost:8080

### Default
- follow official Laravel instructions for running Laravel app


## App features and code approach

### User and user roles

This preset don`t use ["laravel-permission" by Spattie](https://spatie.be/docs/laravel-permission/v5/introduction) or some other package
for user-role feature. Because in my projects I don't need all of its functionality. 

#### Admin
Admin feature include 4 parts. 
 - 1-st part is UserPermission middleware. It includes logic for checking admin/roles rules
 - 2-nd part is in RouteServiceProvider. In this part we connect middleware with admin prefix.
 - 3-d part is in routes/admin.php this file contains all routes for admin (except admin login - this  route locate in web routes)

### If you develop with "native environment" (I mean LAMP / WAMP stack etc.)" just follow official Laravel installation and run instructions.
### Foo
