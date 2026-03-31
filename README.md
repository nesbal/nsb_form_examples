# NSB Form API Examples

A collection of small Drupal Form API examples.

## What it shows
- **Basic form**: Support ticket form with multiple fields and submit handling. (see [routing](#routing))
- **Validation form**: Permission request form with role-based and conditional validation. (see [routing](#routing))
- **AJAX form**: Workshop registration form with dependent selects, conditional fields, and live invitation preview. (see [routing](#routing))
- **Settings form**
- **Confirmation form**

## Routing

To make the forms accessible, add routes:

`nsb_form_examples.routing.yml`

```yaml
nsb_form_examples.support_ticket:
  path: '/nsb/support-ticket'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\SupportTicketForm'
    _title: 'Support Ticket'
  requirements:
    _permission: 'access content'

nsb_form_examples.permission_request:
  path: '/nsb/permission-request'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\PermissionRequestForm'
    _title: 'Permission request'
  requirements:
    _permission: 'access content'

nsb_form_examples.workshop_registration:
  path: '/nsb/workshop-registration'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\WorkshopRegistrationForm'
    _title: 'Workshop registration'
  requirements:
    _permission: 'access content'
```
