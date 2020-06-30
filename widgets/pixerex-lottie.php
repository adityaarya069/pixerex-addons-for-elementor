<?php

/**
 * Class: Pixerex_Lottie
 * Name: Lottie Animations
 * Slug: pixerex-lottie-animations
 */

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use PixerexAddons\Includes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Lottie extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-lottie';
    }
    
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
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

    public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Lottie Animations', 'pixerex-addons-for-elementor') );
	}

    public function get_icon() {
        return 'pr-lottie-animations';
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }
    
 
    protected function _register_controls() {

        $this->start_controls_section('section_general_settings',
            [
                'label'         => __('General Settings', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'pixerex-addons-for-elementor' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
            ]
        );

        $this->add_control('lottie_hover',
            [
                'label'         => __('Only Play on Hover','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
            ]
        );

        $this->add_control('lottie_speed',
			[
                'label'         => __( 'Animation Speed', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 1,
                'min'           => 0.1,
                'max'           => 3,
                'step'          => 0.1
			]
        );

        $this->add_control('animate_on_scroll',
            [
                'label'         => __('Animate On Scroll','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'lottie_hover!'  => 'true',
                    'lottie_reverse!'   => 'true'
                ]
            ]
        );

        $this->add_control('animate_speed',
			[
				'label'         => __( 'Speed', 'pixerex-addons-for-elementor' ),
				'type'          => Controls_Manager::SLIDER,
				'default' => [
                    'size' => 4,
                ],
                'range' => [
                    'px' => [
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
				'condition'     => [
                    'lottie_hover!'  => 'true',
                    'animate_on_scroll' => 'true',
                    'lottie_reverse!'   => 'true'
				],
			]
		);
        
        $this->add_control('animate_view',
			[
				'label'         => __( 'Viewport', 'pixerex-addons-for-elementor' ),
				'type'          => Controls_Manager::SLIDER,
				'default' => [
                    'sizes' => [
                        'start' => 0,
                        'end' => 100,
                    ],
                    'unit' => '%',
                ],
                'labels' => [
                    __( 'Bottom', 'pixerex-addons-for-elementor' ),
                    __( 'Top', 'pixerex-addons-for-elementor' ),
                ],
                'scales' => 1,
                'handles' => 'range',
                'condition'     => [
                    'lottie_hover!'  => 'true',
                    'animate_on_scroll' => 'true',
                    'lottie_reverse!'   => 'true'
				],
			]
        );

        $this->add_responsive_control('animation_size',
            [
                'label'         => __('Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'default'       => [
                    'unit'  => 'px',
                    'size'  => 200,
                ],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 800, 
                    ],
                    'em'    => [
                        'min'   => 1, 
                        'max'   => 30,
                    ],
                ],
                'render_type'   => 'template',
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}}.pixerex-lottie-canvas .pixerex-lottie-animation, {{WRAPPER}}.pixerex-lottie-svg svg'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control('lottie_rotate',
            [
                'label'         => __('Rotate (degrees)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'description'   => __('Set rotation value in degress', 'pixerex-addons-for-elementor'),
                'range'         => [
                    'px'    => [
                        'min'   => -180,
                        'max'   => 180,    
                    ]
                ],
                'default'       => [
                    'size'  => 0,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-lottie-animation' => 'transform: rotate({{SIZE}}deg)'
                ],
            ]
        );

        $this->add_responsive_control('animation_align',
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
                'toggle'        => false,
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-lottie-wrap' => 'text-align: {{VALUE}}',
                ],
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
                    'link_switcher'     => 'yes'
                ]
            ]
        );
        
        $this->add_control('link',
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
                    'link_selection'     => 'url',
                ]
            ]
        );
        
        $this->add_control('existing_link',
            [
                'label'         => __('Existing Page', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'multiple'      => false,
                'label_block'   => true,
                'condition'     => [
                    'link_switcher'     => 'yes',
                    'link_selection'     => 'link',
                ],
            ]
        );

        $this->add_control('lottie_renderer', 
            [
                'label'         => __('Render As', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'svg'   => __('SVG', 'pixerex-addons-for-elementor'),
                    'canvas'  => __('Canvas', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'svg',
                'prefix_class'  => 'pixerex-lottie-',
                'render_type'   => 'template',
                'label_block'   => true,
                'separator'     => 'before'
            ]
        );

        $this->add_control('render_notice', 
            [
                'raw'               => __('Set render type to canvas if you\'re having performance issues on the page.', 'pixerex-addons-for-elemeentor'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes'   => 'elementor-panel-alert elementor-panel-alert-info',
            ] 
        );

        $this->end_controls_section();

        $this->start_controls_section('section_pr_docs',
            [
                'label'         => __('Helpful Documentations', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('doc_1',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf( __( '%1$s Check the video tutorial » %2$s', 'pixerex-addons-pro' ), '<a href="https://www.youtube.com/watch?v=0QWzUpF57dw" target="_blank" rel="noopener">', '</a>' ),
                'content_classes' => 'editor-pr-doc',
            ]
        );
        
        $this->add_control('doc_2',
            [
                'raw'             => sprintf( __( '%1$s Check the documentation article » %2$s', 'pixerex-addons-for-elementor' ), '<a href="https://pixerexaddons.com/docs/lottie-animations-widget-tutorial/?utm_source=pr-dashboard&utm_medium=pr-editor&utm_campaign=pr-plugin" target="_blank" rel="noopener">', '</a>' ),
                'type'            => Controls_Manager::RAW_HTML,
                'content_classes' => 'editor-pr-doc',
            ]
        );

        $this->add_control('doc_3',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf( __( '%1$s How to speed up Elementor pages with many Lottie animations » %2$s', 'pixerex-addons-for-elementor' ), '<a href="https://pixerexaddons.com/docs/how-to-speed-up-elementor-pages-with-many-lottie-animations/?utm_source=pr-dashboard&utm_medium=pr-editor&utm_campaign=pr-plugin" target="_blank" rel="noopener">', '</a>' ),
                'content_classes' => 'editor-pr-doc',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('section_animation_style',
            [
                'label'             => __('Animation', 'pixerex-addons-for-elementor'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_lottie');
        
        $this->start_controls_tab('tab_lottie_normal',
            [
                'label'             => __('Normal', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('lottie_background',
            [
                'label'             => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .pixerex-lottie-animation'  => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control('opacity',
			[
				'label'     => __( 'Opacity', 'pixerex-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'   => 1,
						'min'   => 0.10,
						'step'  => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-lottie-animation' => 'opacity: {{SIZE}}',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'css_filters',
                'selector'  => '{{WRAPPER}} .pixerex-lottie-animation',
			]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('tab_lottie_hover',
            [
                'label'             => __('Hover', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('lottie_hover_background',
            [
                'label'             => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .pixerex-lottie-animation:hover'  => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control('hover_opacity',
			[
				'label'     => __( 'Opacity', 'pixerex-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'   => 1,
						'min'   => 0.10,
						'step'  => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-lottie-animation:hover' => 'opacity: {{SIZE}}',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'selector'  => '{{WRAPPER}} .pixerex-lottie-animation:hover',
			]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'lottie_border',
                'selector'      => '{{WRAPPER}} .pixerex-lottie-animation',
                'separator'     => 'before'
            ]
        );
        
        $this->add_control('lottie_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-lottie-animation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control('animation_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-lottie-animation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );

        $this->end_controls_section();
        
    }
   
    /**
	 * Render Lottie Animations output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 3.20.2
	 * @access protected
	 */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $anim_url = $settings['lottie_url'];

        if( empty( $anim_url ) )
            return; 

        $this->add_render_attribute( 'lottie', [
            'class' => [
                'pixerex-lottie-animation',
            ],
            'data-lottie-url' => $settings['lottie_url'],
            'data-lottie-loop' => $settings['lottie_loop'],
            'data-lottie-reverse' => $settings['lottie_reverse'],
            'data-lottie-hover' => $settings['lottie_hover'],
            'data-lottie-speed' => $settings['lottie_speed'],
            'data-lottie-render' => $settings['lottie_renderer'],
        ]);

        if( $settings['animate_on_scroll'] ) {

            $this->add_render_attribute( 'lottie', [
                'class' => 'pixerex-lottie-scroll',
                'data-lottie-scroll' => 'true',
                'data-scroll-start' => $settings['animate_view']['sizes']['start'],
                'data-scroll-end' => $settings['animate_view']['sizes']['end'],
                'data-scroll-speed' => $settings['animate_speed']['size'],
            ]);

        }

        if( 'yes' === $settings['link_switcher'] ) {

            if( $settings['link_selection'] === 'url' ) {
                $button_url = $settings['link']['url'];
            } else {
                $button_url = get_permalink( $settings['existing_link'] );
            }

            $this->add_render_attribute( 'link', 'href', $button_url );
            
            if( ! empty( $settings['link']['is_external'] ) )
                $this->add_render_attribute( 'button', 'target', '_blank' );
            
            if( ! empty( $settings['link']['nofollow'] ) )
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );

        }
        
        
    ?>

        <div class="pixerex-lottie-wrap">
            <div <?php echo $this->get_render_attribute_string('lottie'); ?>>
                <?php if( 'yes' === $settings['link_switcher'] && ! empty( $button_url )  ) : ?>
                    <a <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
                <?php endif; ?>
            </div>
        </div>

    <?php
    }

    /**
	 * Render Lottie Animations output on the editor.
	 *
	 *
	 * @since 3.20.2
	 * @access protected
	 */
    protected function _content_template() {

        ?>

        <#
        
        var anim_url = settings.lottie_url;

        if( '' === anim_url )
            return; 

            view.addRenderAttribute( 'lottie', {
            'class': [
                'pixerex-lottie-animation',
            ],
            'data-lottie-url': settings.lottie_url,
            'data-lottie-loop': settings.lottie_loop,
            'data-lottie-reverse': settings.lottie_reverse,
            'data-lottie-hover': settings.lottie_hover,
            'data-lottie-speed': settings.lottie_speed,
            'data-lottie-render': settings.lottie_renderer
        });

        if( settings.animate_on_scroll ) {

            view.addRenderAttribute( 'lottie', {
                'class': 'pixerex-lottie-scroll',
                'data-lottie-scroll': 'true',
                'data-scroll-start': settings.animate_view.sizes.start,
                'data-scroll-end': settings.animate_view.sizes.end,
                'data-scroll-speed': settings.animate_speed.size,
            });

        }

        if( 'yes' === settings.link_switcher ) {

            var button_url = '';

            if( settings.link_selection === 'url' ) {
                button_url = settings.link.url;
            } else {
                button_url = settings.existing_link;
            }

            view.addRenderAttribute( 'link', 'href', button_url );

        }
        
        
    #>

        <div class="pixerex-lottie-wrap">
            <div {{{ view.getRenderAttributeString('lottie') }}}>
                <# if( 'yes' === settings.link_switcher && '' !== button_url ) { #>
                    <a {{{ view.getRenderAttributeString('link') }}}></a>
                <# } #>
            </div>
        </div>

    <?php
    }
    
    
}   