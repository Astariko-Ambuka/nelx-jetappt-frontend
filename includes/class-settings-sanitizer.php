<?php
/**
 * Settings Sanitizer Class - Handles all settings sanitization
 */

if (!defined('ABSPATH')) exit;

class NELXJAF_Settings_Sanitizer {
    
    /**
     * Sanitize main settings
     */
    public static function sanitize_settings($input) {
        $sanitized = [];
        
        // Database settings
        $db_fields = ['appt_table', 'appt_meta_table', 'provider_meta_table', 'provider_column'];
        foreach ($db_fields as $field) {
            $sanitized[$field] = isset($input[$field]) ? sanitize_text_field($input[$field]) : '';
        }
        
        // Google Meet settings
        $sanitized['google_client_id'] = isset($input['google_client_id']) ? sanitize_text_field($input['google_client_id']) : '';
        $sanitized['google_client_secret'] = isset($input['google_client_secret']) ? sanitize_text_field($input['google_client_secret']) : '';
        
        // Email branding settings
        $sanitized['email_logo_url'] = isset($input['email_logo_url']) ? esc_url_raw($input['email_logo_url']) : '';
        $sanitized['email_logo_alignment'] = isset($input['email_logo_alignment']) ? sanitize_text_field($input['email_logo_alignment']) : 'center';
        
        // Color settings
        $color_fields = [
            'email_heading_color' => '#1E3A8A',
            'email_button_color' => '#1E3A8A',
            'email_button_hover_color' => '#1a3a47',
            'email_link_color' => '#1E3A8A',
            'email_bg_color' => '#f5f5f5',
            'email_container_bg' => '#ffffff',
            'email_header_bg' => '#f9f9f9',
            'email_footer_bg' => '#f9f9f9',
            'email_footer_text_color' => '#777777'
        ];
        
        foreach ($color_fields as $field => $default) {
            $sanitized[$field] = isset($input[$field]) ? sanitize_hex_color($input[$field]) : $default;
        }
        
        // Email footer text
        $sanitized['email_footer_text'] = isset($input['email_footer_text']) ? wp_kses_post($input['email_footer_text']) : '';
        
        // Email social icons
        $sanitized['email_social_icons'] = [];
        if (isset($input['email_social_icons']) && is_array($input['email_social_icons'])) {
            foreach ($input['email_social_icons'] as $index => $icon) {
                $sanitized['email_social_icons'][$index] = [
                    'url' => isset($icon['url']) ? esc_url_raw($icon['url']) : '',
                    'icon' => isset($icon['icon']) ? esc_url_raw($icon['icon']) : ''
                ];
            }
        }
        
        // Email templates
        $sanitized['default_email_templates'] = self::sanitize_default_templates($input['default_email_templates'] ?? []);
        $sanitized['custom_email_templates'] = self::sanitize_custom_templates($input['custom_email_templates'] ?? []);
        
        // Automation settings
        $sanitized['reminder_timing'] = isset($input['reminder_timing']) ? sanitize_text_field($input['reminder_timing']) : '24';
        $sanitized['notifications_enabled'] = isset($input['notifications_enabled']) && $input['notifications_enabled'] === '1' ? '1' : '0';
        $sanitized['api_url'] = isset($input['api_url']) ? esc_url_raw($input['api_url']) : '';
        $sanitized['provider_appointments_page'] = isset($input['provider_appointments_page']) ? esc_url_raw($input['provider_appointments_page']) : '';
        $sanitized['client_appointments_page'] = isset($input['client_appointments_page']) ? esc_url_raw($input['client_appointments_page']) : '';
        $sanitized['auto_delete_past'] = isset($input['auto_delete_past']) && $input['auto_delete_past'] === '1' ? '1' : '0';
        $sanitized['auto_delete_past_days'] = isset($input['auto_delete_past_days']) ? sanitize_text_field($input['auto_delete_past_days']) : '7';
        
        $custom_days = isset($input['auto_delete_past_custom']) ? intval($input['auto_delete_past_custom']) : 0;
        $sanitized['auto_delete_past_custom'] = ($custom_days >= 1) ? $custom_days : '';
        
        $sanitized['auto_delete_canceled'] = isset($input['auto_delete_canceled']) && $input['auto_delete_canceled'] === '1' ? '1' : '0';
        
        return $sanitized;
    }
    
    /**
     * Sanitize default email templates
     */
    public static function sanitize_default_templates($templates) {
        $sanitized = [];
        if (!is_array($templates)) {
            return $sanitized;
        }
        
        foreach ($templates as $index => $template) {
            $sanitized[$index] = [
                'name' => isset($template['name']) ? sanitize_text_field($template['name']) : '',
                'form_id' => isset($template['form_id']) ? absint($template['form_id']) : 0,
                'email_settings' => self::sanitize_email_settings($template['email_settings'] ?? [])
            ];
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize custom email templates
     */
    public static function sanitize_custom_templates($templates) {
        $sanitized = [];
        if (!is_array($templates)) {
            return $sanitized;
        }
        
        foreach ($templates as $index => $template) {
            $sanitized[$index] = [
                'name' => isset($template['name']) ? sanitize_text_field($template['name']) : 'Untitled Template',
                'form_id' => isset($template['form_id']) ? absint($template['form_id']) : 0,
                'email_settings' => self::sanitize_email_settings($template['email_settings'] ?? [])
            ];
        }
        
        return $sanitized;
    }
    
    /**
     * Sanitize email settings
     */
    public static function sanitize_email_settings($settings) {
        $home_url_host = wp_parse_url(home_url(), PHP_URL_HOST);
        $default_from = get_bloginfo('name') . ' <noreply@' . $home_url_host . '>';
        
        // Allow more HTML tags for email content
        $allowed_html = wp_kses_allowed_html('post');
        $allowed_html['style'] = ['type' => true];
        $allowed_html['div'] = ['class' => true, 'style' => true];
        $allowed_html['table'] = ['class' => true, 'style' => true, 'border' => true, 'cellpadding' => true, 'cellspacing' => true];
        $allowed_html['td'] = ['class' => true, 'style' => true, 'colspan' => true];
        $allowed_html['th'] = ['class' => true, 'style' => true, 'colspan' => true];
        $allowed_html['tr'] = ['class' => true, 'style' => true];
        $allowed_html['tbody'] = ['class' => true, 'style' => true];
        $allowed_html['thead'] = ['class' => true, 'style' => true];
        $allowed_html['a'] = ['href' => true, 'title' => true, 'class' => true, 'style' => true, 'target' => true];
        
        return [
            'to' => isset($settings['to']) ? sanitize_text_field($settings['to']) : '',
            'cc' => isset($settings['cc']) ? sanitize_text_field($settings['cc']) : '',
            'bcc' => isset($settings['bcc']) ? sanitize_text_field($settings['bcc']) : '',
            'subject' => isset($settings['subject']) ? sanitize_text_field($settings['subject']) : '',
            'message' => isset($settings['message']) ? wp_kses($settings['message'], $allowed_html) : '',
            'from' => isset($settings['from']) ? self::sanitize_from_field($settings['from']) : $default_from
        ];
    }
    
    /**
     * Sanitize from field (name <email> format)
     */
    public static function sanitize_from_field($value) {
        $home_url_host = wp_parse_url(home_url(), PHP_URL_HOST);
        $default_from = get_bloginfo('name') . ' <noreply@' . $home_url_host . '>';
        
        if (empty($value)) {
            return $default_from;
        }
        
        if (preg_match('/<([^>]+)>/', $value, $matches)) {
            $email = sanitize_email($matches[1]);
            $name = trim(preg_replace('/<[^>]+>/', '', $value));
            $name = sanitize_text_field($name);
            return $email ? ($name . ' <' . $email . '>') : $default_from;
        }
        
        if (is_email($value)) {
            return sanitize_email($value);
        }
        
        return sanitize_text_field($value);
    }
}