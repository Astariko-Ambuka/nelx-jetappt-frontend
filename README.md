# Nelx JetAppointments Frontend Manager

A powerful WordPress plugin that provides a complete frontend management experience for the [JetAppointments](https://www.jetappointments.com/) booking system. Manage appointments, schedules, and notifications directly from the frontend without accessing the WordPress admin dashboard.

**Contributors:** Astariko  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html

## Features

- **Schedule Editor** - Providers can manage working hours, days off, and custom schedules from the frontend
- **Provider Action Buttons** - Confirm, reject, reschedule, and view appointment details
- **Client Action Buttons** - Reschedule, cancel, and view appointment information
- **Google Meet Integration** - Automatically generate Google Meet links for online appointments
- **Email Notifications** - Automated emails for new appointments, confirmations, cancellations, and reminders
- **In-app Notifications** - Real-time notifications for appointment events
- **Elementor Widgets** - Drag-and-drop widgets for easy page building
- **Timezone Support** - Handles client and provider timezones for accurate scheduling

## Requirements

- WordPress 6.2 or higher
- PHP 7.4 or higher
- JetAppointments Booking plugin installed and activated

## Installation

1. Upload the `nelx-jetappt-frontend` folder to `/wp-content/plugins/`
2. Activate the plugin through the **Plugins** menu in WordPress
3. Navigate to **Nelx Appointments** in the WordPress admin menu to configure settings
4. Ensure JetAppointments plugin is installed and activated
5. Add shortcodes or Elementor widgets to your pages

## Quick Start

### Using Shortcodes

Add the following shortcodes to any page or post:

```
[nelx_schedule_editor]
[nelx_provider_action_buttons]
[nelx_client_action_buttons]
[nelx_google_meet_settings]
```

### Using Elementor Widgets

1. Edit a page with Elementor
2. Search for **Nelx** in the widget finder
3. Drag and drop any of these widgets:
   - Schedule Editor
   - Provider Action Buttons
   - Client Action Buttons
   - Google Meet Settings

### Configuring Google Meet Integration

1. Go to **Nelx Appointments** → **Google Meet Settings** in the WordPress admin
2. Enter your Google API Client ID and Client Secret
3. Providers can then connect their Google accounts from the frontend

## FAQ

**Do I need JetAppointments to use this plugin?**

Yes, this plugin is an extension for JetAppointments and requires it to be installed and activated.

**How do email notifications work?**

The plugin sends automated emails for:
- New appointments (to providers)
- Appointment confirmations (to clients)
- Appointment cancellations (to both parties)
- Appointment rescheduling (to both parties)
- Appointment reminders (to clients)

You can customize all email templates from the settings page.

**Does this work with Elementor?**

Yes, the plugin includes Elementor widgets that can be dragged and dropped into any Elementor page.

## Troubleshooting

**"JetAppointments plugin is not activated"**
- Ensure the JetAppointments Booking plugin is installed and activated in WordPress admin

**Google Meet links not generating**
- Verify your Google API credentials are correctly configured
- Check that providers have authorized their Google accounts
- Ensure the provider's Google account has Google Meet access

**Emails not being sent**
- Check your WordPress mail configuration
- Verify email templates are not disabled in settings
- Check your hosting provider's email sending limits

## Changelog

### [1.0.0] - 2026-06-23

**Initial Release**

- Schedule editor with custom working hours and days off
- Provider and client action buttons
- Google Meet integration
- Email notification system
- In-app notification system
- Elementor widgets
- Timezone support
- Full i18n (internationalization) support

See [CHANGELOG.md](CHANGELOG.md) for detailed version history.

## Versioning

This project adheres to [Semantic Versioning](https://semver.org/). For version history, see [VERSIONING.md](VERSIONING.md) and [Releases](https://github.com/Astariko-Ambuka/nelx-jetappt-frontend/releases).

## License

This plugin is licensed under the GPLv2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.

## Support

For issues, questions, or feedback, please open an issue on [GitHub](https://github.com/Astariko-Ambuka/nelx-jetappt-frontend/issues).
