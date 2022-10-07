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
composer require arobases-sylius-public/sylius-professional-customer-plugin
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
```
### 8. Copy templates

#### 8.1 Copy Channel templates

Extend the Channel Admin Form template 
`vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Channel/_form.html.twig`
And Add considerTaxesForProfessionalCustomer form
```twig
{# templates/bundles/SyliusAdminBundle/Channel/_form.html.twig #}
{{ form_row(form.considerTaxesForProfessionalCustomer) }}
```

#### 8.2 Copy Customer templates

Extend the Customer Admin Form template
`vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/Customer/_form.html.twig`
And Add considerTaxesForProfessionalCustomer form
```twig
{# templates/bundles/SyliusAdminBundle/Customer/_form.html.twig #}
{{ form_row(form.isPro) }}
```

```twig
        {% if customer.isPro == true  %}
                <div class="ui segment">
                    <h4 class="ui dividing header">{{ 'arobases_sylius_professional_customer.ui.professional_information'|trans }}</h4>
                    {{ form_row(form.isProVerified) }}
                    {{ form_row(form.businessRegistrationNumber) }}
                    {{ form_row(form.socialReason) }}
                    {{ form_row(form.vatNumber) }}
                </div>
                {% if customer.filePath is not null  %}
                <div class="ui segment">
                    <h4 class="ui dividing header">{{ 'arobases_sylius_professional_customer.ui.kbis'|trans }}</h4>
                    <object type="application/pdf" width="100%" height="100%">
                        <param name="src" value="{{ asset(customer.filePath) }}" />
                        {{ 'arobases_sylius_professional_customer.ui.display_fail'|trans }}
                    </object>
                     <a href="{{ asset(customer.filePath) }}">{{ 'arobases_sylius_professional_customer.ui.download'|trans }}</a>
                </div>
                {% endif %}
        {% endif %}

```

#### 8.3 Copy Menu templates
Extend the Menu template
`vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/views/Menu/_security.html.twig`
```twig
{# templates/bundles/SyliusShopBundle/Menu/_security.html.twig #}
<div class="ui right stackable inverted menu">
    {% if is_granted('ROLE_USER') %}
        <div class="item" {{ sylius_test_html_attribute('full-name') }}>{{ 'sylius.ui.hello'|trans }} {{ app.user.customer.fullName }}!</div>
            {% if true == app.user.customer.isPro %}
                    <a href="{{ path('sylius_shop_account_dashboard') }}" class="item">{{ 'arobases_sylius_professional_customer.ui.my_account'|trans }}</a>
            {% else %}
                    <a href="{{ path('sylius_shop_account_dashboard') }}" class="item">{{ 'sylius.ui.my_account'|trans }}</a>
            {% endif %}
        <a href="{{ path('sylius_shop_logout') }}" class="item sylius-logout-button" {{ sylius_test_html_attribute('logout-button') }}>{{ 'sylius.ui.logout'|trans }}</a>
    {% else %}
        <a href="{{ path('sylius_shop_login') }}" class="item">{{ 'sylius.ui.login'|trans }}</a>
        <a href="{{ path('sylius_shop_register') }}" class="item">{{ 'sylius.ui.register'|trans }}</a>
        <a href="{{ path('sylius_pro_shop_register') }}" class="item">{{ 'arobases_sylius_professional_customer.ui.register'|trans }}</a>
    {% endif %}
</div>
```
