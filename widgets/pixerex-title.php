<?php

/**
 * Class: Pixerex_Title
 * Name: Title
 * Slug: pixerex-addon-title
 */

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use PixerexAddons\Includes;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Title extends Widget_Base {

    protected $templateInstance;

    public function getTemplateInstance(){
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }
    
    public function get_name() {
        return 'pixerex-addon-title';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Title', 'pixerex-addons-for-elementor') );
	}

    public function get_icon() {
        return 'pa-title';
    }
    
    public function get_style_depends() {
        return [
            'pixerex-addons'
        ];
    }

    public function get_script_depends() {
        return [
            'lottie-js'
        ];
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }

    public function get_keywords() {
		return [ 'heading', 'text' ];
	}
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}
    
    // Adding the controls fields for the pixerex title
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /* Start Title General Settings Section */
        $this->start_controls_section('pixerex_title_content',
            [
                'label'         => __('Title', 'pixerex-addons-for-elementor'),
            ]
        );
        
        /*Title Text*/ 
        $this->add_control('pixerex_title_text',
            [
                'label'         => __('Title', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Pixerex Title','pixerex-addons-for-elementor'),
                'label_block'   => true,
                'dynamic'       => [ 'active' => true ]
            ]
        );
        
        $this->add_control('pixerex_title_style', 
            [
                'label'         => __('Style', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'style1',
                'options'       => [
                    'style1'        => __('Style 1', 'pixerex-addons-for-elementor'),
                    'style2'        => __('Style 2', 'pixerex-addons-for-elementor'),
                    'style3'        => __('Style 3', 'pixerex-addons-for-elementor'),
                    'style4'        => __('Style 4', 'pixerex-addons-for-elementor'),
                    'style5'        => __('Style 5', 'pixerex-addons-for-elementor'),
                    'style6'        => __('Style 6', 'pixerex-addons-for-elementor'),
                    'style7'        => __('Style 7', 'pixerex-addons-for-elementor'),
                    ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_title_icon_switcher',
            [
                'label'         => __('Icon', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('icon_type',
            [
                'label'			=> __( 'Icon Type', 'pixerex-addons-for-elementor' ),
                'type' 			=> Controls_Manager::SELECT,
                'options'		=> [
                    'icon'          => __('Icon', 'pixerex-addons-for-elementor'),
                    'image'         => __('Image', 'pixerex-addons-for-elementor'),
                    'animation'     => __('Lottie Animation', 'pixerex-addons-for-elementor'),
                ],
                'default'		=> 'icon',
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_title_icon_updated', 
            [
                'label'         => __('Font Awesome Icon', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_title_icon',
                'default'       => [
                    'value'         => 'fas fa-bars',
                    'library'       => 'fa-solid',
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_type'   => 'icon',
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
				'condition'			=> [
					'pixerex_title_icon_switcher'   => 'yes',
                    'icon_type'   => 'image',
				],
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
                    'pixerex_title_icon_switcher'   => 'yes',
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
                    'pixerex_title_icon_switcher'   => 'yes',
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
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_type'   => 'animation',
                ]
            ]
        );

        $this->add_responsive_control('icon_position',
            [
                'label'         => __( 'Icon Position', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'row'           => __('Before', 'pixerex-addons-for-elementor'),
                    'row-reverse'   => __('After', 'pixerex-addons-for-elementor'),
                    'column'        => __('Top', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'row',
                'toggle'        => false,
                'render_type'   => 'template',
                'prefix_class'  => 'pixerex-title-icon-',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-header:not(.pixerex-title-style7), {{WRAPPER}} .pixerex-title-style7-inner' => 'flex-direction: {{VALUE}}',
                ],
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes'
                ],
            ]
        );

        $this->add_responsive_control('top_icon_align',
            [
                'label'         => __( 'Icon Alignment', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'      => [
                        'title'=> __( 'Left', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}}.pixerex-title-icon-column .pixerex-title-header:not(.pixerex-title-style7)' => 'align-items: {{VALUE}}',
                    '{{WRAPPER}}.pixerex-title-icon-column .pixerex-title-style7 .pixerex-title-icon'      => 'align-self: {{VALUE}}',
                ],
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_position'                 => 'column',
                    'pixerex_title_style!'           => [ 'style3', 'style4' ]
                ]
            ]
        );

        $this->add_control('pixerex_title_tag',
            [
                'label'         => __('HTML Tag', 'pixerex-addons-for-elementor'),
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
                ],
                'separator'     => 'before',
            ]
        );

        $inline_flex = [ 'style1', 'style2', 'style5', 'style6', 'style7' ];
        
        $this->add_responsive_control('pixerex_title_align',
            [
                'label'         => __( 'Alignment', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'left',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-container' => 'text-align: {{VALUE}};',
                ],
                'condition'     => [
                    'pixerex_title_style'  => $inline_flex
                ]
            ]
        );

        $this->add_responsive_control('pixerex_title_align_flex',
            [
                'label'         => __( 'Alignment', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'      => [
                        'title'=> __( 'Left', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'flex-start',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}}:not(.pixerex-title-icon-column) .pixerex-title-header' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}}.pixerex-title-icon-column .pixerex-title-header' => 'align-items: {{VALUE}}',
                ],
                'condition'     => [
                    'pixerex_title_style'  => [ 'style3', 'style4' ]
                ]
            ]
        );

        $this->add_control('alignment_notice', 
            [
                'raw'               => __('Please note that left/right alignment is reversed when Icon Position is set to After.', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_position'                 => 'row-reverse',
                    'pixerex_title_style'  => [ 'style3', 'style4']
                ]
            ] 
        );
        
        $this->add_control('pixerex_title_stripe_pos', 
            [
                'label'         => __('Stripe Position', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'top'    => __('Top', 'pixerex-addons-for-elementor'),
                    'bottom' => __('Bottom', 'pixerex-addons-for-elementor')
                ],
                'selectors_dictionary'  => [
                    'top'      => 'initial',
                    'bottom'    => '2',
                ],
                'default'       => 'top',
                'label_block'   => true,
                'separator'     => 'before',
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe-wrap' => 'order: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_style7_strip_width',
            [
                'label'         => __('Stripe Width (PX)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'default'       => [
                    'unit'  => 'px',
                    'size'  => '120',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_style7_strip_height',
            [
                'label'         => __('Stripe Height (PX)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'default'       => [
                    'unit'  => 'px',
                    'size'  => '5',
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_style7_strip_top_spacing',
            [
                'label'         => __('Stripe Top Spacing (PX)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_title_style7_strip_bottom_spacing',
            [
                'label'         => __('Stripe Bottom Spacing (PX)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_style7_strip_align',
            [
                'label'         => __( 'Stripe Alignment', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'    => [
                        'title' => __( 'Left', 'pixerex-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-left',
                        ],
                    'center'        => [
                        'title' => __( 'Center', 'pixerex-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-center',
                        ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'toggle'        => false,
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}}:not(.pixerex-title-icon-column) .pixerex-title-style7-stripe-wrap' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}}.pixerex-title-icon-column .pixerex-title-style7-stripe-wrap' => 'align-self: {{VALUE}}',
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style7',
                ]
            ]
        );

        $this->add_control('link_switcher',
            [
                'label'         => __('Link', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('link_selection', 
            [
                'label'         => __('Link Type', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'pixerex-addons-for-elementor'),
                    'link'  => __('Existing Page', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'link_switcher'     => 'yes',
                ]
            ]
        );
        
        $this->add_control('custom_link',
            [
                'label'         => __('Link', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://pixerexaddons.com/',
                'label_block'   => true,
                'separator'     => 'after',
                'condition'     => [
                    'link_switcher'     => 'yes',
                    'link_selection'   => 'url'
                ]
            ]
        );
        
        $this->add_control('existing_link',
            [
                'label'         => __('Existing Page', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'condition'     => [
                    'link_switcher'         => 'yes',
                    'link_selection'       => 'link',
                ],
                'multiple'      => false,
                'label_block'   => true,
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_title_style_section',
            [
                'label'         => __('Title', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_title_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-header' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'title_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-title-header',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'style_one_border',
                'selector'      => '{{WRAPPER}} .pixerex-title-style1',
                'condition'     => [
                    'pixerex_title_style'   => 'style1',
                ],
            ]
        );
        
        $this->add_control('pixerex_title_style2_background_color', 
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style2' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style2',
                ],
            ]
        );
        
        $this->add_control('pixerex_title_style3_background_color', 
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style3' => 'background-color: {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style3'
                ]
            ]
        );
        
        $this->add_control('pixerex_title_style5_header_line_color', 
            [
                'label'         => __('Line Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style5' => 'border-bottom: 2px solid {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style5'
                ]
            ]
        );
       
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'style_five_border',
                'selector'      => '{{WRAPPER}} .pixerex-title-container',
                'condition'     => [
                    'pixerex_title_style'   => ['style2','style4','style5','style6']
                ]
            ]
        );
        
        $this->add_control('pixerex_title_style6_header_line_color', 
            [
                'label'         => __('Line Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style6' => 'border-bottom: 2px solid {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style6'
                ]
            ]
        );
       
        $this->add_control('pixerex_title_style6_triangle_color', 
            [
                'label'         => __('Triangle Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style6:before' => 'border-bottom-color: {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style6'
                ]
            ]
        );
        
        $this->add_control('pixerex_title_style7_strip_color', 
            [
                'label'         => __('Stripe Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-style7-stripe' => 'background-color: {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_style'   => 'style7'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-addons-for-elementor'),
                'name'          => 'pixerex_title_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-title-header'
            ]
        );
        
        $this->add_responsive_control('pixerex_title_margin', 
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_title_padding', 
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_title_icon_style_section',
            [
                'label'         => __('Icon', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_title_icon_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-icon' => 'color: {{VALUE}};'
                ],
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_type'                     => 'icon'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_icon_size', 
            [
                'label'         => __('Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
                    ],
                    'em' => [
						'min' => 1,
						'max' => 30,
					]
				],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-header i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-title-header svg, {{WRAPPER}} .pixerex-title-header img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'          => 'pixerex_title_icon_background',
                'types'         => [ 'classic' , 'gradient' ],
                'selector'      => '{{WRAPPER}} .pixerex-title-icon'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pixerex_title_icon_border',
                'selector'      => '{{WRAPPER}} .pixerex-title-icon'
            ]
        );
        
        $this->add_control('pixerex_title_icon_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-icon' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_icon_margin',
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_title_icon_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-title-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow', 'pixerex-addons-for-elementor'),
                'name'          => 'pixerex_title_icon_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-title-icon',
                'condition'     => [
                    'pixerex_title_icon_switcher'   => 'yes',
                    'icon_type'                     => 'icon'
                ]
            ]
        );
        
        $this->end_controls_section();

    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes('pixerex_title_text', 'none');

        $this->add_render_attribute('pixerex_title_text', 'class', 'pixerex-title-text');
        
        $title_tag = $settings['pixerex_title_tag'];
        
        $selected_style = $settings['pixerex_title_style'];
        
        $this->add_render_attribute( 'container', 'class', [ 'pixerex-title-container', $selected_style ] );
        
        $this->add_render_attribute( 'title', 'class', [ 'pixerex-title-header', 'pixerex-title-' . $selected_style ] );
        
        if( 'yes' === $settings['pixerex_title_icon_switcher'] ) {

            $icon_type = $settings['icon_type'];

            $icon_position = $settings['icon_position'];

            if( 'icon' === $icon_type ) {

                if ( ! empty ( $settings['pixerex_title_icon'] ) ) {
                    $this->add_render_attribute( 'icon', 'class', $settings['pixerex_title_icon'] );
                    $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
                }
                
                $migrated = isset( $settings['__fa4_migrated']['pixerex_title_icon_updated'] );
                $is_new = empty( $settings['pixerex_title_icon'] ) && Icons_Manager::is_migration_allowed();

            } elseif( 'animation' === $icon_type ) {
                $this->add_render_attribute( 'title_lottie', [
                    'class' => [
                        'pixerex-title-icon',
                        'pixerex-lottie-animation'
                    ],
                    'data-lottie-url' => $settings['lottie_url'],
                    'data-lottie-loop' => $settings['lottie_loop'],
                    'data-lottie-reverse' => $settings['lottie_reverse']
                ]);
            } else {

                $src        = $settings['image_upload']['url'];

                $alt        = Control_Media::get_image_alt( $settings['image_upload'] );

                $this->add_render_attribute( 'title_img', [
                    'class' => 'pixerex-title-icon',
                    'src'   => $src,
                    'alt'   => $alt
                ]);
            }
        }

        if( $settings['link_switcher'] === 'yes' ) {

            $link = '';

            if( $settings['link_selection'] === 'link' ) {

                $link = get_permalink( $settings['existing_link'] );

            } else {

                $link = $settings['custom_link']['url'];

            }

            $this->add_render_attribute( 'link', 'href', $link );

            if( ! empty( $settings['custom_link']['is_external'] ) ) {
                $this->add_render_attribute( 'link', 'target', "_blank" );
            }

            if( ! empty( $settings['custom_link']['nofollow'] ) ) {
                $this->add_render_attribute( 'link', 'rel',  "nofollow" );
            }
        }

    ?>

    <div <?php echo $this->get_render_attribute_string('container'); ?>>
        <<?php echo $title_tag . ' ' . $this->get_render_attribute_string('title') ; ?>>
            <?php if ( $selected_style === 'style7' ) : ?>
                <?php if( 'column' !== $icon_position ) : ?>
                    <span class="pixerex-title-style7-stripe-wrap">
                        <span class="pixerex-title-style7-stripe"></span>
                    </span>
                <?php endif; ?>
                <div class="pixerex-title-style7-inner">
            <?php endif; ?>

            <?php if( 'yes' === $settings['pixerex_title_icon_switcher'] ) : ?>
                <?php if( 'icon' === $icon_type ) : ?>
                    <?php if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_title_icon_updated'], [ 'class' => 'pixerex-title-icon', 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif; ?>
                <?php elseif( 'animation' === $icon_type ): ?>
                    <div <?php echo $this->get_render_attribute_string( 'title_lottie' ); ?>></div>
                <?php else: ?>
                    <img <?php echo $this->get_render_attribute_string( 'title_img' ); ?>>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( $selected_style === 'style7' ) : ?>
                <?php if( 'column' === $icon_position ) : ?>
                    <span class="pixerex-title-style7-stripe-wrap">
                        <span class="pixerex-title-style7-stripe"></span>
                    </span>
                <?php endif; ?>
            <?php endif; ?>

            <span <?php echo $this->get_render_attribute_string('pixerex_title_text'); ?>>
                <?php echo esc_html( $settings['pixerex_title_text'] ); ?>
            </span>
            <?php if ( $selected_style === 'style7' ) : ?>
                </div>
            <?php endif; ?>
            <?php if( $settings['link_switcher'] === 'yes' && !empty( $link ) ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
            <?php endif; ?>
        </<?php echo $title_tag; ?>>
    </div>

    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
            
            view.addInlineEditingAttributes('pixerex_title_text', 'none');
        
            view.addRenderAttribute('pixerex_title_text', 'class', 'pixerex-title-text');

            var titleTag = settings.pixerex_title_tag,
        
            selectedStyle = settings.pixerex_title_style,
            
            titleIcon = settings.pixerex_title_icon,
            
            titleText = settings.pixerex_title_text;
            
            view.addRenderAttribute( 'pixerex_title_container', 'class', [ 'pixerex-title-container', selectedStyle ] );
            
            view.addRenderAttribute( 'pixerex_title', 'class', [ 'pixerex-title-header', 'pixerex-title-' + selectedStyle ] );
            
            view.addRenderAttribute( 'icon', 'class', [ 'pixerex-title-icon', titleIcon ] );
            
            if( 'yes' === settings.pixerex_title_icon_switcher ) {

                var iconType = settings.icon_type,
                    iconPosition = settings.icon_position;

                if( 'icon' === iconType ) {
                    var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_title_icon_updated, { 'class': 'pixerex-title-icon', 'aria-hidden': true }, 'i' , 'object' ),
                        migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_title_icon_updated' );
                } else if( 'animation' === iconType ) {

                    view.addRenderAttribute( 'title_lottie', {
                        'class': [
                            'pixerex-title-icon',
                            'pixerex-lottie-animation'
                        ],
                        'data-lottie-url': settings.lottie_url,
                        'data-lottie-loop': settings.lottie_loop,
                        'data-lottie-reverse': settings.lottie_reverse
                    });
                    
                } else {

                    view.addRenderAttribute( 'title_img', 'class', 'pixerex-title-icon' );
                    view.addRenderAttribute( 'title_img', 'src', settings.image_upload.url );

                }
                
            }

            if( 'yes' === settings.link_switcher ) {

                var link = '';

                if( settings.link_selection === 'link' ) {

                    link = settings.existing_link;

                } else {

                    link = settings.custom_link.url;

                }

                view.addRenderAttribute( 'link', 'href', link );

            }
        
        #>
        <div {{{ view.getRenderAttributeString('pixerex_title_container') }}}>
            <{{{titleTag}}} {{{view.getRenderAttributeString('pixerex_title')}}}>
                <# if( 'style7' === selectedStyle ) { #>
                    <# if( 'column' !== iconPosition ) { #>
                        <span class="pixerex-title-style7-stripe-wrap">
                            <span class="pixerex-title-style7-stripe"></span>
                        </span>    
                    <# } #>
                    <div class="pixerex-title-style7-inner">
                <# } 
                    if( 'yes' === settings.pixerex_title_icon_switcher ) { #>
                        <# if( 'icon' === iconType ) { #>
                            <# if ( iconHTML && iconHTML.rendered && ( ! settings.pixerex_title_icon || migrated ) ) { #>
                                {{{ iconHTML.value }}}
                            <# } else { #>
                                <i {{{ view.getRenderAttributeString( 'icon' ) }}}></i>
                            <# } #>
                        <# } else if( 'animation' === iconType ) { #>
                            <div {{{ view.getRenderAttributeString('title_lottie') }}}></div>
                        <# } else { #>
                            <img {{{ view.getRenderAttributeString('title_img') }}}>
                        <# } #>
                    <# } #>
                <# if( 'style7' === selectedStyle ) { #>
                    <# if( 'column' === iconPosition ) { #>
                        <span class="pixerex-title-style7-stripe-wrap">
                            <span class="pixerex-title-style7-stripe"></span>
                        </span>
                    <# } #>
                <# } #>
                <span {{{ view.getRenderAttributeString('pixerex_title_text') }}}>{{{ titleText }}}</span>
                <# if( 'style7' === selectedStyle ) { #>
                    </div>
                <# } #>
                <# if( 'yes' === settings.link_switcher && '' !== link ) { #>
                    <a {{{ view.getRenderAttributeString('link') }}}></a>
                <# } #>
            </{{{titleTag}}}>
        </div>
        
        <?php
    }
}