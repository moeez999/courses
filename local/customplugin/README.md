# local_customplugin

A minimal, production-safe Moodle **local** plugin scaffold.

## Features
- Adds a "Custom plugin" page under navigation (for users with `local/customplugin:view`).
- Settings page at **Site administration → Plugins → Local plugins → Custom plugin**.
- Proper capabilities, privacy provider, and renderable template.

## Dev notes
- Entry page: `/local/customplugin/index.php`
- Update version in `version.php` for upgrades.
- Add DB changes in `db/upgrade.php` following normal Moodle upgrade steps.
