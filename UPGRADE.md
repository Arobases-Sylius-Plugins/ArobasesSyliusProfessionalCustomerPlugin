# UPGRADE FROM `2.x` TO `3.0` (Sylius 1.14)

* Requires Sylius `~1.14.0` and PHP 8.2 or 8.3.
* The model traits are now mapped with Doctrine attributes (annotations are kept), you can switch your
  `Customer` and `Channel` entities to attributes.
* The template overrides described in the previous README (`SyliusAdminBundle/Customer/_form.html.twig`,
  `SyliusAdminBundle/Channel/_form.html.twig`, `SyliusShopBundle/Menu/_security.html.twig`) are no longer needed:
  the plugin now uses Sylius template events. Remove your overrides, or keep them and disable the plugin blocks
  in `sylius_ui.events`.
* `OrderTaxesProcessor` and `MailerListener` now decorate the Sylius services and delegate to them instead of
  replacing them. Their constructors changed accordingly.
* `CustomerProAcceptedListener` and `CustomerProVerifiedListener` no longer take the customer repository.
* `CustomerProKbisListener::preUpdate()` has been removed (it was not used).
* KBIS files are now stored in `public/userfiles/kbis/` (they were stored in `public/userfiles/` with a `kbis` prefix
  in their name). Existing files keep working since their path is saved on the customer.
* The routes use the `service::method` controller notation required by Symfony 6.
