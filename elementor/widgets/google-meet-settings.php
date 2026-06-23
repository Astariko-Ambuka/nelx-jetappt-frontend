<?php
/**
 * Google Meet Settings Elementor Widget
 */

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Elementor_Nelx_Google_Meet_Settings extends Widget_Base {
    
    public function get_name() {
        return 'nelx_google_meet_settings';
    }
    
    public function get_title() {
        return esc_html__('Google Meet Settings', 'nelx-jetappt-frontend');
    }
    
    public function get_icon() {
        return 'eicon-video-camera';
    }
    
    public function get_categories() {
        return ['nelx-jetappt'];
    }
    
    public function get_keywords() {
        return ['google', 'meet', 'settings', 'configuration', 'calendar', 'video', 'nelx'];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'nelx-jetappt-frontend'),
            ]
        );
        
        $this->add_control(
            'notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-panel-alert elementor-panel-alert-info">' .
                    esc_html__('This widget displays Google Meet settings for providers to connect their Google account and configure meeting settings.', 'nelx-jetappt-frontend') .
                    '</div>',
            ]
        );
        
        $this->end_controls_section();
        
        // Container Style
        $this->start_controls_section(
            'section_container_style',
            [
                'label' => esc_html__('Container', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'container_background',
            [
                'label' => esc_html__('Background Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings',
            ]
        );
        
        $this->add_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings',
            ]
        );
        
        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'container_margin',
            [
                'label' => esc_html__('Margin', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Title Style
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings h3',
            ]
        );
        
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Field Style
        $this->start_controls_section(
            'section_field_style',
            [
                'label' => esc_html__('Form Fields', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field label' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-field label',
            ]
        );
        
        $this->add_control(
            'field_background',
            [
                'label' => esc_html__('Field Background', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field input' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'field_text_color',
            [
                'label' => esc_html__('Field Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field input' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-field input',
            ]
        );
        
        $this->add_control(
            'field_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'field_padding',
            [
                'label' => esc_html__('Field Padding', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'field_margin',
            [
                'label' => esc_html__('Field Margin', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-field .description' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-field .description',
            ]
        );
        
        $this->end_controls_section();
        
        // Button Style
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Buttons', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn',
            ]
        );
        
        $this->add_responsive_control(
            'button_spacing',
            [
                'label' => esc_html__('Button Spacing', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-actions' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-actions .nelx-btn' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        // Connect Button
        $this->add_control(
            'connect_button_heading',
            [
                'label' => esc_html__('Connect Button', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->start_controls_tabs('connect_button_tabs');
        
        $this->start_controls_tab(
            'connect_button_normal',
            [
                'label' => esc_html__('Normal', 'nelx-jetappt-frontend'),
            ]
        );
        
        $this->add_control(
            'connect_button_color',
            [
                'label' => esc_html__('Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'connect_button_bg',
            [
                'label' => esc_html__('Background', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'connect_button_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary',
            ]
        );
        
        $this->add_control(
            'connect_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'connect_button_hover',
            [
                'label' => esc_html__('Hover', 'nelx-jetappt-frontend'),
            ]
        );
        
        $this->add_control(
            'connect_button_hover_color',
            [
                'label' => esc_html__('Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'connect_button_hover_bg',
            [
                'label' => esc_html__('Background', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'connect_button_hover_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-primary:hover',
            ]
        );
        
        $this->end_controls_tabs();
        
        // Disconnect Button
        $this->add_control(
            'disconnect_button_heading',
            [
                'label' => esc_html__('Disconnect Button', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->start_controls_tabs('disconnect_button_tabs');
        
        $this->start_controls_tab(
            'disconnect_button_normal',
            [
                'label' => esc_html__('Normal', 'nelx-jetappt-frontend'),
            ]
        );
        
        $this->add_control(
            'disconnect_button_color',
            [
                'label' => esc_html__('Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'disconnect_button_bg',
            [
                'label' => esc_html__('Background', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'disconnect_button_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger',
            ]
        );
        
        $this->add_control(
            'disconnect_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'disconnect_button_hover',
            [
                'label' => esc_html__('Hover', 'nelx-jetappt-frontend'),
            ]
        );
        
        $this->add_control(
            'disconnect_button_hover_color',
            [
                'label' => esc_html__('Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'disconnect_button_hover_bg',
            [
                'label' => esc_html__('Background', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'disconnect_button_hover_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn.nelx-danger:hover',
            ]
        );
        
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Button Padding', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Status Style
        $this->start_controls_section(
            'section_status_style',
            [
                'label' => esc_html__('Status', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'status_success_color',
            [
                'label' => esc_html__('Success Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-status.nelx-success' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'status_warning_color',
            [
                'label' => esc_html__('Warning Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-status.nelx-warning' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'status_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-status',
            ]
        );
        
        $this->add_responsive_control(
            'status_margin',
            [
                'label' => esc_html__('Status Margin', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-status' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // Message Style
        $this->start_controls_section(
            'section_message_style',
            [
                'label' => esc_html__('Messages', 'nelx-jetappt-frontend'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'message_background',
            [
                'label' => esc_html__('Background Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-message' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'message_text_color',
            [
                'label' => esc_html__('Text Color', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-message' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'message_border',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-message',
            ]
        );
        
        $this->add_control(
            'message_border_radius',
            [
                'label' => esc_html__('Border Radius', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'message_padding',
            [
                'label' => esc_html__('Padding', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'message_margin',
            [
                'label' => esc_html__('Margin', 'nelx-jetappt-frontend'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .nelx-google-meet-settings .nelx-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'message_typography',
                'selector' => '{{WRAPPER}} .nelx-google-meet-settings .nelx-message',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if (!class_exists('NELXJAF_Google_Meet_Integration')) {
            echo '<div class="nelx-notice">' . esc_html__('Google Meet integration is not available.', 'nelx-jetappt-frontend') . '</div>';
            return;
        }
        
        if (shortcode_exists('nelx_google_meet_settings')) {
            echo do_shortcode('[nelx_google_meet_settings]');
        } else {
            $google_meet = NELXJAF_Google_Meet_Integration::instance();
            if (method_exists($google_meet, 'provider_settings_shortcode')) {
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo $google_meet->provider_settings_shortcode([]);
            } else {
                echo '<div class="nelx-notice">' . esc_html__('Google Meet settings are not available at this time.', 'nelx-jetappt-frontend') . '</div>';
            }
        }
    }
    
    protected function content_template() {
        ?>
        <div class="nelx-google-meet-settings">
            <h3><?php esc_html_e('Google Meet Settings', 'nelx-jetappt-frontend'); ?></h3>
            <div class="nelx-field">
                <label for="nelx_google_meet_email"><?php esc_html_e('Google Calendar Email', 'nelx-jetappt-frontend'); ?></label>
                <input type="email" id="nelx_google_meet_email" placeholder="your-email@gmail.com">
                <p class="description"><?php esc_html_e('This email will be used to add the meeting to your Google Calendar. Invitations will be sent to both you and the client.', 'nelx-jetappt-frontend'); ?></p>
            </div>
            <div class="nelx-actions">
                <button type="button" class="nelx-btn nelx-primary" id="nelx_connect_google">
                    <?php esc_html_e('Connect Google Account', 'nelx-jetappt-frontend'); ?>
                </button>
                <span class="nelx-status nelx-warning"><?php esc_html_e('Not connected to Google', 'nelx-jetappt-frontend'); ?></span>
            </div>
            <div class="nelx-message" style="display: none;"></div>
        </div>
        <?php
    }
}