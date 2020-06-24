<?php

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Fancytext extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-fancy-text';
    }

    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Fancy Text', 'pixerex-addons-for-elementor') );
	}

    public function get_icon() {
        return 'pa-fancy-text';
    }
    
    public function get_style_depends() {
        return [
            'pixerex-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'typed-js',
            'vticker-js',
            'pixerex-addons-js'
        ];
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for the pixerex fancy text
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /*Start Text Content Section*/
        $this->start_controls_section('pixerex_fancy_text_content',
                [
                    'label'         => __('Fancy Text', 'pixerex-addons-for-elementor'),
                    ]
                );
        
        /*Prefix Text*/ 
        $this->add_control('pixerex_fancy_prefix_text',
                [
                    'label'         => __('Prefix', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('This is', 'pixerex-addons-for-elementor'),
                    'description'   => __( 'Text before Fancy text', 'pixerex-addons-for-elementor' ),
                    'label_block'   => true,
                ]
                );
        
        $repeater = new REPEATER();
        
        $repeater->add_control('pixerex_text_strings_text_field',
            [
                'label'       => __( 'Fancy String', 'pixerex-addons-for-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        
        /*Fancy Text Strings*/
        $this->add_control('pixerex_fancy_text_strings',
            [
                'label'         => __( 'Fancy Text', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [
                    [
                        'pixerex_text_strings_text_field' => __( 'Designer', 'pixerex-addons-for-elementor' ),
                        ],
                    [
                        'pixerex_text_strings_text_field' => __( 'Developer', 'pixerex-addons-for-elementor' ),
                        ],
                    [
                        'pixerex_text_strings_text_field' => __( 'Awesome', 'pixerex-addons-for-elementor' ),
                        ],
                    ],
                'fields'        => array_values( $repeater->get_controls() ),
                'title_field'   => '{{{ pixerex_text_strings_text_field }}}',
            ]
        );

		/*Prefix Text*/ 
        $this->add_control('pixerex_fancy_suffix_text',
                [
                    'label'         => __('Suffix', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('Text', 'pixerex-addons-for-elementor'),
                    'description'   => __( 'Text after Fancy text', 'pixerex-addons-for-elementor' ),
                    'label_block'   => true,
                ]
                );
        
        /*Front Text Align*/
        $this->add_responsive_control('pixerex_fancy_text_align',
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
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-fancy-text-wrapper' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_fancy_additional_settings',
            [
                'label'         => __('Additional Settings', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_fancy_text_effect', 
            [
                'label'         => __('Effect', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'typing' => __('Typing', 'pixerex-addons-for-elementor'),
                    'slide'  => __('Slide Up', 'pixerex-addons-for-elementor'),
                    'zoomout'=> __('Zoom Out', 'pixerex-addons-for-elementor'),
                    'rotate' => __('Rotate', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'typing',
                'render_type'   => 'template',
                'label_block'   => true,
            ]
        );

        $this->add_control('pixerex_fancy_text_type_speed',
            [
                'label'         => __('Type Speed', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 30,
                'description'   => __( 'Set typing effect speed in milliseconds.', 'pixerex-addons-for-elementor' ),
                'condition'     => [
                    'pixerex_fancy_text_effect' => 'typing',
                ],
            ]
        );
        
        $this->add_control('pixerex_fancy_text_zoom_speed',
            [
                'label'         => __('Animation Speed', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'description'   => __('Set animation speed in seconds.', 'pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_fancy_text_effect' => [ 'zoomout', 'rotate' ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-fancy-text-wrapper.zoomout .pixerex-fancy-list-items, .pixerex-fancy-text-wrapper.rotate .pixerex-fancy-list-items'   => 'animation-duration: {{VALUE}}s'
                ]
            ]
        );
        
        $this->add_control('pixerex_fancy_text_zoom_delay',
            [
                'label'         => __('Animation Delay', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'description'   => __('Set animation speed in seconds.', 'pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_fancy_text_effect' => [ 'zoomout', 'rotate' ],
                ]
            ]
        );
        
        $this->add_control('pixerex_fancy_text_back_speed',
            [
                'label'         => __('Back Speed', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 30,
                'description'   => __( 'Set a speed for backspace effect in milliseconds.', 'pixerex-addons-for-elementor' ),
                'condition'     => [
                    'pixerex_fancy_text_effect' => 'typing',
                ],
            ]
        );
        
        $this->add_control('pixerex_fancy_text_start_delay',
            [
                'label'         => __('Start Delay', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 30,
                'description'   => __( 'If you set it on 5000 milliseconds, the first word/string will appear after 5 seconds.', 'pixerex-addons-for-elementor' ),
                'condition'     => [
                    'pixerex_fancy_text_effect' => 'typing',
                ],
            ]
        );
        
        /*Back Delay*/
        $this->add_control('pixerex_fancy_text_back_delay',
                [
                    'label'         => __('Back Delay', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 30,
                    'description'   => __( 'If you set it on 5000 milliseconds, the word/string will remain visible for 5 seconds before backspace effect.', 'pixerex-addons-for-elementor' ),
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'typing',
                        ],
                ]
                );
        
        /*Type Loop*/
        $this->add_control('pixerex_fancy_text_type_loop',
                [
                    'label'         => __('Loop','pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'typing',
                        ],
                    ]
                );
        
        /*Show Cursor*/
        $this->add_control('pixerex_fancy_text_show_cursor',
                [
                    'label'         => __('Show Cursor','pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'typing',
                        ],
                    ]
                );
        
        /*Cursor Text*/
        $this->add_control('pixerex_fancy_text_cursor_text',
                [
                    'label'         => __('Cursor Mark', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => '|',
                    'condition'     => [
                        'pixerex_fancy_text_effect'     => 'typing',
                        'pixerex_fancy_text_show_cursor'=> 'yes',
                        ],
                    ]
                );
        
        /*Slide Up Speed*/
        $this->add_control('pixerex_slide_up_speed',
                [
                    'label'         => __('Animation Speed', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 200,
                    'description'   => __( 'Set a duration value in milliseconds for slide up effect.', 'pixerex-addons-for-elementor' ),
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'slide',
                        ],
                ]
                );
        
        /*Slide Up Pause Time*/
        $this->add_control('pixerex_slide_up_pause_time',
                [
                    'label'         => __('Pause Time (Milliseconds)', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 3000,
                    'description'   => __( 'How long should the word/string stay visible? Set a value in milliseconds.', 'pixerex-addons-for-elementor' ),
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'slide',
                        ],
                ]
                );
        
        /*Slide Up Shown Items*/
        $this->add_control('pixerex_slide_up_shown_items',
                [
                    'label'         => __('Show Items', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 1,
                    'description'   => __( 'How many items should be visible at a time?', 'pixerex-addons-for-elementor' ),
                    'condition'     => [
                        'pixerex_fancy_text_effect' => 'slide',
                        ],
                ]
                );
        
        /*Pause on Hover*/
        $this->add_control('pixerex_slide_up_hover_pause',
            [
                'label'         => __('Pause on Hover','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __( 'If you enabled this option, the slide will be paused when mouseover.', 'pixerex-addons-for-elementor' ),
                'condition'     => [
                    'pixerex_fancy_text_effect' => 'slide',
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_fancy_slide_align',
            [
                'label'         => __( 'Fancy Text Alignment', 'pixerex-addons-for-elementor' ),
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
                    '{{WRAPPER}} .pixerex-fancy-list-items' => 'text-align: {{VALUE}};',
                ],
                'condition'     => [
                    'pixerex_fancy_text_effect' => 'slide',
                ],
            ]
        );
       
        $this->end_controls_section();
        
        /*Start Fancy Text Settings Tab*/
        $this->start_controls_section('pixerex_fancy_text_style_tab',
                [
                    'label'         => __('Fancy Text', 'pixerex-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Fancy Text Color*/
        $this->add_control('pixerex_fancy_text_color',
                [
                    'label'         => __('Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-fancy-text' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
         /*Fancy Text Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'fancy_text_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-fancy-text',
                    ]
                );  
        
        /*Fancy Text Background Color*/
        $this->add_control('pixerex_fancy_text_background_color',
                [
                    'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-fancy-text' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-fancy-text',
            ]
        );
      
        /*End Fancy Text Settings Tab*/
        $this->end_controls_section();

        /*Start Cursor Settings Tab*/
        $this->start_controls_section('pixerex_fancy_cursor_text_style_tab',
                [
                    'label'         => __('Cursor Text', 'pixerex-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pixerex_fancy_text_cursor_text!'   => ''
                ]
            ]
        );
        
        /*Cursor Color*/
        $this->add_control('pixerex_fancy_text_cursor_color',
                [
                    'label'         => __('Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .typed-cursor' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
         /*Cursor Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'fancy_text_cursor_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .typed-cursor',
                    ]
                );  
        
        /*Cursor Background Color*/
        $this->add_control('pixerex_fancy_text_cursor_background',
                [
                    'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .typed-cursor' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
      
        /*End Fancy Text Settings Tab*/
        $this->end_controls_section();
        
        /*Start Prefix Suffix Text Settings Tab*/
        $this->start_controls_section('pixerex_prefix_suffix_style_tab',
                [
                    'label'         => __('Prefix & Suffix', 'pixerex-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Prefix Suffix Text Color*/
        $this->add_control('pixerex_prefix_suffix_text_color',
                [
                    'label'         => __('Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-prefix-text, {{WRAPPER}} .pixerex-suffix-text' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        /*Prefix Suffix Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'prefix_suffix_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-prefix-text, {{WRAPPER}} .pixerex-suffix-text',
                ]
                );
        
        /*Prefix Suffix Text Background Color*/
        $this->add_control('pixerex_prefix_suffix_text_background_color',
                [
                    'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-prefix-text, {{WRAPPER}} .pixerex-suffix-text' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        /*End Prefix Suffix Text Settings Tab*/
        $this->end_controls_section();
    }

    protected function render() {
        
        $settings   = $this->get_settings_for_display();
        
        $effect     = $settings['pixerex_fancy_text_effect'];
        
        if( $effect === 'typing' ) {
            
            $show_cursor = ( ! empty( $settings['pixerex_fancy_text_show_cursor'] ) ) ? true : false;
            
            $cursor_text = addslashes( $settings['pixerex_fancy_text_cursor_text'] );
            
            $loop = ! empty( $settings['pixerex_fancy_text_type_loop'] ) ? true : false;
            
            $strings = array();
            
            foreach ( $settings['pixerex_fancy_text_strings'] as $item ) {
                if ( ! empty( $item['pixerex_text_strings_text_field'] ) ) {
                    array_push( $strings, str_replace('\'','&#39;', $item['pixerex_text_strings_text_field'] ) );
                }
            }
            $fancytext_settings = [
                'effect'    => $effect,
                'strings'   => $strings,
                'typeSpeed' => $settings['pixerex_fancy_text_type_speed'],
                'backSpeed' => $settings['pixerex_fancy_text_back_speed'],
                'startDelay'=> $settings['pixerex_fancy_text_start_delay'],
                'backDelay' => $settings['pixerex_fancy_text_back_delay'],
                'showCursor'=> $show_cursor,
                'cursorChar'=> $cursor_text,
                'loop'      => $loop,
            ];
        } elseif( $effect === 'slide' ) {
            
            $this->add_render_attribute( 'prefix', 'class', 'pixerex-fancy-text-span-align' );
            $this->add_render_attribute( 'suffix', 'class', 'pixerex-fancy-text-span-align' );
            
            $mause_pause = 'yes' === $settings['pixerex_slide_up_hover_pause'] ? true : false;
            $fancytext_settings = [
                'effect'        => $effect,
                'speed'         => $settings['pixerex_slide_up_speed'],
                'showItems'     => $settings['pixerex_slide_up_shown_items'],
                'pause'         => $settings['pixerex_slide_up_pause_time'],
                'mousePause'    => $mause_pause
            ];
        } else {
            $fancytext_settings = [
                'effect'        => $effect,
                'delay'         => $settings['pixerex_fancy_text_zoom_delay']
            ];
        }
        
        $this->add_render_attribute('wrapper', 'class', [ 'pixerex-fancy-text-wrapper', $effect ] );
        
        $this->add_render_attribute('wrapper', 'data-settings', wp_json_encode( $fancytext_settings ) );
        
    ?>
    
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <span class="pixerex-prefix-text"><span <?php echo $this->get_render_attribute_string('prefix'); ?>><?php echo wp_kses( ( $settings['pixerex_fancy_prefix_text'] ), true ); ?></span></span>

        <?php if ( $effect === 'typing'  ) : ?>
            <span class="pixerex-fancy-text"></span>
        <?php else : ?> 
            <div class="pixerex-fancy-text" style='display: inline-block; text-align: center'>
                <ul class="pixerex-fancy-text-items-wrapper">
                    <?php foreach ( $settings['pixerex_fancy_text_strings'] as $index => $item ) :
                        if ( ! empty( $item['pixerex_text_strings_text_field'] ) ) :
                            $this->add_render_attribute( 'text_' . $item['_id'], 'class', 'pixerex-fancy-list-items' );
                        
                            if( ( 'typing' !== $effect && 'slide' !== $effect ) && 0 !== $index ) {
                                $this->add_render_attribute( 'text_' . $item['_id'], 'class', 'pixerex-fancy-item-hidden' );
                            } else {
                                $this->add_render_attribute( 'text_' . $item['_id'], 'class', 'pixerex-fancy-item-visible' );
                            }

                        ?>
                            <li <?php echo $this->get_render_attribute_string('text_' . $item['_id'] ) ?>>
                                <?php echo esc_html( $item['pixerex_text_strings_text_field'] ); ?>
                            </li>
                        <?php endif; 
                    endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <span class="pixerex-suffix-text"><span <?php echo $this->get_render_attribute_string('suffix'); ?>><?php echo wp_kses( ( $settings['pixerex_fancy_suffix_text'] ), true ); ?></span></span>
    </div>
    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
        
            view.addInlineEditingAttributes('prefix');
            view.addInlineEditingAttributes('suffix');
            
            var effect = settings.pixerex_fancy_text_effect;
            
            var fancyTextSettings = {};
            
            fancyTextSettings.effect = effect;
        
        if( 'typing' === effect ) {
        
            var cursorText          = settings.pixerex_fancy_text_cursor_text,
                cursorTextEscaped   = cursorText.replace(/'/g, "\\'"),
                showCursor  = settings.pixerex_fancy_text_show_cursor ? true : false,
                loop        = settings.pixerex_fancy_text_type_loop ? true : false,
                strings     = [];
            
            _.each( settings.pixerex_fancy_text_strings, function( item ) {
                if ( '' !== item.pixerex_text_strings_text_field ) {
                
                    var fancyString = item.pixerex_text_strings_text_field;
                    
                    strings.push( fancyString );
                }
            });

            fancyTextSettings.strings    = strings,
            fancyTextSettings.typeSpeed  = settings.pixerex_fancy_text_type_speed,
            fancyTextSettings.backSpeed  = settings.pixerex_fancy_text_back_speed,
            fancyTextSettings.startDelay = settings.pixerex_fancy_text_start_delay,
            fancyTextSettings.backDelay  = settings.pixerex_fancy_text_back_delay,
            fancyTextSettings.showCursor = showCursor,
            fancyTextSettings.cursorChar = cursorTextEscaped,
            fancyTextSettings.loop       = loop;
            
            
        } else if ( 'slide' === effect ) {
        
            var mausePause = 'yes' === settings.pixerex_slide_up_hover_pause ? true : false;
            
            fancyTextSettings.speed         = settings.pixerex_slide_up_speed,
            fancyTextSettings.showItems     = settings.pixerex_slide_up_shown_items,
            fancyTextSettings.pause         = settings.pixerex_slide_up_pause_time,
            fancyTextSettings.mousePause    = mausePause
           
        } else {
            
            view.addRenderAttribute( 'prefix', 'class', 'pixerex-fancy-text-span-align' );
            view.addRenderAttribute( 'suffix', 'class', 'pixerex-fancy-text-span-align' );
            
            fancyTextSettings.delay         = settings.pixerex_fancy_text_zoom_delay;
        
        }
        
            view.addRenderAttribute( 'container', 'class', [ 'pixerex-fancy-text-wrapper', effect ] );
            view.addRenderAttribute( 'container', 'data-settings', JSON.stringify( fancyTextSettings ) );
        
        #>
        
            <div {{{ view.getRenderAttributeString('container') }}}>
                <span class="pixerex-prefix-text"><span {{{ view.getRenderAttributeString('prefix') }}}>{{{ settings.pixerex_fancy_prefix_text }}}</span></span>

            <# if ( 'typing' === effect ) { #>
                <span class="pixerex-fancy-text"></span>
            <# } else { #> 
                <div class="pixerex-fancy-text" style=' display: inline-block; text-align: center;'>
                    <ul class="pixerex-fancy-text-items-wrapper">
                        <# _.each ( settings.pixerex_fancy_text_strings, function ( item, index ) {
                            if ( '' !== item.pixerex_text_strings_text_field ) {
                                view.addRenderAttribute( 'text_' + item._id, 'class', 'pixerex-fancy-list-items' );
                        
                            if( ( 'typing' !== effect && 'slide' !== effect ) && 0 !== index ) {
                                view.addRenderAttribute( 'text_' + item._id, 'class', 'pixerex-fancy-item-hidden' );
                            } else {
                                view.addRenderAttribute( 'text_' + item._id, 'class', 'pixerex-fancy-item-visible' );
                            } #>
                            
                                <li {{{ view.getRenderAttributeString('text_' + item._id ) }}}>{{{ item.pixerex_text_strings_text_field }}}</li>
                        <# } }); #>
                    </ul>
                </div>
            <# } #>
                <span class="pixerex-suffix-text"><span {{{ view.getRenderAttributeString('suffix') }}}>{{{ settings.pixerex_fancy_suffix_text }}}</span></span>
            </div>
        
        <?php
    }
    
}