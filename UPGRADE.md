# UPGRADE FROM `4.x` TO `5.0` (Sylius 2.3)

* Requires Sylius `^2.3` and PHP `^8.2`.
* The model traits are only mapped with Doctrine attributes (Doctrine ORM 3 dropped annotations):
  map your `Customer` and `Channel` entities with attributes.
* The Semantic UI templates and the Sylius 1.x template events have been replaced by Twig hooks
  (see `src/Resources/config/twig_hooks.yaml`). Template paths changed:

  | 4.x                                                    | 5.x                                                  |
  |--------------------------------------------------------|------------------------------------------------------|
  | `CustomerPro/pro_register.html.twig`                   | `shop/account/pro_register.html.twig`                |
  | `CustomerPro/Account/dashboard_pro.html.twig`          | `shop/account/pro_dashboard.html.twig`               |
  | `CustomerPro/Email/userRegistrationPro.html.twig`      | `email/user_registration_pro.html.twig`              |
  | `CustomerPro/Email/customerProConfirmation.html.twig`  | `email/customer_pro_confirmation.html.twig`          |
  | `CustomerPro/Email/adminCustomerProNotification.html.twig` | `email/admin_customer_pro_notification.html.twig` |
  | `Admin/Customer/Form/_professionalCustomer.html.twig`  | `admin/customer/form/sections/professional_customer.html.twig` |
  | `Admin/Channel/Form/_professionalCustomer.html.twig`   | `admin/channel/form/sections/professional_customer.html.twig`  |
  | `Shop/_registerAsProfessional.html.twig`               | `shop/account/register_as_professional.html.twig`    |

  Template overrides made for 4.x must be rewritten for the Sylius 2 (Bootstrap) shop and admin.
* `MailerListener` now decorates `sylius.listener.user_mailer` (`sylius.listener.user_mailer_listener` no longer
  exists) and no longer has `sendResetPasswordPinEmail()`.
* After a professional registration, the customer is redirected to the Sylius "thank you" page
  (`sylius_shop_register_thank_you`) instead of the account dashboard.
* The account menu entry uses the `tabler:briefcase` icon.
* The test application is now `sylius/test-application` (`tests/TestApplication`).
