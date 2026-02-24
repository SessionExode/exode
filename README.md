# Exode

Main plugin of the Session Exode App

To build the plugin in [`dist/`](dist/) run:

```bash
composer run package
```

This script removes non-dev dependencies, archives `exode.php`, `src/`, `assets/` and 'vendor/` in `dist/exode.zip` and then reinstalls all dependencies.

## TODO

- [x] Buvette
    - [x] Add icon size control
- [ ] Word of The Day
    - [ ] Just do it
    - [ ] Global config through admin panel
- [ ] Events
    - [ ] NextEventWidget: show the next event info
    - [ ] NextEventWidget: date/time in one control.
    - [ ] AllEventsWidget: list of all events (maybe a line to show where we stand/events happening rn)
    - [ ] Manage location through a Google Maps link (add preview to admin form)
- [x] Verse of the Day custom element
- [ ] Long term
    - [ ] Remove duplicate "Exode" menu (main menu + submenu) in admin view
    - [ ] Write all French translations in [`lang/exode-fr\_FR.po`](lang/exode-fr_FR.po)
