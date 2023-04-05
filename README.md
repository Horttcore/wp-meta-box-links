# WP Meta Box Links

A WordPress meta box class for managing links

## Usage

```
<?php
use RalfHortt\MetaBoxLinks\MetaBoxLinks;

// Stand alone
(new MetaBoxLinks::class, ['post'], ['website' => __('Webseite', 'text-domain'),])->register();

// As Service
PluginFactory::create()
    ->addService(MetaBoxLinks::class, ['post'], [
        'website' => __('Webseite', 'text-domain'),
    ])
```

## Hooks

### Actions

* `wp-meta-box-links/before` - Before links
* `wp-meta-box-links/after` - After links
* `wp-meta-box-links/save` - During meta save

### Filters

* `wp-meta-box-links/identifier` - Add/remove link fields
* `wp-meta-box-links/label` - Change the label
* `wp-meta-box-links/fields` - Add fields

## ToDo

* Placeholder capabilitys
* Custom validation

## Changelog

### v1.0.0 - 2023-04-06

* Refactor

### v0.2.0

* Add capability for multiple links
* Add: Hook `wp-meta-box-links--fields` added

### v0.1.0

* Initial release
