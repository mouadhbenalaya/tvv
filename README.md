Tamkeen skeleton app
=====================

# 1. Setup Tamkeen Skeleton

## Docker & General setup

- create "Personal Access Token" on GitLab (https://code.tamkeen.cloud/-/profile/personal_access_tokens)
- scope of the token should be read_registry

- create your own copy od docker-compose.yml file and boot up docker containers
- skip the `-d` switch if you want to see container outputs (handy for debugging)

#### Before running docker commands add this to your shell startup file (.zshrc or .bashrc for example):

```bash
export DOCKER_UID=$(id -u)
export DOCKER_GID=$(id -g)
```

## Makefile based setup

By default PHP8.1 is used. If you want to use older version, just export environment variable and different version will
be used. e.g.

```
export PHP_VERSION=8.1
```

To speed up things a bit, you can just enter this one/liner and set up the whole project:

```bash
git clone --branch development https://code.tamkeen.cloud/tvtc-private-training/backend/base-app.git base-app && cd base-app && make install
```

---
**NOTE**

- Please keep in mind to replace the default `base-app` directory name with your own.
- To store git credentials on disk, please use `git-credential-store` command (https://git-scm.com/docs/git-credential-store#_examples)


---

For more `make` commands type `make` to get help.

## Manual setup

Clone this repository on your development machine:

```bash
git clone --branch development https://code.tamkeen.cloud/tvtc-private-training/backend/base-app.git base-app
cd base-app
```

---
**NOTE**

- Please keep in mind to replace the default `base-app` directory name with your own.
- To store git credentials on disk, please use `git-credential-store` command (https://git-scm.com/docs/git-credential-store#_examples)

---

Copy `docker-compose.yml.dist` to `docker-compose.yml` and `.env.dev` to `.env`, set custom variables and spin up the
containers:

```bash
$ cp .env.local .env
$ cp docker-compose.yml.dist docker-compose.yml
$ docker-compose up -d
```

Enter the `php` container and use the built-in helper for running common tasks:

```bash
docker exec -it tamkeen_php /bin/bash
qsetup
```

Or you can set up the project manually:

```bash
$ docker exec tamkeen_php composer install
```

This will create your own copy of docker-compose.yml file that you can change to your liking (i.e. if you want
to run the web server or database on a different port).  
Also, you will need the composer install command to install vendor libs, setup & configure git
hooks to enforce our coding standards.

---
**NOTE**

If this fails, try this: [https://docs.docker.com/engine/install/linux-postinstall](HERE)

---

#### Docker Registry and login

There might be a chance that docker asks you for some credentials to fetch stuff from our Q Docker registry.

Read more about it here:  
https://docs.gitlab.com/ee/user/packages/container_registry/

And then create your **personal access token** here:  
https://gitlab.q-software.com/-/profile/personal_access_tokens

## Database setup

To create the database run the migrations to create tables, foreign keys etc.
This will also create telescope table

```
$ docker-compose exec tamkeen_php php artisan migrate --seed
$ docker-compose exec tamkeen_php php artisan migrate --path=vendor/laravel/telescope/database/migrations/
```

Read more about managing your .env.local on localhost, dev, staging and production server here:
https://symfony.com/doc/current/configuration.html#selecting-the-active-environment

# 2. Coding guidelines

This is the way.

## phpstan

Git hooks will run phpstan check on all staged files on every commit and on every push. You will not be allowed
to push or commit stuff that does not match our standards. This is the way. If you want to run it manually,
just use the composer settings.

```
$ docker-compose exec tamkeen_php composer phpstan
```

Or simply, type `make phpstan`.

See `composer.json` for more details.

## csfixer

Git hooks will also run CodeStyle Fixer to make you follow our code style standars as well,
and you can always run it manually to fix things.

```
$ docker-compose exec tamkeen_php composer cs-fixer-fix
```
Or simply, type `make cs-fixer`.

Again, see `composer.json` for more details.

# 3. Components

## Authentication & Security

### 1. Header Authenticator

- used for authenticating via API
- a header with `Authorization: Bearer YOUR_TOKEN` is sent
- tokens are stored in localstorage on users computer and in the database on the app server
- supports `refreshToken`

## Command Line

There are several Laravel artisan commands developed to speed up the development. Almost all of them are written in a
developer friendly way - they will ask you for required parameters and suggest defaults. These are:

| Command                    | Description                    |
|----------------------------|--------------------------------|
| `app:email:send`           | Test sending of email          |

# 4. Entities

## User

Default user with classic email & password login. Nothing out of the ordinary. Components needed for user are:

- User entity - the Laravel model itself
- User Controller - handles all the CRUD logic for user together with encoding the password

# 5. API & Versioning

Our API setup supports classic `JSON` response (no json-ld for now), can be easily modified to support `XML` as well.
Versioning is on by default, and Laravel is architectured in a way that supports API versions. See below for details.

## CRUD API

Entity and repository should be created manually inside `app/Https/Api` directory. The following types of endpoints
should be manage inside the entity:

- Create single entity
- Retrieve single entity
- Update single entity
- Delete single entity
- List entities, with pagination, sorting and search

## Swagger

Each API endpoint needs to be well documented. See our User / Token / Tag / Author / Book / File / Gallery entities for
best practices
and examples. All Swagger documentation will be generated automatically for you. You can override the default according
to your needs inside the entity file under `#[ApiResource]`.
Follow REST API standards for naming, or our own Laravel examples.

Swagger also only supports v2 versions, so you can check our docs on the following links:

- http://localhost/docs - for v2 - only one endpoint was changed, as an example

## How to version your API

-- Need to decide what to write :)

## Deprecating old versions

First, lets get the naming straight - `.env` file has three separate parameters:

`API_UNSUPPORTED_VERSIONS` - these are the versions we no longer support (i.e. 'v1,v2')  
`API_SUNSET_VERSIONS` - these are the versions that are becoming deprecated soon, but still work to maintain some
Backwards Compatibility  
`API_LAST_VERSION` - last working version, if you're using this one, you're awesome :-)

# 6. Tests

--- Work In Progress ---
Laravel has two types of tests written so far - unit tests and feature tests. See examples inside `/tests` folder.
Want to write some tests - feel free to contact any of the authors and let's agree on what's next in line.

How to run the tests in our `/tests` folder:

```
$ docker-compose exec php vendor/bin/phpunit
```
Or simply, type `make test`.

## Feature Tests

More coming soon (TM)

## Unit Tests

Coming soon (TM).

## Captain Hooks

This additional feature is to ensure, validate or prepare your commit messages, ensure code quality or run unit tests
before you commit or push changes to git.
You can modify the default configuration `captainhooks.json` and add some script that might be helpful to check your
codes or updates before you commit and push.
It will automatically disable captainhooks.


---
**Note** : If you want to push or commit without passing the test or script on captainhooks configuration, you can add
the following command on every commit or push.

```
$ --no-verify
```

**Example**

```
$ git commit -m"messages to commit updates" --no-verify
$ git push origin BRANCH --no-verify
```

---

# 7. Postman integration

Postman is an application used for API testing. It is an HTTP client that tests HTTP requests, utilizing a graphical
user interface, through which we obtain different types of responses that need to be subsequently validated.
Q Api Platform skeleton comes with support for Postman. Just import [collection](docs/qaps.postman_collection.json) file
and the [environment variables](docs/qaps.postman_environment.json) into Postman and that's it.

There is also implemented `make` command to export Swagger documentation to Postman collection.

```
make docs
```

# 8. Tools

You can use Laravel Telescope to make performance metrics or debug your requests, exceptions, databases, cache, events
and much more
in real time by accessing a specific route in your local environment

```
http://localhost/telescope
```

# 9. Errors & reporting

## Sentry

In the .env file, you will find `SENTRY_LARAVEL_DSN` which should be updated with another one for your project.
Coming soon (TM).
