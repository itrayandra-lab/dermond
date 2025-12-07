# Progress: Dermond

## Current Objective

Configurable floating chat (WhatsApp/Chatbot toggle) - COMPLETE.

## Status Snapshot

### ✅ Completed (This Session)

-   Floating chat now supports two modes via `chat.mode` site setting
-   WhatsApp mode: Green button → direct link to `wa.me/{phone}`
-   Chatbot mode: Full AI widget (preserved for future use)
-   Admin UI toggle added to Site Settings page

### ✅ Previously Completed

-   Admin panel dark theme conversion (all pages)
-   Expert quotes feature removal
-   All customer-facing pages dark theme

## Active Context (This Session)

Files modified:

-   `resources/views/components/floating-chat.blade.php` - Config toggle logic
-   `resources/views/admin/site-settings/index.blade.php` - Chat mode radio buttons
-   `database/seeders/SiteSettingSeeder.php` - Added `chat.mode` setting
-   `app/Http/Requests/SiteSettingFormRequest.php` - Added validation
-   `docs/project_bible.md` - Documented floating chat architecture

## Verification

-   `vendor/bin/pint --dirty` ✅

## Immediate Next Steps

1. Run `php artisan db:seed --class=SiteSettingSeeder` to add chat.mode setting
2. Test WhatsApp mode (ensure phone number is set in Site Settings)
3. Commit: `feat: Add configurable chat mode (WhatsApp/Chatbot toggle)`
4. Ready for next feature/task
