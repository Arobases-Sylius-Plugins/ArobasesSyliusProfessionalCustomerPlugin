<h1 align="center">Arobases Sylius Professional Customer Plugin</h1>

<p align="center">Allows professional (B2B) customers to register on your shop, with their company information and KBIS, and to be validated from the back office.</p>

## Features

* Professional registration page (`/{_locale}/pro_register`): SIRET / IDE, company name, VAT number and KBIS (PDF)
* "Professional information" page in the customer account
* Back office: professional fields and KBIS on the customer form, "Is professional" filter on the customer grid
* Verification of professional customers from the back office, with a confirmation email
* Email notification to the channel contact address when a professional registers
* Option per channel to not charge taxes to verified professional customers
* "Professional customer" promotion rule

## Requirements

| Plugin version | Sylius version | PHP version | Branch       |
|----------------|----------------|-------------|--------------|
| 5.x            | ^2.3           | ^8.2        | `sylius-2.3` |
| 4.x            | ~1.14.0        | 8.2 / 8.3   | `1.14`       |
| 3.x            | ^1.9           |             |              |
| 2.x            | ~1.9.0         | ^7.3        |              |

This branch is the **Sylius 1.14** version.

## Installation

### 1. Require the plugin with composer

```bash
composer require arobases-sylius-public/sylius-professional-customer-plugin:^4.0
```

### 2. Add the plugin class to your `config/bundles.php`

```php
return [
    // ...
    Arobases\SyliusProfessionalCustomerPlugin\ArobasesSyliusProfessionalCustomerPlugin::class => ['all' => true],
];
```

### 3. Import the configuration

```yaml
# config/packages/arobases_sylius_professional_customer.yaml
imports:
    - { resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/config.yaml" }
```

### 4. Import the routing

```yaml
# config/routes/arobases_sylius_professional_customer.yaml
arobases_sylius_professional_customer_shop:
    resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/shop_routing.yml"
    prefix: /{_locale}
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$

arobases_sylius_professional_customer_admin:
    resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/admin_routing.yml"
    prefix: /%sylius_admin.path_name%
```

### 5. Use `CustomerTrait` and `CustomerInterface`

```php
<?php
// src/Entity/Customer/Customer.php

declare(strict_types=1);

namespace App\Entity\Customer;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_customer')]
class Customer extends BaseCustomer implements CustomerInterface
{
    use CustomerTrait;
}
```

### 6. Use `ChannelTrait` and `ChannelInterface`

```php
<?php
// src/Entity/Channel/Channel.php

declare(strict_types=1);

namespace App\Entity\Channel;

use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
class Channel extends BaseChannel implements ChannelInterface
{
    use ChannelTrait;
}
```

The traits are mapped with both Doctrine attributes and annotations, so they work whatever the mapping type of your entities.

### 7. Update the database schema

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```

### 8. Templates

Nothing to copy: the plugin adds its blocks through Sylius template events:

| Template event                                  | Content                                              |
|-------------------------------------------------|------------------------------------------------------|
| `sylius.admin.customer.form.second_column`      | Professional fields and KBIS on the customer form    |
| `sylius.admin.channel.form.second_column_content` | "Consider taxes for professional customer" option |
| `sylius.shop.register.after_content_header`     | "Register as professional" link                      |
| `sylius.shop.login.register_column`             | "Register as professional" link                      |

They can be disabled or moved with the `sylius_ui.events` configuration (block name: `arobases_professional_customer` / `arobases_register_as_professional`).

KBIS files are stored in `public/userfiles/kbis/`.

## Development

```bash
composer install
(cd tests/Application && yarn install && yarn build)
(cd tests/Application && bin/console doctrine:database:create && bin/console doctrine:schema:create && bin/console sylius:fixtures:load -n)
vendor/bin/ecs check
vendor/bin/phpstan analyse
```
