<?php 

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if( ! defined( 'ABSPATH' ) ) exit; // No access of directly access

class Pixerex_Counter extends Widget_Base {

	public function get_name() {
		return 'pixerex-counter';
	}

	public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Counter', 'pixerex-addons-for-elementor') );
	}

	public function get_icon() {
		return 'pa-counter';
	}
    
    public function get_style_depends() {
        return [
            'pixerex-addons'
        ];
    }

	public function get_script_depends() {
		return [
            'jquery-numerator',
			'elementor-waypoints',
			'lottie-js',
            'pixerex-addons-js',
        ];
	}

	public function get_categories() {
		return [ 'pixerex-elements' ];
	}
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for the pixerex counter
	// This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {
		$this->start_controls_section('pixerex_counter_global_settings',
			[
				'label'         => __( 'Counter', 'pixerex-addons-for-elementor' )
			]
		);
        
        $this->add_control('pixerex_counter_title',
			[
				'label'			=> __( 'Title', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter title for stats counter block', 'pixerex-addons-for-elementor'),
			]
		);
        
		$this->add_control('pixerex_counter_start_value',
			[
				'label'			=> __( 'Starting Number', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 0
			]
		);
        
        $this->add_control('pixerex_counter_end_value',
			[
				'label'			=> __( 'Ending Number', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 500
			]
		);

		$this->add_control('pixerex_counter_t_separator',
			[
				'label'			=> __( 'Thousands Separator', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Separator converts 125000 into 125,000', 'pixerex-addons-for-elementor' ),
				'default'		=> ','
			]
		);

		$this->add_control('pixerex_counter_d_after',
			[
				'label'			=> __( 'Digits After Decimal Point', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 0
			]
		);

		$this->add_control('pixerex_counter_preffix',
			[
				'label'			=> __( 'Value Prefix', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter prefix for counter value', 'pixerex-addons-for-elementor' )
			]
		);

		$this->add_control('pixerex_counter_suffix',
			[
				'label'			=> __( 'Value Suffix', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'Enter suffix for counter value', 'pixerex-addons-for-elementor' )
			]
		);

		$this->add_control('pixerex_counter_speed',
			[
				'label'			=> __( 'Rolling Time', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> __( 'How long should it take to complete the digit?', 'pixerex-addons-for-elementor' ),
				'default'		=> 3
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_display_options',
			[
				'label'         => __( 'Display Options', 'pixerex-addons-for-elementor' )
			]
		);

		$this->add_control('pixerex_counter_icon_image',
		  	[
		     	'label'			=> __( 'Icon Type', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::SELECT,
                'description'   => __('Use a font awesome icon or upload a custom image', 'pixerex-addons-for-elementor'),
		     	'options'		=> [
		     		'icon'  => __('Font Awesome', 'pixerex-addons-for-elementor'),
					'custom'=> __( 'Image', 'pixerex-addons-for-elementor'),
					'animation'     => __('Lottie Animation', 'pixerex-addons-for-elementor'),
		     	],
		     	'default'		=> 'icon'
		  	]
		);

		$this->add_control('pixerex_counter_icon_updated',
		  	[
		     	'label'			=> __( 'Select an Icon', 'pixerex-addons-for-elementor' ),
		     	'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'pixerex_counter_icon',
                'default' => [
                    'value'     => 'fas fa-clock',
                    'library'   => 'fa-solid',
                ],
			  	'condition'		=> [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
		  	]
		);

		$this->add_control('pixerex_counter_image_upload',
		  	[
		     	'label'			=> __( 'Upload Image', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::MEDIA,
			  	'default'		=> [
			  		'url' => Utils::get_placeholder_image_src(),
				],
				'condition'			=> [
					'pixerex_counter_icon_image' => 'custom'
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
                'condition'         => [
                    'pixerex_counter_icon_image' => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'         => [
                    'pixerex_counter_icon_image' => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'         => [
                    'pixerex_counter_icon_image' => 'animation'
                ],
            ]
        );
        
        $this->add_control('pixerex_counter_icon_position',
			[
				'label'			=> __( 'Icon Position', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
                'description'	=> __( 'Choose a position for your icon', 'pixerex-addons-for-elementor'),
				'default'		=> 'no-animation',
				'options'		=> [
					'top'   => __( 'Top', 'pixerex-addons-for-elementor' ),
					'right' => __( 'Right', 'pixerex-addons-for-elementor' ),
					'left'  => __( 'Left', 'pixerex-addons-for-elementor' ),
				],
				'default' 		=> 'top',
				'separator' 	=> 'after'
			]
		);
        
        $this->add_control('pixerex_counter_icon_animation', 
            [
                'label'         => __('Animations', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::ANIMATION,
                'render_type'   => 'template'
            ]
		);
		
		$this->add_responsive_control('value_align',
            [
                'label'         => __( 'Value Alignment', 'pixerex-addons-for-elementor' ),
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
                    '{{WRAPPER}} .pixerex-counter-value-wrap' => 'justify-content: {{VALUE}}',
                ]
            ]
		);
		
		$this->add_responsive_control('title_align',
            [
                'label'         => __( 'Title Alignment', 'pixerex-addons-for-elementor' ),
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
                'default'       => 'center',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-title' => 'text-align: {{VALUE}};',
				],
				'condition'		=> [
					'pixerex_counter_title!' => ''
				]
            ]
        );
		
		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_icon_style_tab',
			[
				'label'         => __( 'Icon' , 'pixerex-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('pixerex_counter_icon_color',
		  	[
				'label'         => __( 'Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon i' => 'color: {{VALUE}};'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
			]
		);
        
        $this->add_responsive_control('pixerex_counter_icon_size',
		  	[
		     	'label'			=> __( 'Size', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units'	=> ['px', 'em', '%'],
		     	'default' => [
					'size' => 70,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
					'em' => [
						'min' => 1,
						'max' => 20,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image' => 'icon'
			  	]
		  	]
		);

		$this->add_responsive_control('pixerex_counter_image_size',
		  	[
		     	'label'			=> __( 'Size', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::SLIDER,
				'size_units'	=> ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
					],
					'em' => [
						'min' => 1,
						'max' => 30,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon img.custom-image' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
				],
			  	'condition'     => [
			  		'pixerex_counter_icon_image!' => 'icon'
			  	]
		  	]
		);

		$this->add_control('pixerex_counter_icon_style',
		  	[
				'label' 		=> __( 'Style', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::SELECT,
                'description'   => __('We are giving you three quick preset if you are in a hurry. Otherwise, create your own with various options', 'pixerex-addons-for-elementor'),
				'options'		=> [
					'simple'=> __( 'Simple', 'pixerex-addons-for-elementor' ),
					'circle'=> __( 'Circle Background', 'pixerex-addons-for-elementor' ),
					'square'=> __( 'Square Background', 'pixerex-addons-for-elementor' ),
					'design'=> __( 'Custom', 'pixerex-addons-for-elementor' )
				],
				'default' 		=> 'simple'
			]
		);

		$this->add_control('pixerex_counter_icon_bg',
			[
				'label' 		=> __( 'Background Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .icon-bg' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control('pixerex_counter_icon_bg_size',
		  	[
		     	'label'			=> __( 'Background size', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 150,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 600,
					]
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon span.icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				]
		  	]
		);

		$this->add_responsive_control('pixerex_counter_icon_v_align',
		  	[
		     	'label'			=> __( 'Vertical Alignment', 'pixerex-addons-for-elementor' ),
		     	'type' 			=> Controls_Manager::SLIDER,
		     	'default' => [
					'size' => 150,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 600,
					]
				],
				'condition'		=> [
					'pixerex_counter_icon_style!' => 'simple'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon span.icon' => 'line-height: {{SIZE}}{{UNIT}};'
				]
		  	]
		);
        
        
        $this->add_group_control(
        Group_Control_Border::get_type(),
            [
                'name'          => 'pixerex_icon_border',
                'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .design',
                'condition'		=> [
					'pixerex_counter_icon_style' => 'design'
				]
            ]
            );

        $this->add_control('pixerex_icon_border_radius',
			[
				'label'     => __('Border Radius', 'pixerex-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> ['px', '%' ,'em'],
				'default'   => [
					'unit'      => 'px',
					'size'      => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-icon .design' => 'border-radius: {{SIZE}}{{UNIT}};'
				],
				'condition'	=> [
					'pixerex_counter_icon_style' => 'design'
				]
			]
		);

		$this->add_responsive_control('icon_margin', 
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
		$this->start_controls_section('pixerex_counter_title_style',
			[
				'label'         => __( 'Title' , 'pixerex-addons-for-elementor' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'pixerex_counter_title!' => ''
				]
			]
		);

		$this->add_control('pixerex_counter_title_color',
			[
				'label' 		=> __( 'Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_title_typho',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title',
			]
		);

		$this->add_control('title_background',
			[
				'label' 		=> __( 'Background Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-title' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'title_border',
                'selector'      => '{{WRAPPER}} .pixerex-counter-title'
            ]
        );
        
        $this->add_control('title_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-title' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'pixerex_counter_title_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-title',
            ]
		);
		
		$this->add_responsive_control('title_margin', 
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control('title_padding', 
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
		);
		
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_value_style',
            [
                'label'         => __('Value', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
		);
        
		$this->add_control('pixerex_counter_value_color',
			[
				'label' 		=> __( 'Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-area .pixerex-counter-init' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_value_typho',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area .pixerex-counter-init',
				'separator'		=> 'after'
			]
		);

		$this->add_control('value_background',
			[
				'label' 		=> __( 'Background Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-counter-init' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'value_border',
                'selector'      => '{{WRAPPER}} .pixerex-counter-init'
            ]
        );
        
        $this->add_control('value_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-init' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
		);
		
		$this->add_responsive_control('value_margin', 
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-init' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control('value_padding', 
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-counter-init' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_counter_suffix_prefix_style',
            [
                'label'         => __('Prefix & Suffix', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
		);
        
        $this->add_control('pixerex_counter_prefix_color',
			[
				'label' 		=> __( 'Prefix Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pixerex-counter-area span#prefix' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_prefix_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area span#prefix',
                'separator'     => 'after',
			]
		);

		$this->add_control('pixerex_counter_suffix_color',
			[
				'label' 		=> __( 'Suffix Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .pixerex-counter-area span#suffix' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_counter_suffix_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .pixerex-counter-area span#suffix',
                'separator'     => 'after',
			]
		);

		$this->end_controls_section();

	}
    
    public function get_counter_content() {

		$settings = $this->get_settings_for_display();

        $start_value = $settings['pixerex_counter_start_value'];
        
    ?>
    
        <div class="pixerex-init-wrapper">

			<div class="pixerex-counter-value-wrap">
				<?php if ( ! empty( $settings['pixerex_counter_preffix'] ) ) : ?>
					<span id="prefix" class="counter-su-pre"><?php echo $settings['pixerex_counter_preffix']; ?></span>
				<?php endif; ?>

				<span class="pixerex-counter-init" id="counter-<?php echo esc_attr($this->get_id()); ?>"><?php echo $start_value; ?></span>

				<?php if ( ! empty( $settings['pixerex_counter_suffix'] ) ) : ?>
					<span id="suffix" class="counter-su-pre"><?php echo $settings['pixerex_counter_suffix']; ?></span>
				<?php endif; ?>
			</div>

            <?php if ( ! empty( $settings['pixerex_counter_title'] ) ) : ?>
                <h4 class="pixerex-counter-title">
                    <div <?php echo $this->get_render_attribute_string('pixerex_counter_title'); ?>>
                        <?php echo $settings['pixerex_counter_title'];?>
                    </div>
                </h4>
            <?php endif; ?>
        </div>

    <?php   
    }
    
    public function get_counter_icon() {
		
		$settings = $this->get_settings_for_display();
		
        $icon_style = $settings['pixerex_counter_icon_style'] != 'simple' ? ' icon-bg ' . $settings['pixerex_counter_icon_style'] : '';
        
        $animation = $settings['pixerex_counter_icon_animation'];
		
		$icon_type = $settings['pixerex_counter_icon_image'];

		$flex_width = '';

        if ( 'icon' === $icon_type ) {
            if ( ! empty ( $settings['pixerex_counter_icon'] )  ) {
                $this->add_render_attribute( 'icon', 'class', $settings['pixerex_counter_icon'] );
                $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
            }
            
            $migrated = isset( $settings['__fa4_migrated']['pixerex_counter_icon_updated'] );
			$is_new = empty( $settings['pixerex_counter_icon'] ) && Icons_Manager::is_migration_allowed();
			
        } elseif( 'custom' === $icon_type ) {
            $alt = esc_attr( Control_Media::get_image_alt( $settings['pixerex_counter_image_upload'] ) );
            
            $this->add_render_attribute( 'image', 'class', 'custom-image' );
            $this->add_render_attribute( 'image', 'src', $settings['pixerex_counter_image_upload']['url'] );
			$this->add_render_attribute( 'image', 'alt', $alt );
			
			if( $settings['pixerex_counter_icon_style'] == 'simple' ) {
				$flex_width = ' flex-width ';
			}
        } else  {
			$this->add_render_attribute( 'counter_lottie', [
                'class' => [
					'pixerex-counter-animation',
					'pixerex-lottie-animation'
				],
                'data-lottie-url' => $settings['lottie_url'],
                'data-lottie-loop' => $settings['lottie_loop'],
                'data-lottie-reverse' => $settings['lottie_reverse'],
            ]);
		}
        
        ?>

        <div class="pixerex-counter-icon">
            
            <span class="icon<?php echo $flex_width; ?><?php echo $icon_style; ?>" data-animation="<?php echo $animation; ?>">

                <?php if( 'icon' === $icon_type && ( ! empty( $settings['pixerex_counter_icon_updated']['value'] ) || ! empty( $settings['pixerex_counter_icon'] ) ) ) : ?>
                    <?php if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['pixerex_counter_icon_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif; ?>
                <?php elseif( 'custom' === $icon_type && ! empty( $settings['pixerex_counter_image_upload']['url'] ) ) : ?>
                    <img <?php echo $this->get_render_attribute_string('image'); ?>>
				<?php else: ?>
					<div <?php echo $this->get_render_attribute_string( 'counter_lottie' ); ?>></div>
				<?php endif; ?>
            
            </span>
        </div>

    <?php
    }

	protected function render() {
        
		$settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('pixerex_counter_title');
         
		$position = $settings['pixerex_counter_icon_position'];
		
 		$flex_width = '';
 		if( $settings['pixerex_counter_icon_image'] == 'custom' && $settings['pixerex_counter_icon_style'] == 'simple' ) {
 			$flex_width = ' flex-width ';
 		}
        
        $this->add_render_attribute( 'counter', [
                'class' 			=> [ 'pixerex-counter', 'pixerex-counter-area', $position ],
				'data-duration' 	=> $settings['pixerex_counter_speed'] * 1000,
				'data-from-value' 	=> $settings['pixerex_counter_start_value'],
				'data-to-value' 	=> $settings['pixerex_counter_end_value'],
                'data-delimiter'	=> $settings['pixerex_counter_t_separator'],
                'data-rounding' 	=> empty ( $settings['pixerex_counter_d_after'] ) ? 0  : $settings['pixerex_counter_d_after']
            ]
        );

		?>

		<div <?php echo $this->get_render_attribute_string('counter'); ?>>
			<?php
				$this->get_counter_icon();
                $this->get_counter_content();
            ?>
        </div>

		<?php
	}
    
    protected function _content_template() {
        ?>
        <#
            
            var iconImage,
                position;
                
            view.addInlineEditingAttributes('title');
            
            position = settings.pixerex_counter_icon_position;

            var delimiter = settings.pixerex_counter_t_separator,
                round     = '' === settings.pixerex_counter_d_after ? 0 : settings.pixerex_counter_d_after;
            
            view.addRenderAttribute( 'counter', 'class', [ 'pixerex-counter', 'pixerex-counter-area', position ] );
            view.addRenderAttribute( 'counter', 'data-duration', settings.pixerex_counter_speed * 1000 );
			view.addRenderAttribute( 'counter', 'data-from-value', settings.pixerex_counter_start_value );
            view.addRenderAttribute( 'counter', 'data-to-value', settings.pixerex_counter_end_value );
            view.addRenderAttribute( 'counter', 'data-delimiter', delimiter );
            view.addRenderAttribute( 'counter', 'data-rounding', round );
            
            function getCounterContent() {
            
                var startValue = settings.pixerex_counter_start_value;
                
                view.addRenderAttribute( 'counter_wrap', 'class', 'pixerex-init-wrapper' );
                
                view.addRenderAttribute( 'value', 'id', 'counter-' + view.getID() );
                
                view.addRenderAttribute( 'value', 'class', 'pixerex-counter-init' );
                
            #>
            
                <div {{{ view.getRenderAttributeString('counter_wrap') }}}>

					<div class="pixerex-counter-value-wrap">
						<# if ( '' !== settings.pixerex_counter_preffix ) { #>
							<span id="prefix" class="counter-su-pre">{{{ settings.pixerex_counter_preffix }}}</span>
						<# } #>

						<span {{{ view.getRenderAttributeString('value') }}}>{{{ startValue }}}</span>

						<# if ( '' !== settings.pixerex_counter_suffix ) { #>
							<span id="suffix" class="counter-su-pre">{{{ settings.pixerex_counter_suffix }}}</span>
						<# } #>
					</div>

                    <# if ( '' !== settings.pixerex_counter_title ) { #>
                        <h4 class="pixerex-counter-title">
                            <div {{{ view.getRenderAttributeString('title') }}}>
                                {{{ settings.pixerex_counter_title }}}
                            </div>
                        </h4>
                    <# } #>
                </div>
            
            <#
            }
            
            function getCounterIcon() {
            
                var iconStyle = 'simple' !== settings.pixerex_counter_icon_style ? ' icon-bg ' + settings.pixerex_counter_icon_style : '',
                    animation = settings.pixerex_counter_icon_animation,
                    flexWidth = '';

				var iconType = settings.pixerex_counter_icon_image;
                
				if( 'icon' === iconType ) {
					var iconHTML = elementor.helpers.renderIcon( view, settings.pixerex_counter_icon_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                    	migrated = elementor.helpers.isIconMigrated( settings, 'pixerex_counter_icon_updated' );
				} else if( 'custom' === iconType ) {
					if( 'simple' ===  settings.pixerex_counter_icon_style ) {
						flexWidth = ' flex-width ';
					}
				} else {

					view.addRenderAttribute( 'counter_lottie', {
                        'class': [
                            'pixerex-counter-animation',
                            'pixerex-lottie-animation'
                        ],
                        'data-lottie-url': settings.lottie_url,
                        'data-lottie-loop': settings.lottie_loop,
                        'data-lottie-reverse': settings.lottie_reverse
                    });

				}
                
                
                view.addRenderAttribute( 'icon_wrap', 'class', 'pixerex-counter-icon');
                
                var iconClass = 'icon' + flexWidth + iconStyle;
            
            #>

            <div {{{ view.getRenderAttributeString('icon_wrap') }}}>
                <span data-animation="{{ animation }}" class="{{ iconClass }}">
                    <# if( 'icon' === iconType && ( '' !== settings.pixerex_counter_icon_updated.value || '' !== settings.pixerex_counter_icon ) ) {
                        if ( iconHTML && iconHTML.rendered && ( ! settings.pixerex_counter_icon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ settings.pixerex_counter_icon }}" aria-hidden="true"></i>
                        <# } #>
                    <# } else if( 'custom' === iconType && '' !== settings.pixerex_counter_image_upload.url ) { #>
                        <img class="custom-image" src="{{ settings.pixerex_counter_image_upload.url }}">
                    <# } else { #>
						<div {{{ view.getRenderAttributeString('counter_lottie') }}}></div>
					<# } #>
                </span>
            </div>
            
            <#
            }
           
        #>
        
        <div {{{ view.getRenderAttributeString('counter') }}}>
			<#
				getCounterIcon();
                getCounterContent();
        	#>
        </div>
        
        <?php
    }
}