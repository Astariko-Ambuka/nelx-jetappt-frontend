<?php
/**
 * AJAX Handlers Class - Handles all AJAX requests
 */

if (!defined('ABSPATH')) exit;

class NELXJAF_Ajax_Handlers {
    
    private static $instance = null;
    private $option_name = 'nelx_jetappt_settings';
    private $google_meet_option_name = 'nelx_google_meet_settings';
    private $email_branding_option_name = 'nelx_email_branding_settings';
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('wp_ajax_nelx_jetappt_load_jfb_fields', [$this, 'load_jfb_form_fields']);
        add_action('wp_ajax_nelx_save_jetappt_settings', [$this, 'save_settings']);
        add_action('wp_ajax_nelx_jetappt_get_jfb_fields', [$this, 'get_jfb_fields']);
        add_action('wp_ajax_nelx_test_appointment_automation', [$this, 'test_appointment_automation']);
        add_action('wp_ajax_nelx_save_notifications_settings', [$this, 'save_notifications_settings']);
        add_action('wp_ajax_nelx_save_automation_settings', [$this, 'save_automation_settings']);
        add_action('wp_ajax_nelx_manual_delete_past_appointments', [$this, 'manual_delete_past_appointments']);
        add_action('wp_ajax_nelx_manual_delete_canceled_appointments', [$this, 'manual_delete_canceled_appointments']);
    }
    
    public function load_jfb_form_fields() {
        if (!check_ajax_referer('nelx_jetappt_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => __('Security check failed - Invalid nonce', 'nelx-jetappt-frontend')]);
            return;
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'nelx-jetappt-frontend')]);
        }
        
        $form_id = isset($_POST['form_id']) ? absint(wp_unslash($_POST['form_id'])) : 0;
        
        if (!$form_id) {
            wp_send_json_error(['message' => __('Invalid form ID', 'nelx-jetappt-frontend')]);
            return;
        }
        
        if (!function_exists('jet_form_builder') && !class_exists('\Jet_Form_Builder\Plugin')) {
            wp_send_json_error(['message' => __('JetFormBuilder plugin is not active', 'nelx-jetappt-frontend')]);
            return;
        }
        
        $fields = NELXJAF_JFB_Field_Helper::get_form_fields($form_id);
        
        if (empty($fields)) {
            wp_send_json_error(['message' => __('No fields found for this form', 'nelx-jetappt-frontend')]);
            return;
        }
        
        $form_title = get_the_title($form_id);
        
        wp_send_json_success([
            'fields' => $fields,
            'form_title' => $form_title
        ]);
    }
    
    public function save_settings() {
        if (!check_ajax_referer('nelx_jetappt_nonce', 'nonce', false)) {
            wp_send_json_error(__('Security check failed.', 'nelx-jetappt-frontend'));
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'nelx-jetappt-frontend'));
        }
        
        $current_settings = get_option($this->option_name, []);
        
        if (isset($_POST['data']) && is_array($_POST['data'])) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $post_data = wp_unslash($_POST['data']);
            parse_str($post_data, $form_data);
            
            if (isset($form_data[$this->option_name])) {
                $sanitized = NELXJAF_Settings_Sanitizer::sanitize_settings($form_data[$this->option_name]);
                $current_settings = array_merge($current_settings, $sanitized);
            }
        }
        
        if (isset($_POST['default_templates'])) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $default_templates = json_decode(wp_unslash($_POST['default_templates']), true);
            if (is_array($default_templates)) {
                $current_settings['default_email_templates'] = [];
                foreach ($default_templates as $index => $template) {
                    $current_settings['default_email_templates'][$index] = [
                        'name' => sanitize_text_field($template['name']),
                        'form_id' => absint($template['form_id']),
                        'email_settings' => NELXJAF_Settings_Sanitizer::sanitize_email_settings($template['email_settings'])
                    ];
                }
            }
        }
        
        if (isset($_POST['custom_templates'])) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $custom_templates = json_decode(wp_unslash($_POST['custom_templates']), true);
            if (is_array($custom_templates)) {
                $current_settings['custom_email_templates'] = [];
                foreach ($custom_templates as $index => $template) {
                    $current_settings['custom_email_templates'][$index] = [
                        'name' => sanitize_text_field($template['name']),
                        'form_id' => absint($template['form_id']),
                        'email_settings' => NELXJAF_Settings_Sanitizer::sanitize_email_settings($template['email_settings'])
                    ];
                }
            }
        }
        
        $result = update_option($this->option_name, $current_settings);
        
        if ($result) {
            wp_send_json_success(__('Settings saved successfully!', 'nelx-jetappt-frontend'));
        } else {
            wp_send_json_error(__('No changes were made or failed to save.', 'nelx-jetappt-frontend'));
        }
    }
    
    public function save_notifications_settings() {
        if (!check_ajax_referer('nelx_jetappt_nonce', '_wpnonce', false)) {
            wp_send_json_error(__('Security check failed.', 'nelx-jetappt-frontend'));
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'nelx-jetappt-frontend'));
        }
        
        $current_settings = get_option($this->option_name, array());
        
        if (isset($_POST['nelx_jetappt_settings'])) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $new_settings = wp_unslash($_POST['nelx_jetappt_settings']);
            
            $current_settings['notifications_enabled'] = isset($new_settings['notifications_enabled']) ? '1' : '0';
            $current_settings['provider_appointments_page'] = isset($new_settings['provider_appointments_page']) ? esc_url_raw($new_settings['provider_appointments_page']) : '';
            $current_settings['client_appointments_page'] = isset($new_settings['client_appointments_page']) ? esc_url_raw($new_settings['client_appointments_page']) : '';
            
            $result = update_option($this->option_name, $current_settings);
            
            if ($result !== false) {
                wp_send_json_success(__('Notifications settings saved!', 'nelx-jetappt-frontend'));
            } else {
                $check_settings = get_option($this->option_name, array());
                if ($check_settings['notifications_enabled'] === $current_settings['notifications_enabled'] &&
                    $check_settings['provider_appointments_page'] === $current_settings['provider_appointments_page'] &&
                    $check_settings['client_appointments_page'] === $current_settings['client_appointments_page']) {
                    wp_send_json_success(__('Settings are up to date.', 'nelx-jetappt-frontend'));
                } else {
                    wp_send_json_error(__('Failed to save settings. Database error occurred.', 'nelx-jetappt-frontend'));
                }
            }
        } else {
            wp_send_json_error(__('No settings data received.', 'nelx-jetappt-frontend'));
        }
    }
    
    public function save_automation_settings() {
        if (!check_ajax_referer('nelx_jetappt_nonce', '_nelx_wpnonce', false)) {
            wp_send_json_error(__('Security check failed.', 'nelx-jetappt-frontend'));
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'nelx-jetappt-frontend'));
        }
        
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $post_data = isset($_POST['data']) ? wp_unslash($_POST['data']) : '';
        parse_str($post_data, $form_data);
        
        $current_settings = get_option($this->option_name, []);
        
        if (isset($form_data[$this->option_name])) {
            $new_settings = $form_data[$this->option_name];
            
            $current_settings['auto_delete_past'] = isset($new_settings['auto_delete_past']) ? '1' : '0';
            $current_settings['auto_delete_past_days'] = isset($new_settings['auto_delete_past_days']) ? sanitize_text_field($new_settings['auto_delete_past_days']) : '7';
            $current_settings['auto_delete_past_custom'] = isset($new_settings['auto_delete_past_custom']) ? intval($new_settings['auto_delete_past_custom']) : '';
            $current_settings['auto_delete_canceled'] = isset($new_settings['auto_delete_canceled']) ? '1' : '0';
            $current_settings['reminder_timing'] = isset($new_settings['reminder_timing']) ? sanitize_text_field($new_settings['reminder_timing']) : '24';
            
            $result = update_option($this->option_name, $current_settings);
            
            if ($result) {
                wp_send_json_success(__('Automation settings saved!', 'nelx-jetappt-frontend'));
            } else {
                wp_send_json_error(__('Failed to save settings.', 'nelx-jetappt-frontend'));
            }
        } else {
            wp_send_json_error(__('Invalid data received.', 'nelx-jetappt-frontend'));
        }
    }
    
    public function get_jfb_fields() {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $nonce = isset($_POST['nonce']) ? wp_unslash($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'nelx_jetappt_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'nelx-jetappt-frontend')]);
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'nelx-jetappt-frontend')]);
        }
        
        $form_id = isset($_POST['form_id']) ? absint(wp_unslash($_POST['form_id'])) : 0;
        
        if (!$form_id) {
            wp_send_json_error(['message' => __('Invalid form ID.', 'nelx-jetappt-frontend')]);
        }
        
        if (class_exists('NELXJAF_JFB_Field_Helper')) {
            $fields = NELXJAF_JFB_Field_Helper::get_form_fields($form_id);
        } else {
            $fields = [];
        }
        
        if (empty($fields)) {
            wp_send_json_error(['message' => __('No fields found in this form.', 'nelx-jetappt-frontend')]);
        }
        
        wp_send_json_success(['fields' => $fields]);
    }
    
    public function test_appointment_automation() {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $nonce = isset($_POST['nonce']) ? wp_unslash($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'nelx_jetappt_nonce')) {
            wp_send_json_error(['message' => __('Security check failed.', 'nelx-jetappt-frontend')]);
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => __('Permission denied.', 'nelx-jetappt-frontend')]);
        }
        
        $debug_log = ABSPATH . 'nelx-cron-debug.log';
        $cron_output_log = ABSPATH . 'cron-output.log';
        
        $cron_found = false;
        $last_run = null;
        $log_content = '';
        
        if (file_exists($debug_log)) {
            $cron_found = true;
            $last_run = gmdate('Y-m-d H:i:s', filemtime($debug_log));
            $log_content = file_get_contents($debug_log);
            $log_lines = explode("\n", $log_content);
            $log_content = implode("\n", array_slice($log_lines, -20));
        }
        
        if (file_exists($cron_output_log)) {
            $cron_found = true;
            if (!$last_run) {
                $last_run = gmdate('Y-m-d H:i:s', filemtime($cron_output_log));
            }
        }
        
        if ($cron_found) {
            wp_send_json_success([
                'message' => __('Cron job is running!', 'nelx-jetappt-frontend'),
                'log_details' => [
                    'last_run' => $last_run,
                    'log_content' => $log_content
                ],
                'log' => sprintf(
                    /* translators: %s: timestamp of last cron run */
                    __('Cron last executed at: %s', 'nelx-jetappt-frontend'),
                    $last_run
                )
            ]);
        } else {
            wp_send_json_error([
                'message' => __('Cron job not detected. Please add the cron command to your crontab.', 'nelx-jetappt-frontend'),
                'log_details' => [
                    'expected_log_file' => $debug_log,
                    'expected_output_file' => $cron_output_log
                ],
                'log' => __('No cron execution detected. The cron handler has never run.', 'nelx-jetappt-frontend')
            ]);
        }
    }
    
    private function run_automation_test() {
        global $wpdb;
        $options = get_option($this->option_name);
        $appt_table = $wpdb->prefix . ($options['appt_table'] ?? 'jet_appointments');
        
        $results = [
            'reminders' => 0,
            'past_appointments' => 0,
            'canceled_appointments' => 0
        ];
        
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
        $sql = $wpdb->prepare("SHOW TABLES LIKE %s", $appt_table);
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        if ($wpdb->get_var($sql) !== $appt_table) {
            return $results;
        }
        
        $reminder_timing = $options['reminder_timing'] ?? '24';
        $reminder_seconds = intval($reminder_timing) * HOUR_IN_SECONDS;
        
        if ($reminder_seconds > 0) {
            $current_time = current_time('timestamp');
            $target_time = $current_time + $reminder_seconds;
            $target_window_start = $target_time - (7.5 * MINUTE_IN_SECONDS);
            $target_window_end = $target_time + (7.5 * MINUTE_IN_SECONDS);
            
            $target_start_date = gmdate('Y-m-d H:i:s', $target_window_start);
            $target_end_date = gmdate('Y-m-d H:i:s', $target_window_end);
            
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $results['reminders'] = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$appt_table} 
                 WHERE (date BETWEEN %s AND %s OR slot BETWEEN %s AND %s)
                 AND appointment_status = 'accepted'",
                $target_start_date, $target_end_date, $target_start_date, $target_end_date
            ));
        }
        
        $auto_delete_past = $options['auto_delete_past'] ?? '0';
        if ($auto_delete_past === '1') {
            $days = $options['auto_delete_past_days'] ?? '7';
            if ($days === 'custom') {
                $days = $options['auto_delete_past_custom'] ?? '7';
            }
            $days = max(1, intval($days));
            $cutoff_date = gmdate('Y-m-d H:i:s', current_time('timestamp') - ($days * DAY_IN_SECONDS));
            
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $results['past_appointments'] = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$appt_table} WHERE date < %s",
                $cutoff_date
            ));
        }
        
        $auto_delete_canceled = $options['auto_delete_canceled'] ?? '0';
        if ($auto_delete_canceled === '1') {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $results['canceled_appointments'] = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$appt_table} WHERE appointment_status = %s",
                'canceled'
            ));
        }
        
        return $results;
    }
    
    public function manual_delete_past_appointments() {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $nonce = isset($_POST['nonce']) ? wp_unslash($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'nelx_jetappt_nonce')) {
            wp_send_json_error(__('Security check failed.', 'nelx-jetappt-frontend'));
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'nelx-jetappt-frontend'));
        }
        
        $days = isset($_POST['days']) ? intval(wp_unslash($_POST['days'])) : 0;
        
        if ($days < 3) {
            wp_send_json_error(__('Minimum 3 days required.', 'nelx-jetappt-frontend'));
        }
        
        global $wpdb;
        $options = get_option($this->option_name);
        $appt_table = $wpdb->prefix . ($options['appt_table'] ?? 'jet_appointments');
        
        $cutoff_timestamp = current_time('timestamp') - ($days * DAY_IN_SECONDS);
        $cutoff_date = gmdate('Y-m-d H:i:s', $cutoff_timestamp);
        
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter
        $result = $wpdb->query($wpdb->prepare(
            "DELETE FROM {$appt_table} WHERE date < %s",
            $cutoff_date
        ));
        
        if ($result !== false) {
            /* translators: %d: number of deleted appointments */
            wp_send_json_success(sprintf(__('Deleted %d past appointments.', 'nelx-jetappt-frontend'), $result));
        } else {
            wp_send_json_error(__('Error deleting past appointments.', 'nelx-jetappt-frontend'));
        }
    }
    
    public function manual_delete_canceled_appointments() {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $nonce = isset($_POST['nonce']) ? wp_unslash($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'nelx_jetappt_nonce')) {
            wp_send_json_error(__('Security check failed.', 'nelx-jetappt-frontend'));
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'nelx-jetappt-frontend'));
        }
        
        global $wpdb;
        $options = get_option($this->option_name);
        $appt_table = $wpdb->prefix . ($options['appt_table'] ?? 'jet_appointments');
        
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter
        $result = $wpdb->query($wpdb->prepare(
            "DELETE FROM {$appt_table} WHERE appointment_status = %s",
            'canceled'
        ));
        
        if ($result !== false) {
            /* translators: %d: number of deleted appointments */
            wp_send_json_success(sprintf(__('Deleted %d canceled appointments.', 'nelx-jetappt-frontend'), $result));
        } else {
            wp_send_json_error(__('Error deleting canceled appointments.', 'nelx-jetappt-frontend'));
        }
    }
}