=== Nelx JetAppointments Frontend Manager ===
Contributors: Astariko
Tags: appointments, booking, schedule, jetappointments frontend, google meet appointments
Requires at least: 6.2
Tested up to: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Front-end schedule editor, provider action buttons, collision-safe reschedule, secure delete, inline modals and available slots endpoint tailored to JetAppointments schema.

== Description ==

**Nelx JetAppointments Frontend Manager** is a powerful extension for the JetAppointments plugin that provides a complete frontend management experience for both providers and clients.

### Key Features

* **Schedule Editor** - Providers can manage their working hours, days off, and custom schedules directly from the frontend
* **Provider Action Buttons** - Confirm, reject, reschedule, and view appointment information
* **Client Action Buttons** - Reschedule, cancel, and view appointment details
* **Google Meet Integration** - Automatically create Google Meet links for online appointments
* **Email Notifications** - Send automated emails for new appointments, confirmations, cancellations, and reminders
* **In-app Notifications** - Real-time notifications for appointment events
* **Elementor Widgets** - Drag-and-drop widgets for Elementor page builder
* **REST API** - Full REST API endpoints for custom integrations

### Requirements

* WordPress 6.2 or higher
* PHP 7.4 or higher
* JetAppointments Booking plugin installed and activated

### Usage

The plugin adds several shortcodes that can be used anywhere on your site:

1. `[nelx_schedule_editor]` - Provider schedule editor
2. `[nelx_provider_action_buttons]` - Provider appointment action buttons
3. `[nelx_client_action_buttons]` - Client appointment action buttons
4. `[nelx_google_meet_settings]` - Google Meet configuration for providers

### Elementor Integration

The plugin includes Elementor widgets for easy placement:
- Schedule Editor
- Google Meet Settings
- Provider Action Buttons
- Client Action Buttons

== Installation ==

1. Upload the `nelx-jetappt-frontend` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **Nelx Appointments** in the WordPress admin menu to configure settings
4. Ensure JetAppointments plugin is installed and activated
5. Add the desired shortcodes or Elementor widgets to your pages

== Frequently Asked Questions ==

= Do I need JetAppointments to use this plugin? =

Yes, this plugin is an extension for JetAppointments and requires it to be installed and activated.

= How do I set up Google Meet integration? =

1. Go to the Google Meet settings tab in the plugin settings
2. Enter your Google API Client ID and Client Secret
3. Providers can then connect their Google accounts from the frontend

= How do email notifications work? =

The plugin sends automated emails for:
- New appointments (to providers)
- Appointment confirmations (to clients)
- Appointment cancellations (to both parties)
- Appointment rescheduling (to both parties)
- Appointment reminders (to clients)

You can customize all email templates from the settings page.

= Does this work with Elementor? =

Yes, the plugin includes Elementor widgets that can be dragged and dropped into any Elementor page.

== Changelog ==

= 1.0.0 =
* Initial release
* Schedule editor with custom working hours and days off
* Provider and client action buttons
* Google Meet integration
* Email notification system
* In-app notification system
* Elementor widgets
* REST API endpoints
* Timezone support
* Full i18n support

== Upgrade Notice ==

= 1.0.0 =
Initial release. Please read the installation instructions carefully.

== Screenshots ==

1. Schedule Editor - Manage working hours and days off
2. Provider Action Buttons - Confirm, reject, reschedule appointments
3. Client Action Buttons - Reschedule, cancel appointments
4. Google Meet Settings - Connect Google account
5. Email Templates - Customize notification emails
6. Settings Page - Configure plugin settings
