<?php

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Person extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-person';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Team Members', 'pixerex-elementor-elements') );
	}

    public function get_icon() {
        return 'pa-person';
    }
    
    public function get_style_depends() {
        return [
            'font-awesome',
            'pixerex-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'imagesloaded',
            'jquery-slick',
            'pixerex-addons-js'
        ];
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }

    public function get_keywords() {
		return ['person'];
	}
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for the pixerex team members
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        
        $this->start_controls_section('pixerex_person_general_settings',
            [
                'label'         => __('General Settings', 'pixerex-elementor-elements')
            ]
        );
		
		$this->add_control('multiple',
            [
                'label'         => __( 'Multiple Member', 'pixerex-elementor-elements' ),
                'description'   => __('Enable this option if you need to add multiple persons', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_person_style',
            [
                'label'         => __('Style', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'style1',
                'options'       => [
                    'style1'        => __('Style 1', 'pixerex-elementor-elements'),
                    'style2'        => __('Style 2', 'pixerex-elementor-elements')
                ],
                'label_block'   =>  true,
                'render_type'   => 'template'
            ]
        );
                
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'          => 'thumbnail',
				'default'       => 'full',
				'separator'     => 'none',
			]
		);
        
        $this->add_responsive_control('pixerex_person_image_width',
            [
                'label'         => __('Width', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'description'   => __('Enter image width in (PX, EM, %), default is 100%', 'pixerex-elementor-elements'),
                'size_units'    => ['px', 'em', '%'],
                'range'         => [
                    'px'    => [
                        'min'       => 1,
                        'max'       => 800,
                    ],
                    'em'    => [
                        'min'       => 1,
                        'max'       => 50,
                    ],
                ],
                'default'       => [
                    'unit'  => '%',
                    'size'  => '100',
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_align',
            [
                'label'         => __( 'Alignment', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'      => [
                        'title'=> __( 'Left', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('pixerex_person_hover_image_effect',
            [
                'label'         => __('Hover Effect', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'          => __('None', 'pixerex-elementor-elements'),
                    'zoomin'        => __('Zoom In', 'pixerex-elementor-elements'),
                    'zoomout'       => __('Zoom Out', 'pixerex-elementor-elements'),
                    'scale'         => __('Scale', 'pixerex-elementor-elements'),
                    'grayscale'     => __('Grayscale', 'pixerex-elementor-elements'),
                    'blur'          => __('Blur', 'pixerex-elementor-elements'),
                    'bright'        => __('Bright', 'pixerex-elementor-elements'),
                    'sepia'         => __('Sepia', 'pixerex-elementor-elements'),
                    'trans'         => __('Translate', 'pixerex-elementor-elements'),
                ],
                'default'       => 'zoomin',
                'label_block'   => true
            ]
        );
        
        $this->add_responsive_control('pixerex_person_text_align',
            [
                'label'         => __( 'Content Alignment', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-elementor-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-info' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('pixerex_person_name_heading',
            [
                'label'         => __('Name Tag', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h2',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
                'label_block'   =>  true,
            ]
        );

        $this->add_control('pixerex_person_title_heading',
            [
                'label'         => __('Title Tag', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h4',
                'options'       => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
                'label_block'   =>  true,
            ]
        );
        
        $this->add_responsive_control('persons_per_row',
            [
                'label'             => __('Members/Row', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    '100%'  => __('1 Column', 'pixerex-elementor-elements'),
                    '50%'   => __('2 Columns', 'pixerex-elementor-elements'),
                    '33.33%'=> __('3 Columns', 'pixerex-elementor-elements'),
                    '25%'   => __('4 Columns', 'pixerex-elementor-elements'),
                    '20%'   => __('5 Columns', 'pixerex-elementor-elements'),
                    '16.667%'=> __('6 Columns', 'pixerex-elementor-elements'),
                ],
                'default'           => '33.33%',
                'render_type'       => 'template',
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-person-container' => 'width: {{VALUE}}'
                ],
                'condition'         => [
                    'multiple'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('spacing',
            [
                'label'         => __('Spacing', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', "em"],
                'default'       => [
                    'top'   => 5,
                    'right' => 5,
                    'bottom'=> 5,
                    'left'  => 5
                ],
                'condition'     => [
                    'multiple'   => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-container' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}}; margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0',
                    ' {{WRAPPER}} .pixerex-person-style1 .pixerex-person-info' => 'left: {{LEFT}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_control('multiple_equal_height',
            [
                'label'         => __( 'Equal Height', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'multiple'              => 'yes'
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_settings',
            [
                'label'         => __('Single Member Settings', 'pixerex-elementor-elements'),
                'condition'     => [
                    'multiple!'   => 'yes'
                ]
            ]
        );

        $this->add_control('pixerex_person_image',
            [
                'label'         => __('Image', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                'url'	=> Utils::get_placeholder_image_src()
            ],
                'label_block'   => true
            ]
        );
        
        $this->add_control('pixerex_person_name',
            [
                'label'         => __('Name', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'John Frank',
                'separator'     => 'before',
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_person_title',
            [
                'label'         => __('Title', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Senior Developer', 'pixerex-elementor-elements'),
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_person_content',
            [
                'label'         => __('Description', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit','pixerex-elementor-elements'),
            ]
        );
        
        $this->add_control('pixerex_person_social_enable',
            [
                'label'         => __( 'Enable Social Icons', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );
        
        $this->add_control('pixerex_person_facebook',
            [
                'label'         => __('Facebook', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_twitter',
            [
                'label'         => __('Twitter', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_linkedin',
            [
                'label'         => __('LinkedIn', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_google',
            [
                'label'         => __('Google+', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_youtube',
            [
                'label'         => __('YouTube', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_instagram',
            [
                'label'         => __('Instagram', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_skype',
            [
                'label'         => __('Skype', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_pinterest',
            [
                'label'         => __('Pinterest', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_dribbble',
            [
                'label'         => __('Dribbble', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_behance',
            [
                'label'         => __('Behance', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_whatsapp',
            [
                'label'         => __('WhatsApp', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_telegram',
            [
                'label'         => __('Telegram', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_person_mail',
            [
                'label'         => __('Email Address', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );

        $this->add_control('pixerex_person_site',
            [
                'label'         => __('Website', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        
        $this->start_controls_section('multiple_settings',
            [
                'label'         => __('Multiple Members Settings', 'pixerex-elementor-elements'),
                'condition'     => [
                    'multiple'   => 'yes'
                ]
            ]
        );
        
        $repeater = new REPEATER();
        
        $repeater->add_control( 'multiple_image', 
            [
                'label'         => __( 'Image', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $repeater->add_control('multiple_name',
            [
                'label'         => __('Name', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'John Frank',
                'separator'     => 'before',
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('multiple_title',
            [
                'label'         => __('Title', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Senior Developer', 'pixerex-elementor-elements'),
                'label_block'   => true,
            ]
        );
        
        $repeater->add_control('multiple_description',
            [
                'label'         => __('Description', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit','pixerex-elementor-elements'),
            ]
        );
        
        $repeater->add_control('multiple_social_enable',
            [
                'label'         => __( 'Enable Social Icons', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );
        
        $repeater->add_control('multiple_facebook',
            [
                'label'         => __('Facebook', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_twitter',
            [
                'label'         => __('Twitter', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_linkedin',
            [
                'label'         => __('LinkedIn', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_google',
            [
                'label'         => __('Google+', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_youtube',
            [
                'label'         => __('YouTube', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_instagram',
            [
                'label'         => __('Instagram', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_skype',
            [
                'label'         => __('Skype', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_pinterest',
            [
                'label'         => __('Pinterest', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_dribbble',
            [
                'label'         => __('Dribbble', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_behance',
            [
                'label'         => __('Behance', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_whatsapp',
            [
                'label'         => __('WhatsApp', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_telegram',
            [
                'label'         => __('Telegram', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $repeater->add_control('multiple_mail',
            [
                'label'         => __('Email Address', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );

        $repeater->add_control('multiple_site',
            [
                'label'         => __('Website', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'multiple_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('multiple_persons',
           [
               'label'          => __( 'Members', 'pixerex-elementor-elements' ),
               'type'           => Controls_Manager::REPEATER,
               'default'       => [
                    [
                        'multiple_name' => 'John Frank'
                    ],
                    [
                        'multiple_name' => 'John Frank'
                    ],
                    [
                        'multiple_name' => 'John Frank'
                    ]
                ],
               'fields'         => array_values( $repeater->get_controls() ),
               'title_field'    => '{{{multiple_name}}} - {{{multiple_title}}}',
               'prevent_empty'  => false
           ]
       );
        
        $this->add_control('carousel',
            [
                'label'         => __('Carousel', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        $this->add_control('carousel_play',
            [
                'label'         => __('Auto Play', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('carousel_autoplay_speed',
			[
				'label'			=> __( 'Autoplay Speed', 'pixerex-elementor-elements' ),
				'description'	=> __( 'Autoplay Speed means at which time the next slide should come. Set a value in milliseconds (ms)', 'pixerex-elementor-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 5000,
				'condition'		=> [
					'carousel' => 'yes',
                    'carousel_play' => 'yes',
				],
			]
		);
        
        $this->add_responsive_control('carousel_arrows_pos',
            [
                'label'         => __('Arrows Position', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', "em"],
                'range'         => [
                    'px'    => [
                        'min'       => -100, 
                        'max'       => 100,
                    ],
                    'em'    => [
                        'min'       => -10, 
                        'max'       => 10,
                    ],
                ],
                'condition'		=> [
					'carousel' => 'yes'
				],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container a.carousel-arrow.carousel-next' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pixerex-persons-container a.carousel-arrow.carousel-prev' => 'left: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('section_pa_docs',
            [
                'label'         => __('Helpful Documentations', 'pixerex-addons-pro'),
            ]
        );
        
        $this->add_control('doc_1',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf( __( '%1$s I\'m not able to see Font Awesome icons in the widget » %2$s', 'pixerex-addons-pro' ), '<a href="https://pixerexaddons.com/docs/why-im-not-able-to-see-elementor-font-awesome-5-icons-in-pixerex-add-ons/?utm_source=papro-dashboard&utm_medium=papro-editor&utm_campaign=papro-plugin" target="_blank" rel="noopener">', '</a>' ),
                'content_classes' => 'editor-pa-doc',
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_image_style', 
            [
                'label'         => __('Image', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .pixerex-person-container img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filters', 'pixerex-elementor-elements'),
				'selector'  => '{{WRAPPER}} .pixerex-person-container:hover img'
			]
		);
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_person_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-person-social',
                'condition'     => [
                    'pixerex_person_style'  => 'style2'
                ]
            ]
        );
        
        $this->add_control('blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => __( 'Normal', 'elementor' ),
					'multiply'      => 'Multiply',
					'screen'        => 'Screen',
					'overlay'       => 'Overlay',
					'darken'        => 'Darken',
					'lighten'       => 'Lighten',
					'color-dodge'   => 'Color Dodge',
					'saturation'    => 'Saturation',
					'color'         => 'Color',
					'luminosity'    => 'Luminosity',
				],
                'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixerex-person-image-container img' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_name_style', 
            [
                'label'         => __('Name', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_person_name_color',
            [
                'label'         => __('Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-name'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'name_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-person-name',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'name_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-person-name',
            ]
        );
        
        $this->add_responsive_control('name_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_title_style', 
            [
                'label'         => __('Job Title', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_person_title_color',
            [
                'label'         => __('Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-title'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-person-title',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'title_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-person-title',
            ]
        );
        
        $this->add_responsive_control('title_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_description_style', 
            [
                'label'         => __('Description', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_person_description_color',
            [
                'label'         => __('Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-content'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'description_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-person-content',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'description_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-person-content',
            ]
        );
        
        $this->add_responsive_control('description_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_social_icon_style', 
            [
                'label'         => __('Social Icons', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_social_size',
            [
                'label'         => __('Size', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item i' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_person_social_color',
            [
                'label'         => __('Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item i'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('pixerex_person_social_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item:hover i'  => 'color: {{VALUE}}',
                ]
            ]
        );
        
        $this->add_control('pixerex_person_social_background',
            [
                'label'             => __('Background Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .pixerex-person-list-item a'  => 'background-color: {{VALUE}}',
                ]
            ]
        );
        
        $this->add_control('pixerex_person_social_default_colors',
            [
                'label'         => __( 'Brands Default Colors', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'prefix_class'  => 'pixerex-person-defaults-'
            ]
        );
        
        $this->add_control('pixerex_person_social_hover_background',
            [
                'label'             => __('Hover Background Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} li.pixerex-person-list-item:hover a'  => 'background-color: {{VALUE}}',
                ],
                'condition'         => [
                    'pixerex_person_social_default_colors!'   => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_person_social_border',
                'selector'      => '{{WRAPPER}} .pixerex-person-list-item a',
            ]
        );
        
        $this->add_responsive_control('pixerex_person_social_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_social_margin',
            [
                'label'         => __('Margin', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_social_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-list-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_person_general_style', 
            [
                'label'         => __('Content', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_person_content_background_color',
            [
                'label'         => __('Background Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'default'       => 'rgba(245,245,245,0.97)',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-info'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_border_bottom_width',
            [
                'label'         => __('Bottom Offset', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 700,
                    ]
                ],
                'default'       => [
                    'size'  => 20,
                    'unit'  => 'px'
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_person_style'  => 'style1'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-info' => 'bottom: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_content_speed',
            [
                'label'			=> __( 'Transition Duration (sec)', 'pixerex-elementor-elements' ),
                'type'			=> Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 5,
                        'step'  => 0.1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .pixerex-person-info, {{WRAPPER}} .pixerex-person-image-container img'   => 'transition-duration: {{SIZE}}s',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_person_content_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-person-info-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_style',
            [
                'label'         => __('Carousel', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('arrow_color',
            [
                'label'         => __('Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('arrow_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('arrow_size',
            [
                'label'         => __('Size', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('arrow_background',
            [
                'label'         => __('Background Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('arrow_hover_background',
            [
                'label'         => __('Background Hover Color', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('arrow_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control('arrow_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-persons-container .slick-arrow' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
    }

    /**
	 * Render Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $image_effect = $settings['pixerex_person_hover_image_effect'];

        $image_html = '';
        if ( ! empty( $settings['pixerex_person_image']['url'] ) ) {
			$this->add_render_attribute( 'image', 'src', $settings['pixerex_person_image']['url'] );
			$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['pixerex_person_image'] ) );
			$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['pixerex_person_image'] ) );

			$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'pixerex_person_image' );
		}
        
        $this->add_render_attribute( 'persons_container', 'class', [
                'pixerex-persons-container',
                'pixerex-person-' . $settings['pixerex_person_style']
            ]
        );
        
        $this->add_render_attribute( 'person_container', 'class', [
            'pixerex-person-container',
            'pixerex-person-' . $image_effect . '-effect'
        ]);
        
        if( 'yes' === $settings['multiple'] ) {
            $persons = $settings['multiple_persons'];
            $this->add_render_attribute( 'persons_container', 'class', 'multiple-persons' );
            $this->add_render_attribute( 'persons_container', 'data-persons-equal', $settings['multiple_equal_height'] );
        }
        
        $carousel = 'yes' === $settings['carousel'] ? true : false; 
        
        if( $carousel ) {
            
            $this->add_render_attribute('persons_container', 'data-carousel', $carousel );
            
            $columns = intval ( 100 / substr( $settings['persons_per_row'], 0, strpos( $settings['persons_per_row'], '%') ) );
        
            $this->add_render_attribute('persons_container', 'data-col', $columns );
            
            $play = 'yes' === $settings['carousel_play'] ? true : false;
            
            $speed = ! empty( $settings['carousel_autoplay_speed'] ) ? $settings['carousel_autoplay_speed'] : 5000;
            
            $this->add_render_attribute('persons_container', 'data-play', $play );
            
            $this->add_render_attribute('persons_container', 'data-speed', $speed );
            
            $this->add_render_attribute('persons_container', 'data-rtl', is_rtl() );
            
        }
            

    ?>
        <div <?php echo $this->get_render_attribute_string( 'persons_container' ) ?>>
            <?php if( 'yes' !== $settings['multiple'] ) : ?>
            <div <?php echo $this->get_render_attribute_string( 'person_container' ) ?>>
                <div class="pixerex-person-image-container">
                    <div class="pixerex-person-image-wrap">
                        <?php echo $image_html; ?>
                    </div>
                    <?php if( 'style2' === $settings['pixerex_person_style'] && 'yes' === $settings['pixerex_person_social_enable'] ) : ?>
                        <div class="pixerex-person-social">
                            <?php $this->get_social_icons(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="pixerex-person-info">
                    <?php $this->render_person_info(); ?>
                </div>
            </div>
            <?php else :
                foreach( $persons as $index => $person ) {
                
                    $person_image_html = '';
                    if ( ! empty( $person['multiple_image']['url'] ) ) {
                        $this->add_render_attribute( 'image', 'src', $person['multiple_image']['url'] );
                        $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $person['multiple_image'] ) );
                        $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $person['multiple_image'] ) );

                        $person_image_html = Group_Control_Image_Size::get_attachment_image_html( $person, 'thumbnail', 'multiple_image' );
                    }
                ?>
                    <div <?php echo $this->get_render_attribute_string( 'person_container' ) ?>>
                        <div class="pixerex-person-image-container">
                            <div class="pixerex-person-image-wrap">
                                <?php echo $person_image_html; ?>
                            </div>
                            <?php if( 'style2' === $settings['pixerex_person_style'] && 'yes' === $person['multiple_social_enable'] ) : ?>
                                <div class="pixerex-person-social">
                                    <?php $this->get_social_icons( $person ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="pixerex-person-info">
                            <?php $this->render_person_info( $person, $index ); ?>
                        </div>
                    </div>
                <?php }
            endif; ?>
        </div>
    <?php
    }
    
    /*
     * Get Social Icons
     * 
     * Render person social icons list
     * 
     * @since 3.8.4
     * @access protected
     * 
     * @param $person object current person
     */
    private function get_social_icons( $person = '' ) {
        
        $settings = $this->get_settings_for_display();
        
        $socialSites = [
            'facebook' => 'fa fa-facebook-f',
            'twitter' => 'fa fa-twitter',
            'linkedin' => 'fa fa-linkedin',
            'google' => 'fa fa-google-plus',
            'youtube'=>'fa fa-youtube',
            'instagram' =>'fa fa-instagram',
            'skype' => 'fa fa-skype',
            'pinterest' => 'fa fa-pinterest',
            'dribbble' => 'fa fa-dribbble',
            'behance' => 'fa fa-behance',
            'whatsapp' => 'fa fa-whatsapp',
            'telegram' => 'fa fa-telegram',
            'mail' => 'fa fa-envelope',
            'site' => 'fa fa-link',
        ];

        echo '<ul class="pixerex-person-social-list">';
            foreach( $socialSites as $site => $icon ) {
                $value = ('' === $person) ? $settings[ 'pixerex_person_' . $site ] : $person[ 'multiple_' . $site ];

                if( ! empty(  $value ) ) {
                    $icon_class = sprintf( 'elementor-icon pixerex-person-list-item pixerex-person-%s', $site );
                ?>
                <li class="<?php echo $icon_class; ?>"><a href="<?php echo $value; ?>" target="_blank"><i class="<?php echo $icon; ?>"></i></a></li>
                <?php
                }
            }
        echo '</ul>';

    }
    
    /*
     * Render Person Info
     * 
     * 
     * @since 3.12.0
     * @access protected
     * 
     * @param $person object current person
     * @param $index integer  current person index
     */
    protected function render_person_info( $person = '', $index = '' ) {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes('pixerex_person_name', 'advanced');
        
        $this->add_inline_editing_attributes('pixerex_person_title', 'advanced');
        
        $this->add_inline_editing_attributes('pixerex_person_content','advanced');
        
        $name_heading = $settings['pixerex_person_name_heading'];
        
        $title_heading = $settings['pixerex_person_title_heading'];
        
        $skin = $settings['pixerex_person_style'];
        
        if( empty( $person ) ) :
        ?>
            <div class="pixerex-person-info-container">
                <?php if( 'style3' !== $skin && ! empty( $settings['pixerex_person_name'] ) ) : ?>
                    <<?php echo $name_heading; ?> class="pixerex-person-name"><span <?php echo $this->get_render_attribute_string('pixerex_person_name'); ?>><?php echo $settings['pixerex_person_name']; ?></span></<?php echo $name_heading; ?>>
                <?php endif;

                if( 'style3' === $skin ) : ?>
                    <div class="pixerex-person-title-desc-wrap">
                <?php endif;
                    if( ! empty( $settings['pixerex_person_title'] ) ) : ?>
                        <<?php echo $title_heading; ?> class="pixerex-person-title"><span <?php echo $this->get_render_attribute_string('pixerex_person_title'); ?>><?php echo $settings['pixerex_person_title']; ?></span></<?php echo $title_heading; ?>>
                    <?php endif; 

                    if( ! empty( $settings['pixerex_person_content'] ) ) : ?>
                        <div class="pixerex-person-content">
                            <div <?php echo $this->get_render_attribute_string('pixerex_person_content'); ?>>
                                <?php echo $settings['pixerex_person_content']; ?>
                            </div>
                        </div>
                    <?php endif;
                if( 'style3' === $skin ) : ?>
                    </div>
                <?php endif;
                
                if( 'style3' === $skin ) : ?>
                    <div class="pixerex-person-name-icons-wrap">
                        <?php if( ! empty( $settings['pixerex_person_name'] ) ) : ?>
                            <<?php echo $name_heading; ?> class="pixerex-person-name"><span <?php echo $this->get_render_attribute_string('pixerex_person_name'); ?>><?php echo $settings['pixerex_person_name']; ?></span></<?php echo $name_heading; ?>>
                        <?php endif;
                        if( 'yes' === $settings['pixerex_person_social_enable'] ) :
                            $this->get_social_icons();
                        endif; ?>
                    </div>
                <?php endif;
                
                if( 'style1' === $settings['pixerex_person_style'] && 'yes' === $settings['pixerex_person_social_enable'] ) :
                    $this->get_social_icons();
                endif; ?>
            </div>
        <?php else:
            
            $name_setting_key = $this->get_repeater_setting_key( 'multiple_name', 'multiple_persons', $index );
            $title_setting_key = $this->get_repeater_setting_key( 'multiple_title', 'multiple_persons', $index );
            $desc_setting_key = $this->get_repeater_setting_key( 'multiple_description', 'multiple_persons', $index );

            $this->add_inline_editing_attributes( $name_setting_key, 'advanced' );
            $this->add_inline_editing_attributes( $title_setting_key, 'advanced' );
            $this->add_inline_editing_attributes( $desc_setting_key, 'advanced' );
            
        ?>
            <div class="pixerex-person-info-container">
                <?php if( 'style3' !== $skin && ! empty( $person['multiple_name'] ) ) : ?>
                    <<?php echo $name_heading; ?> class="pixerex-person-name"><span <?php echo $this->get_render_attribute_string($name_setting_key); ?>><?php echo $person['multiple_name']; ?></span></<?php echo $name_heading; ?>>
                <?php endif;

                if( 'style3' === $skin ) : ?>
                    <div class="pixerex-person-title-desc-wrap">
                <?php endif;
                    if( ! empty( $person['multiple_title'] ) ) : ?>
                        <<?php echo $title_heading; ?> class="pixerex-person-title"><span <?php echo $this->get_render_attribute_string($title_setting_key); ?>><?php echo $person['multiple_title']; ?></span></<?php echo $title_heading; ?>>
                    <?php endif;

                    if( ! empty( $person['multiple_description'] ) ) : ?>
                        <div class="pixerex-person-content">
                            <div <?php echo $this->get_render_attribute_string($desc_setting_key); ?>>
                                <?php echo $person['multiple_description']; ?>
                            </div>
                        </div>
                    <?php endif;
                if( 'style3' === $skin ) : ?>
                    </div>
                <?php endif;
                
                if( 'style3' === $skin ) : ?>
                    <div class="pixerex-person-name-icons-wrap">
                        <?php if( ! empty( $person['multiple_name'] ) ) : ?>
                            <<?php echo $name_heading; ?> class="pixerex-person-name"><span <?php echo $this->get_render_attribute_string($name_setting_key); ?>><?php echo $person['multiple_name']; ?></span></<?php echo $name_heading; ?>>
                        <?php endif;
                        if( 'yes' === $person['multiple_social_enable'] ) :
                            $this->get_social_icons( $person );
                        endif; ?>
                    </div>
                <?php endif;

                if( 'style1' === $settings['pixerex_person_style'] && 'yes' === $person['multiple_social_enable'] ) :
                    $this->get_social_icons( $person );
                endif; ?>
            </div>
        <?php endif;
        
    }


    protected function _content_template() {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'pixerex_person_name', 'advanced' );
        
        view.addInlineEditingAttributes( 'pixerex_person_title', 'advanced' );
        
        view.addInlineEditingAttributes( 'pixerex_person_content', 'advanced' );
        
        var nameHeading = settings.pixerex_person_name_heading,
        
        titleHeading = settings.pixerex_person_title_heading,
        
        imageEffect = 'pixerex-person-' + settings.pixerex_person_hover_image_effect + '-effect' ;
        
        skin        = settings.pixerex_person_style;
        
        view.addRenderAttribute( 'persons_container', 'class', [ 'pixerex-persons-container', 'pixerex-person-' + skin ] );
        
        view.addRenderAttribute('person_container', 'class', [ 'pixerex-person-container', imageEffect ] );

        var imageHtml = '';
        if ( settings.pixerex_person_image.url ) {
			var image = {
				id: settings.pixerex_person_image.id,
				url: settings.pixerex_person_image.url,
				size: settings.thumbnail_size,
				dimension: settings.thumbnail_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			imageHtml = '<img src="' + image_url + '"/>';

		}
        
        if ( settings.multiple ) {
            var persons = settings.multiple_persons;
            view.addRenderAttribute( 'persons_container', 'class', 'multiple-persons' );
            view.addRenderAttribute( 'persons_container', 'data-persons-equal', settings.multiple_equal_height );
        }
        
        var carousel = 'yes' === settings.carousel ? true : false; 
        
        if( carousel ) {
            
            view.addRenderAttribute('persons_container', 'data-carousel', carousel );
            
            var play = 'yes' === settings.carousel_play ? true : false,
                speed = '' !== settings.carousel_autoplay_speed ? settings.carousel_autoplay_speed : 5000;
                
            var columns = parseInt( 100 / settings.persons_per_row.substr( 0, settings.persons_per_row.indexOf('%') ) );
        
            view.addRenderAttribute('persons_container', 'data-col', columns );
            
            view.addRenderAttribute('persons_container', 'data-play', play );
            
            view.addRenderAttribute('persons_container', 'data-speed', speed );
            
        }
            
        
        function getSocialIcons( person = null ) {
        
            var personSettings,
                socialIcons;
            
            if( null === person ) {
                personSettings = settings;
                socialIcons = {
                    facebook: settings.pixerex_person_facebook,
                    twitter:  settings.pixerex_person_twitter,
                    linkedin:  settings.pixerex_person_linkedin,
                    google:  settings.pixerex_person_google,
                    youtube: settings.pixerex_person_youtube,
                    instagram: settings.pixerex_person_instagram,
                    skype: settings.pixerex_person_skype,
                    pinterest: settings.pixerex_person_pinterest,
                    dribbble: settings.pixerex_person_dribbble,
                    behance: settings.pixerex_person_behance,
                    whatsapp: settings.pixerex_person_whatsapp,
                    telegram: settings.pixerex_person_telegram,
                    mail: settings.pixerex_person_mail,
                    site: settings.pixerex_person_site
                };
            } else {
                personSettings = person;
                socialIcons = {
                    facebook: person.multiple_facebook,
                    twitter:  person.multiple_twitter,
                    linkedin:  person.multiple_linkedin,
                    google:  person.multiple_google,
                    youtube: person.multiple_youtube,
                    instagram: person.multiple_instagram,
                    skype: person.multiple_skype,
                    pinterest: person.multiple_pinterest,
                    dribbble: person.multiple_dribbble,
                    behance: person.multiple_behance,
                    whatsapp: person.multiple_whatsapp,
                    telegram: person.multiple_telegram,
                    mail: person.multiple_mail,
                    site: person.multiple_site
                };
            }
            
            #>
            <ul class="pixerex-person-social-list">
                <# if( '' != socialIcons.facebook ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-facebook"><a href="{{ socialIcons.facebook }}" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.twitter ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-twitter"><a href="{{ socialIcons.twitter }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.linkedin ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-linkedin"><a href="{{ socialIcons.linkedin }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.google ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-google"><a href="{{ socialIcons.google }}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.youtube ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-youtube"><a href="{{ socialIcons.youtube }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.instagram ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-instagram"><a href="{{ socialIcons.instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.skype ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-skype"><a href="{{ socialIcons.skype }}" target="_blank"><i class="fa fa-skype"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.pinterest ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-pinterest"><a href="{{ socialIcons.pinterest }}" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.dribbble ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-dribbble"><a href="{{ socialIcons.dribbble }}" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.behance ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-behance"><a href="{{ socialIcons.behance }}" target="_blank"><i class="fa fa-behance"></i></a></li>
                <# } #>
                
                <# if( '' != socialIcons.whatsapp ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-whatsapp"><a href="{{ socialIcons.whatsapp }}" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                <# } #>
                
                <# if( '' != socialIcons.telegram ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-telegram"><a href="{{ socialIcons.mail }}" target="_blank"><i class="fa fa-telegram"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.mail ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-mail"><a href="{{ socialIcons.mail }}" target="_blank"><i class="fa fa-envelope"></i></a></li>
                <# } #>

                <# if( '' != socialIcons.site ) { #>
                    <li class="elementor-icon pixerex-person-list-item pixerex-person-site"><a href="{{ socialIcons.site }}" target="_blank"><i class="fa fa-link"></i></a></li>
                <# } #>

            </ul>
            <# }
        #>
        
        <div {{{ view.getRenderAttributeString('persons_container') }}}>
            <# if( 'yes' !== settings.multiple ) { #> 
            <div {{{ view.getRenderAttributeString('person_container') }}}>
                <div class="pixerex-person-image-container">
                    <div class="pixerex-person-image-wrap">
                        {{{imageHtml}}}
                    </div>
                    <# if ( 'style2' === settings.pixerex_person_style && 'yes' === settings.pixerex_person_social_enable ) { #>
                        <div class="pixerex-person-social">
                            <# getSocialIcons(); #>
                        </div>
                    <# } #>
                </div>
                <div class="pixerex-person-info">
                    <div class="pixerex-person-info-container">
                        <# if( 'style3' !== skin && '' != settings.pixerex_person_name ) { #>
                            <{{{nameHeading}}} class="pixerex-person-name">
                                <span {{{ view.getRenderAttributeString('pixerex_person_name') }}}>
                                    {{{ settings.pixerex_person_name }}}
                                </span>
                            </{{{nameHeading}}}>
                        <# }
                        
                        if( 'style3' === skin ) { #>
                            <div class="pixerex-person-title-desc-wrap">
                        <# }
                            if( '' != settings.pixerex_person_title ) { #>
                                <{{{titleHeading}}} class="pixerex-person-title">
                                    <span {{{ view.getRenderAttributeString('pixerex_person_title') }}}>
                                        {{{ settings.pixerex_person_title }}}
                                    </span>
                                </{{{titleHeading}}}>
                            <# }
                            if( '' != settings.pixerex_person_content ) { #>
                                <div class="pixerex-person-content">
                                    <div {{{ view.getRenderAttributeString('pixerex_person_content') }}}>
                                        {{{ settings.pixerex_person_content }}}
                                    </div>
                                </div>
                            <# }
                        if( 'style3' === skin ) { #>
                            </div>
                        <# }
                        
                        if( 'style3' === skin ) { #>
                            <div class="pixerex-person-name-icons-wrap">
                            <# if( '' != settings.pixerex_person_name ) { #>
                                <{{{nameHeading}}} class="pixerex-person-name">
                                    <span {{{ view.getRenderAttributeString('pixerex_person_name') }}}>
                                        {{{ settings.pixerex_person_name }}}
                                    </span>
                                </{{{nameHeading}}}>
                            <# }
                            if( 'yes' === settings.pixerex_person_social_enable ) {
                                getSocialIcons();
                            } #>
                            </div> 
                       <# }
                            
                            
                        if ( 'style1' === settings.pixerex_person_style && 'yes' === settings.pixerex_person_social_enable ) {
                            getSocialIcons();
                        } #>
                    </div>
                </div>
            </div>
            <# } else {
                _.each( persons, function( person, index ) {
                    var nameSettingKey = view.getRepeaterSettingKey( 'multiple_name', 'multiple_persons', index ),
                        titleSettingKey = view.getRepeaterSettingKey( 'multiple_title', 'multiple_persons', index ),
                        descSettingKey = view.getRepeaterSettingKey( 'multiple_description', 'multiple_persons', index );
                    
                        
                    view.addInlineEditingAttributes( nameSettingKey, 'advanced' );
                    view.addInlineEditingAttributes( titleSettingKey, 'advanced' );
                    view.addInlineEditingAttributes( descSettingKey, 'advanced' );
                    
                    var personImageHtml = '';
                    if ( person.multiple_image.url ) {
                        var personImage = {
                            id: person.multiple_image.id,
                            url: person.multiple_image.url,
                            size: settings.thumbnail_size,
                            dimension: settings.thumbnail_custom_dimension,
                            model: view.getEditModel()
                        };

                        var personImageUrl = elementor.imagesManager.getImageUrl( personImage );

                        personImageHtml = '<img src="' + personImageUrl + '"/>';

                    }
                #>
                    <div {{{ view.getRenderAttributeString('person_container') }}}>
                        <div class="pixerex-person-image-container">
                            <div class="pixerex-person-image-wrap">
                                {{{personImageHtml}}}
                            </div>
                            <# if ( 'style2' === settings.pixerex_person_style && 'yes' === person.multiple_social_enable ) { #>
                            <div class="pixerex-person-social">
                                <# getSocialIcons( person ); #>
                            </div>
                        <# } #>
                        </div>
                        <div class="pixerex-person-info">
                            <div class="pixerex-person-info-container">
                                <# if( 'style3' !== skin && '' != person.multiple_name ) { #>
                                    <{{{nameHeading}}} class="pixerex-person-name">
                                    <span {{{ view.getRenderAttributeString( nameSettingKey ) }}}>
                                        {{{ person.multiple_name }}}
                                    </span></{{{nameHeading}}}>
                                <# }
                                
                                if( 'style3' === skin ) { #>
                                    <div class="pixerex-person-title-desc-wrap">
                                <# }
                                    if( '' != person.multiple_title  ) { #>
                                        <{{{titleHeading}}} class="pixerex-person-title">
                                        <span {{{ view.getRenderAttributeString( titleSettingKey ) }}}>
                                            {{{ person.multiple_title }}}
                                        </span></{{{titleHeading}}}>
                                    <# }
                                    if( '' != person.multiple_description ) { #>
                                        <div class="pixerex-person-content">
                                            <div {{{ view.getRenderAttributeString( descSettingKey ) }}}>
                                                {{{ person.multiple_description }}}
                                            </div>
                                        </div>
                                    <# }
                                if( 'style3' === skin ) { #>
                                    </div>
                                <# }
                                
                                 if( 'style3' === skin ) { #>
                                    <div class="pixerex-person-name-icons-wrap">
                                    <# if( '' != settings.pixerex_person_name ) { #>
                                        <{{{nameHeading}}} class="pixerex-person-name">
                                        <span {{{ view.getRenderAttributeString( nameSettingKey ) }}}>
                                            {{{ person.multiple_name }}}
                                        </span></{{{nameHeading}}}>
                                    <# }
                                    if( 'yes' === person.multiple_social_enable ) {
                                        getSocialIcons( person );
                                    } #>
                                    </div>
                                <# }
                                
                                if ( 'style1' === settings.pixerex_person_style && 'yes' === person.multiple_social_enable ) {
                                    getSocialIcons( person );
                                } #>
                            </div>
                        </div>
                    </div>
                <# });
            } #> 
            
        </div>
        <?php 
    }
}
