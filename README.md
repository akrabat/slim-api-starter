# Slim API Starter

A starter project for a Slim API application.

## Testing

1. `composer create-project akrabat/slim-api-starter my-new-api`
2. `cd my-new-api`
3. `php -d html_errors=0 -S 0.0.0.0:8888 -t public/`

Test using `curl`:

* Heartbeat: `curl http://localhost:8888/heartbeat?state=abc`
* Command: `curl -H "Authorization: token abc123" http://localhost:8888/ -d 'command=foo&param[]=bar&param[]=baz'`

## Caching the Dependency Injection Container (DIC)

To cache the DIC automatic resolution, set the `DI_COMPILATION_PATH` environment variable to a valid directory. If this
directory doesn't start with a `/`, then it will be considered relative to the root directory.

e.g.

    $ mkdir -p var/cache
    $ DI_COMPILATION_PATH='var/cache' php -d html_errors=0 -S 0.0.0.0:8888 -t public/
