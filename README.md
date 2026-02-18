# Exode

Main plugin of the Session Exode App

To build the plugin in [`dist/`](dist/) run:

```bash
composer run package
```

This script removes non-dev dependencies, archives `exode.php`, `src/`, `assets/` and 'vendor/` in `dist/exode.zip` and then reinstalls all dependencies.

## TODO

- [ ] Events
    - [ ] NextEventWidget: show the next event info
    - [ ] EventsWidget: list of all events (maybe a line to show where we stand/events happening rn)
    - [ ] Manage location through a google map link (add preview to admin form)
