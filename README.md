# NSB Form API Examples

A collection of small Drupal Form API examples. See [routing](#routing) to access the forms.

## What it shows
- **Basic form**: Support ticket form with multiple fields and submit handling.
- **Validation form**: Permission request form with role-based and conditional validation.
- **AJAX form**: Workshop registration form with dependent selects, conditional fields, and live invitation preview.
- **Settings form**: System behavior settings form using Drupal config API. (see [default config](#default-config))
- **Confirmation form**: Cancel workshop registration with confirmation flow and route parameter.

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

nsb_form_examples.settings:
  path: '/admin/config/nsb-form-examples'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\FormExamplesSettingsForm'
    _title: 'Form examples settings'
  requirements:
    _permission: 'administer site configuration'

nsb_form_examples.cancel_registration:
  path: '/nsb/cancel-registration/{name}'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\CancelRegistrationConfirmForm'
    _title: 'Cancel registration'
  requirements:
    _permission: 'access content'
```

## Default config

File: `config/install/nsb_form_examples.settings.yml`

```yaml
maintenance_message: 'Site is under maintenance.'
log_level: 'error'
api_endpoint: 'https://api.example.com'
request_timeout: 10
debug_mode: false
```
