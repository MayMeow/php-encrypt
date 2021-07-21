# Contributing 

## Docker development environment

Requre to have installed docker (Linux) or Docker desktop (Windows/macOS).

Composer install 

```bash
docker-compose -f docker-dev.yml run --rm devcontainer composer install
```

Running tests

```bash
docker-compose -f docker-dev.yml run --rm devcontainer composer run test
```