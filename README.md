# Exode

Main plugin of the Session Exode App

To build the plugin in [`dist/`](dist/) run:

```bash
composer run package
```

This script removes non-dev dependencies, archives `exode.php`, `src/`, `assets/` and 'vendor/` in `dist/exode.zip` and then reinstalls all dependencies.
