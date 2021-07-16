<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">ArobasesSyliusProfessionalCustomerPlugin</h1>

<p align="center">Skeleton for starting Sylius plugins.</p>

## Documentation

For a comprehensive guide on Sylius Plugins development please go to Sylius documentation,
there you will find the <a href="https://docs.sylius.com/en/latest/plugin-development-guide/index.html">Plugin Development Guide</a>, that is full of examples.

## Quickstart Installation

### 1. Require plugin with composer:
```sh
composer require arobases/sylius-professional-customer-plugin
```
### 3. Import configuration:
```yml
#config/packages/arobases_sylius_professional_customer.yaml
imports:
    - { resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/config.yaml" }
```

### 4. Import routing:
```yml
# config/routes.yaml
arobases_sylius_professional_customer_shop:
    resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/shop_routing.yml"
    prefix: /{_locale}
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$

arobases_sylius_professional_customer_admin:
    resource: "@ArobasesSyliusProfessionalCustomerPlugin/Resources/config/admin_routing.yml"
    prefix: /admin

```
### 5. Add plugin class to your bundles.php:
```php
$bundles = [
    // ...
    Arobases\SyliusProfessionalCustomerPlugin\ArobasesSyliusProfessionalCustomerPlugin::class => ['all' => true],
    // ...
];
```
### 5. Use CustomerTrait and CustomerInterface:
```php
<?php

//src/Entity/Customer/Customer.php

declare(strict_types=1);

namespace App\Entity\Customer;

use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\CustomerTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    use CustomerTrait;
}

```
### 6. Use ChannelTrait and ChannelInterface:

```php

<?php
//src/Entity/Channel/Channel.php

declare(strict_types=1);

namespace App\Entity\Channel;

use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelInterface;
use Arobases\SyliusProfessionalCustomerPlugin\Model\ChannelTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements ChannelInterface
{
    use ChannelTrait;
}
```
### 7. Update the schema

```bash
php bin/console doctrine:schema:update --force