DtBundleDemo
============

Symfony3.2 Demo Project For My DatatablesBundle v1.0 (dev-master)

## Install

### 1. Clone the project with Git:

```
git clone git@github.com:stwe/DtBundleDemo10.git
```

### 2. Install assets and dump js routing

```
php bin/console assets:install --symlink
```

```
php bin/console fos:js-routing:dump
```

### 3. Run fixtures

```
php bin/console doctrine:fixtures:load --no-interaction
```

## Login

**Admin:**

- Username: root
- Password: root

**User:**

- Username: user
- Password: user

## License

This bundle is under the MIT license. See the complete license in the bundle:

    src/AppBundle/Resources/meta/LICENSE
