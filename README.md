# NSB Form API Examples

A collection of small Drupal Form API examples.

## What it shows
- **Basic form**: Support ticket form with multiple fields and submit handling. (see [routing](#routing))
- **Validation form**
- **AJAX form**
- **Settings form**
- **Dynamic form**

## Routing

To display the form, define a route:

`nsb_form_examples.routing.yml`

```yaml
nsb_form_examples.support_ticket:
  path: '/support-ticket'
  defaults:
    _form: '\Drupal\nsb_form_examples\Form\SupportTicketForm'
    _title: 'Support Ticket'
  requirements:
    _permission: 'access content'
```
