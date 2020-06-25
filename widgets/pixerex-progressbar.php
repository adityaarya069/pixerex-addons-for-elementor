<?php

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Progressbar extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-progressbar';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Progress Bar', 'pixerex-addons-for-elementor') );
	}
    
    public function get_icon() {
        return 'pr-progress-bar';
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }
    
    public function get_style_depends() {
        return [
            'pixerex-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'elementor-waypoints',
            'lottie-js',
            'pixerex-addons-js'
        ];
    }

    public function get_keywords() {
        return ['circle', 'chart', 'line'];
    }
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for the pixerex progress bar
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /* Start Progress Content Section */
        $this->start_controls_section('pixerex_progressbar_labels',
            [
                'label'         => __('Progress Bar Settings', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('layout_type', 
            [
                'label'         => __('Type', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'line'          => __('Line', 'pixerex-addons-for-elementor'),
                    'circle'        => __('Circle', 'pixerex-addons-for-elementor'),
                    'dots'          => __('Dots', 'pixerex-addons-for-elementor'),
                ],
                'default'       =>'line',
                'label_block'   => true,
            ]
        );

        $this->add_responsive_control('dot_size', 
            [
                'label'     => __('Dot Size', 'pixerex-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 60,
                    ],
                ],
                'default'     => [
                    'size' => 25,
                    'unit' => 'px',
                ],
                'condition'     => [
                    'layout_type'   => 'dots'
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .progress-segment' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control('dot_spacing', 
            [
                'label'     => __('Spacing', 'pixerex-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 10,
                    ],
                ],
                'default'     => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'condition'     => [
                    'layout_type'   => 'dots'
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .progress-segment:not(:first-child):not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
                    '{{WRAPPER}} .progress-segment:first-child' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 )',
                    '{{WRAPPER}} .progress-segment:last-child' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
                ],
            ]
        );

        $this->add_control('circle_size',
            [
                'label' => __('Size', 'pixerex-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-wrap' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_select_label', 
            [
                'label'         => __('Labels', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       =>'left_right_labels',
                'options'       => [
                    'left_right_labels'    => __('Left & Right Labels', 'pixerex-addons-for-elementor'),
                    'more_labels'          => __('Multiple Labels', 'pixerex-addons-for-elementor'),
                ],
                'label_block'   => true,
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_left_label',
            [
                'label'         => __('Title', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('My Skill','pixerex-addons-for-elementor'),
                'label_block'   => true,
                'condition'     =>[
                    'pixerex_progressbar_select_label' => 'left_right_labels'
                ]
            ]
        );

        $this->add_control('pixerex_progressbar_right_label',
            [
                'label'         => __('Percentage', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('50%','pixerex-addons-for-elementor'),
                'label_block'   => true,
                'condition'     =>[
                    'pixerex_progressbar_select_label' => 'left_right_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('icon_type',
		  	[
		     	'label'			=> __( 'Icon Type', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'options'		=> [
		     		'icon'  => __('Font Awesome', 'pixerex-addons-for-elementor'),
                    'image'=> __( 'Custom Image', 'pixerex-addons-for-elementor'),
                    'animation'     => __('Lottie Animation', 'pixerex-addons-for-elementor'),
		     	],
                 'default'		=> 'icon',
                 'condition'    =>[
                    'layout_type'   => 'circle'
                ]
		  	]
		);

		$this->add_control('icon_select',
		  	[
		     	'label'			=> __( 'Select an Icon', 'pixerex-addons-for-elementor' ),
		     	'type'              => Controls_Manager::ICONS,
                'condition'     =>[
                    'icon_type' => 'icon',
                    'layout_type'   => 'circle'
                ]
		  	]
		);

		$this->add_control('image_upload',
		  	[
		     	'label'			=> __( 'Upload Image', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::MEDIA,
			  	'default'		=> [
			  		'url' => Utils::get_placeholder_image_src(),
                ],
                'condition'     => [
                    'icon_type' => 'image',
                    'layout_type'   => 'circle'
                ]
		  	]
        );

        $this->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'pixerex-addons-for-elementor' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );
        
        $this->add_responsive_control('icon_size',
            [
                'label'         => __('Icon Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'layout_type'   => 'circle'
                ],
                'default'       => [
                    'unit'  => 'px',
                    'size'  => 30,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-content i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .pixerex-progressbar-circle-content svg, {{WRAPPER}} .pixerex-progressbar-circle-content img' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control('show_percentage_value',
            [
                'label'      => __('Show Percentage Value', 'pixerex-addons-for-elementor'),
                'type'       => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'condition'   => [
                    'layout_type'   => 'circle'
                ]
            ]
        );
        
        $repeater = new REPEATER();
        
        $repeater->add_control('text',
            [
                'label'             => __( 'Label','pixerex-addons-for-elementor' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'label_block'       => true,
                'placeholder'       => __( 'label','pixerex-addons-for-elementor' ),
                'default'           => __( 'label', 'pixerex-addons-for-elementor' ),
            ]
        );
        
        $repeater->add_control('number',
            [
                'label'             => __( 'Percentage', 'pixerex-addons-for-elementor' ),
                'dynamic'           => [ 'active' => true ],
                'type'              => Controls_Manager::TEXT,
                'default'           => 50,
            ]
        );
        
        $this->add_control('pixerex_progressbar_multiple_label',
            [
                'label'     => __('Label','pixerex-addons-for-elementor'),
                'type'      => Controls_Manager::REPEATER,
                'default'   => [
                    [
                        'text' => __( 'Label','pixerex-addons-for-elementor' ),
                        'number' => 50
                    ]
                    ],
                'fields'    => array_values( $repeater->get_controls() ),
                'condition' => [
                    'pixerex_progressbar_select_label'  => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('pixerex_progress_bar_space_percentage_switcher',
            [
                'label'      => __('Enable Percentage', 'pixerex-addons-for-elementor'),
                'type'       => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'description' => __('Enable percentage for labels','pixerex-addons-for-elementor'),
                'condition'   => [
                    'pixerex_progressbar_select_label'=>'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_select_label_icon', 
            [
                'label'         => __('Labels Indicator', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       =>'line_pin',
                'options'       => [
                    ''            => __('None','pixerex-addons-for-elementor'),
                    'line_pin'    => __('Pin', 'pixerex-addons-for-elementor'),
                    'arrow'       => __('Arrow','pixerex-addons-for-elementor'),
                ],
                'condition'     =>[
                    'pixerex_progressbar_select_label' => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_more_labels_align',
            [
                'label'         => __('Labels Alignment','premuim-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',   
                    ],
                    'center'     => [
                        'title'=> __( 'Center', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'condition'     =>[
                    'pixerex_progressbar_select_label' => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
    
        $this->add_control('pixerex_progressbar_progress_percentage',
            [
                'label'             => __('Value', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'default'           => 50
            ]
        );
        
        $this->add_control('pixerex_progressbar_progress_style', 
            [
                'label'         => __('Style', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'solid',
                'options'       => [
                    'solid'    => __('Solid', 'pixerex-addons-for-elementor'),
                    'stripped' => __('Striped', 'pixerex-addons-for-elementor'),
                    'gradient' => __('Animated Gradient', 'pixerex-addons-for-elementor'),
                ],
                'condition'     => [
                    'layout_type'   => 'line'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_speed',
            [
                'label'             => __('Speed (milliseconds)', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::NUMBER
            ]
        );
        
        $this->add_control('pixerex_progressbar_progress_animation', 
            [
                'label'         => __('Animated', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_progressbar_progress_style'    => 'stripped',
                    'layout_type'   => 'line'
                ]
            ]
        );

        $this->add_control('gradient_colors',
            [
                'label'         => __('Gradient Colors', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'description'   => __('Enter Colors separated with \' , \'.','pixerex-addons-for-elementor'),
                'default'       => '#6EC1E4,#54595F',
                'label_block'   => true,
                'condition'     => [
                    'layout_type'   => 'line',
                    'pixerex_progressbar_progress_style' => 'gradient'
                ]
            ]
        );
        
        $this->end_controls_section();

        
        $this->start_controls_section('pixerex_progressbar_progress_bar_settings',
            [
                'label'             => __('Progress Bar', 'pixerex-addons-for-elementor'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_progressbar_progress_bar_height',
            [
                'label'         => __('Height', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 25,
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-bar-wrap, {{WRAPPER}} .pixerex-progressbar-bar' => 'height: {{SIZE}}px;',   
                ],
                'condition'     => [
                    'layout_type'   => 'line'
                ]
            ]
        );

        $this->add_control('pixerex_progressbar_progress_bar_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'range'         => [
                    'px'  => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-bar-wrap, {{WRAPPER}} .pixerex-progressbar-bar, {{WRAPPER}} .progress-segment' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_border_width',
            [
                'label' => __('Border Width', 'pixerex-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-base' => 'border-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-progressbar-circle div' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_base_border_color',
            [
                'label'         => __('Border Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-base' => 'border-color: {{VALUE}};',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );

        $this->add_control('fill_colors_title',
            [
                'label'             =>  __('Fill', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_progressbar_progress_color',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-progressbar-bar, {{WRAPPER}} .segment-inner',
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_fill_color',
            [
                'label'         => __('Select Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle div' => 'border-color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control('base_colors_title',
            [
                'label'             =>  __('Base', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_progressbar_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-progressbar-bar-wrap:not(.pixerex-progressbar-dots), {{WRAPPER}} .pixerex-progressbar-circle-base, {{WRAPPER}} .progress-segment',
            ]
        );

        $this->add_responsive_control('pixerex_progressbar_container_margin',
            [
                'label'             => __('Margin', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-bar-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]      
        );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_progressbar_labels_section',
            [
                'label'         => __('Labels', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_progressbar_select_label'  => 'left_right_labels'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_left_label_hint',
            [
                'label'             =>  __('Title', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control('pixerex_progressbar_left_label_color',
                [
                    'label'         => __('Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-left-label' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'left_label_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-progressbar-left-label',
            ]
        );
        
        $this->add_responsive_control('pixerex_progressbar_left_label_margin',
            [
                'label'             => __('Margin', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-left-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pixerex_progressbar_right_label_hint',
            [
                'label'             =>  __('Percentage', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::HEADING,
                'separator'         => 'before'
            ]
        );
        
        $this->add_control('pixerex_progressbar_right_label_color',
             [
                'label'             => __('Color', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-right-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'right_label_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-progressbar-right-label',
            ]
        );
        
        $this->add_responsive_control('pixerex_progressbar_right_label_margin',
            [
                'label'             => __('Margin', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-progressbar-right-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_progressbar_multiple_labels_section',
            [
                'label'         => __('Multiple Labels', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'pixerex_progressbar_select_label'  => 'more_labels'
                ]
            ]
        );

        $this->add_control('pixerex_progressbar_multiple_label_color',
             [
                'label'             => __('Labels\' Color', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-center-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label'         => __('Labels\' Typography', 'pixerex-addons-for-elementor'),
                'name'          => 'more_label_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-progressbar-center-label',
            ]
        );

        $this->add_control('pixerex_progressbar_value_label_color',
            [
                'label'             => __('Percentage Color', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                 'condition'       =>[
                     'pixerex_progress_bar_space_percentage_switcher'=>'yes'
                 ],
                'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-percentage' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label'         => __('Percentage Typography','pixerex-addons-for-elementor'),
                'name'          => 'percentage_typography',
                'condition'       =>[
                        'pixerex_progress_bar_space_percentage_switcher'=>'yes'
                ],
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-progressbar-percentage',
            ]
        );

         $this->end_controls_section();

         $this->start_controls_section('pixerex_progressbar_multiple_labels_arrow_section',
            [
                'label'         => __('Arrow', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'pixerex_progressbar_select_label'  => 'more_labels',
                    'pixerex_progressbar_select_label_icon' => 'arrow'
                ]
            ]
        );
        
        $this->add_control('pixerex_progressbar_arrow_color',
            [
                'label'         => __('Color', 'pixerex_elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'          => Scheme_Color::get_type(),
                    'value'         => Scheme_Color::COLOR_1,
                ],
                'condition'     =>[
                    'pixerex_progressbar_select_label_icon' => 'arrow'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-arrow' => 'color: {{VALUE}};'
                ]
            ]
        );
        
	 $this->add_responsive_control('pixerex_arrow_size',
        [
            'label'	       => __('Size','pixerex-addons-for-elementor'),
            'type'             =>Controls_Manager::SLIDER,
            'size_units'       => ['px', "em"],
            'condition'        =>[
                'pixerex_progressbar_select_label_icon' => 'arrow'
            ],
            'selectors'          => [
                '{{WRAPPER}} .pixerex-progressbar-arrow' => 'border-width: {{SIZE}}{{UNIT}};'
            ]
        ]
    );

       $this->end_controls_section();

       $this->start_controls_section('pixerex_progressbar_multiple_labels_pin_section',
            [
                'label'         => __('Indicator', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'pixerex_progressbar_select_label'  => 'more_labels',
                    'pixerex_progressbar_select_label_icon' => 'line_pin'
                ]
            ]
        );
        
       $this->add_control('pixerex_progressbar_line_pin_color',
                [
                    'label'             => __('Color', 'pixerex-addons-for-elementor'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'               => Scheme_Color::get_type(),
                        'value'              => Scheme_Color::COLOR_2,
                    ],
                    'condition'         =>[
                        'pixerex_progressbar_select_label_icon' =>'line_pin'
                    ],
                     'selectors'        => [
                    '{{WRAPPER}} .pixerex-progressbar-pin' => 'border-color: {{VALUE}};'
                ]
            ]
         );

        $this->add_responsive_control('pixerex_pin_size',
            [
                    'label'	       => __('Size','pixerex-addons-for-elementor'),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'pixerex_progressbar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-progressbar-pin' => 'border-left-width: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );

        $this->add_responsive_control('pixerex_pin_height',
            [
                    'label'	       => __('Height','pixerex-addons-for-elementor'),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'pixerex_progressbar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-progressbar-pin' => 'height: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('icon_style',
            [
                'label'             => __('Icon', 'pixerex-addons-for-elementor'),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'layout_type'     => 'circle'
                ]
            ]
        );

        $this->add_control('icon_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-icon' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'icon_type'     => 'icon'
                ]
            ]
        );

        $this->add_control('icon_background_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-icon' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'icon_type!'     => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'icon_border',
                'selector'      => '{{WRAPPER}} .pixerex-progressbar-circle-icon',
            ]
        );
        
        $this->add_responsive_control('icon_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control('icon_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-progressbar-circle-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('pixerex_progressbar_left_label');
        $this->add_inline_editing_attributes('pixerex_progressbar_right_label');
        
        $length = isset ( $settings['pixerex_progressbar_progress_percentage']['size'] ) ? $settings['pixerex_progressbar_progress_percentage']['size'] : $settings['pixerex_progressbar_progress_percentage'];
        
        $style = $settings['pixerex_progressbar_progress_style'];
        $type  = $settings['layout_type'];

        $progressbar_settings = [
            'progress_length'   => $length,
            'speed'             => !empty( $settings['pixerex_progressbar_speed'] ) ? $settings['pixerex_progressbar_speed'] : 1000,
            'type'              => $type,
        ];

        if( 'dots' === $type ) {
            $progressbar_settings['dot'] = $settings['dot_size']['size'];
            $progressbar_settings['spacing'] = $settings['dot_spacing']['size'];
        }

        $this->add_render_attribute( 'progressbar', 'class', 'pixerex-progressbar-container' );

        if( 'stripped' === $style ) {
            $this->add_render_attribute( 'progressbar', 'class', 'pixerex-progressbar-striped' );
        } elseif( 'gradient' === $style ) {
            $this->add_render_attribute( 'progressbar', 'class', 'pixerex-progressbar-gradient' );
            $progressbar_settings['gradient'] = $settings['gradient_colors'];
        }
        
        if( 'yes' === $settings['pixerex_progressbar_progress_animation'] ) {
            $this->add_render_attribute( 'progressbar', 'class', 'pixerex-progressbar-active' );
        }

        $this->add_render_attribute( 'progressbar', 'data-settings', wp_json_encode($progressbar_settings) );
        
        if( 'circle' !== $type ) {
            $this->add_render_attribute( 'wrap', 'class', 'pixerex-progressbar-bar-wrap' );

            if( 'dots' === $type ) {
                $this->add_render_attribute( 'wrap', 'class', 'pixerex-progressbar-dots' );
            }

        } else {
            $this->add_render_attribute( 'wrap', 'class', 'pixerex-progressbar-circle-wrap' );

            $icon_type = $settings['icon_type'];

            if( 'animation' === $icon_type ) {
                $this->add_render_attribute( 'progress_lottie', [
                    'class' => [
                        'pixerex-progressbar-circle-icon',
                        'pixerex-lottie-animation'
                    ],
                    'data-lottie-url' => $settings['lottie_url'],
                    'data-lottie-loop' => $settings['lottie_loop'],
                    'data-lottie-reverse' => $settings['lottie_reverse']
                ]);
            }

        }

    ?>

   <div <?php echo $this->get_render_attribute_string( 'progressbar' ); ?>>

        <?php if ($settings['pixerex_progressbar_select_label'] === 'left_right_labels') :?>
            <p class="pixerex-progressbar-left-label"><span <?php echo $this->get_render_attribute_string('pixerex_progressbar_left_label'); ?>><?php echo $settings['pixerex_progressbar_left_label'];?></span></p>
            <p class="pixerex-progressbar-right-label"><span <?php echo $this->get_render_attribute_string('pixerex_progressbar_right_label'); ?>><?php echo $settings['pixerex_progressbar_right_label'];?></span></p>
        <?php endif;?>

        <?php if ($settings['pixerex_progressbar_select_label'] === 'more_labels') : ?>
            <div class="pixerex-progressbar-container-label" style="position:relative;">
            <?php foreach($settings['pixerex_progressbar_multiple_label'] as $item){
                if( $this->get_settings('pixerex_progressbar_more_labels_align') === 'center' ) {
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if( $settings['pixerex_progressbar_select_label_icon'] === 'arrow' ) { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin') {
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif( $settings['pixerex_progressbar_select_label_icon'] === 'line_pin') {
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%)">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p></div>';
                        }
                    }
                } elseif($this->get_settings('pixerex_progressbar_more_labels_align') === 'left' ) {
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['pixerex_progressbar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-10%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-10%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p></div>';
                        }
                    }
                } else {
                    if($settings['pixerex_progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['pixerex_progressbar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-82%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-95%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-96%);">'.$item['text'].' <span class="pixerex-progressbar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['pixerex_progressbar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-71%);">'.$item['text'].'</p><p class="pixerex-progressbar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['pixerex_progressbar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-97%);">'.$item['text'].'</p><p class="pixerex-progressbar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="pixerex-progressbar-multiple-label" style="left:'.$item['number'].'%;"><p class = "pixerex-progressbar-center-label" style="transform:translateX(-96%);">'.$item['text'].'</p></div>';
                        }
                    }
                }

               } ?>
            </div>
        <?php endif; ?>

        <div class="clearfix"></div>
        <div <?php echo $this->get_render_attribute_string( 'wrap' ); ?>>
            <?php if( 'line' === $type ) : ?>
                <div class="pixerex-progressbar-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <?php elseif( 'circle' === $type ): ?>
                <div class="pixerex-progressbar-circle-base"></div>
                <div class="pixerex-progressbar-circle">
                    <div class="pixerex-progressbar-circle-left"></div>
                    <div class="pixerex-progressbar-circle-right"></div>
                </div>
                <div class="pixerex-progressbar-circle-content">
                    <?php if( !empty( $settings['icon_select']['value'] ) || ! empty( $settings['image_upload']['url'] ) || !empty( $settings['lottie_url'] )  ) : ?>
                        <?php if('icon' === $icon_type ):
                            Icons_Manager::render_icon( $settings['icon_select'], [ 'class'=> 'pixerex-progressbar-circle-icon', 'aria-hidden' => 'true' ] );
                        elseif( 'image' === $icon_type ) : ?>
                            <img class="pixerex-progressbar-circle-icon" src="<?php echo $settings['image_upload']['url']; ?>">
                        <?php else: ?>
                            <div <?php echo $this->get_render_attribute_string( 'progress_lottie' ); ?>></div>
                        <?php endif;?>
                    <?php endif; ?>
                <p class="pixerex-progressbar-left-label">
                    <span <?php echo $this->get_render_attribute_string('pixerex_progressbar_left_label'); ?>>
                        <?php echo $settings['pixerex_progressbar_left_label'];?>
                    </span>
                </p>
                <?php if( 'yes' === $settings['show_percentage_value'] ) : ?>
                    <p class="pixerex-progressbar-right-label">
                        <span <?php echo $this->get_render_attribute_string('pixerex_progressbar_right_label'); ?>>0%</span>
                    </p>
                <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    }
}