<?php

/**
 * Class: Pixerex_Image_Separator
 * Name: Image Separator
 * Slug: pixerex-addon-image-separator
 */

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use PixerexAddons\Includes;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Image_Separator extends Widget_Base {

    protected $templateInstance;

    public function getTemplateInstance() {
        return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
    }

    public function get_name() {
        return 'pixerex-addon-image-separator';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Image Separator', 'pixerex-elementor-elements') );
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
    
    public function get_icon() {
        return 'pa-image-separator';
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }

    public function get_keywords() {
		return [ 'divider', 'section', 'shape' ];
	}
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for the pixerex image separator
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        $this->start_controls_section('pixerex_image_separator_general_settings',
            [
                'label'         => __('Image Settings', 'pixerex-elementor-elements')
            ]
        );
        
        $this->add_control('separator_type',
            [
                'label'			=> __( 'Separator Type', 'pixerex-elementor-elements' ),
                'type' 			=> Controls_Manager::SELECT,
                'options'		=> [
                    'icon'          => __('Icon', 'pixerex-elementor-elements'),
                    'image'         => __( 'Image', 'pixerex-elementor-elements'),
                    'animation'     => __('Lottie Animation', 'pixerex-elementor-elements'),
                ],
                'default'		=> 'image'
            ]
        );

        $this->add_control('separator_icon',
		  	[
		     	'label'			=> __( 'Select an Icon', 'pixerex-elementor-elements' ),
		     	'type'              => Controls_Manager::ICONS,
                'default' => [
                    'value'     => 'fas fa-grip-lines',
                    'library'   => 'fa-solid',
                ],
			  	'condition'		=> [
			  		'separator_type' => 'icon'
			  	]
		  	]
        );

        $this->add_control('pixerex_image_separator_image',
            [
                'label'         => __('Image', 'pixerex-elementor-elements'),
                'description'   => __('Choose the separator image', 'pixerex-elementor-elements' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                ],
                'label_block'   => true,
                'condition'     => [
                    'separator_type'    => 'image'
                ]
            ]
        );

        $this->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', 'pixerex-elementor-elements' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'         => [
                    'separator_type'    => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop','pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'         => [
                    'separator_type'    => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse','pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'         => [
                    'separator_type'    => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_hover',
            [
                'label'         => __('Only Play on Hover','pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'         => [
                    'separator_type'    => 'animation'
                ],
            ]
        );

        $this->add_responsive_control('pixerex_image_separator_image_size',
            [
                'label'         => __('Size', 'pixerex-elementor-elements'),
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
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container img'    => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-image-separator-container i'      => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pixerex-image-separator-container svg'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_image_separator_image_gutter',
            [
                'label'         => __('Gutter (%)', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => -50,
                'description'   => __('-50% is default. Increase to push the image outside or decrease to pull the image inside.','pixerex-elementor-elements'),
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container' => 'transform: translateY( {{VALUE}}% );'
                ]
            ]
        );
        
        $this->add_control('pixerex_image_separator_image_align', 
            [
                'label'         => __('Alignment', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'     => __('Left', 'pixerex-elementor-elements'),
                        'icon'      => 'fa fa-align-left'
                    ],
                    'center'  => [
                        'title'     => __('Center', 'pixerex-elementor-elements'),
                        'icon'      => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title'     => __('Right', 'pixerex-elementor-elements'),
                        'icon'      => 'fa fa-align-right'
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container'   => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_image_separator_link_switcher', 
            [
                'label'         => __('Link', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Add a custom link or select an existing page link','pixerex-elementor-elements'),
            ]
        );
        
        $this->add_control('pixerex_image_separator_link_type', 
            [
                'label'         => __('Link/URL', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'pixerex-elementor-elements'),
                    'link'  => __('Existing Page', 'pixerex-elementor-elements'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_image_separator_link_switcher'  => 'yes',
                ],
            ]
        );
        
        $this->add_control('pixerex_image_separator_existing_page', 
            [
                'label'         => __('Existing Page', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'multiple'      => false,
                'label_block'   => true,
                'condition'     => [
                    'pixerex_image_separator_link_switcher'  => 'yes',
                    'pixerex_image_separator_link_type'     => 'link',
                ],
            ]
        );
        
        $this->add_control('pixerex_image_separator_image_link',
            [
                'label'         => __('URL', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_image_separator_link_switcher' => 'yes',
                    'pixerex_image_separator_link_type'     => 'url',
                ],
            ]
        );
        
        $this->add_control('pixerex_image_separator_image_link_text',
            [
                'label'         => __('Image Title', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'condition'     => [
                    'pixerex_image_separator_link_switcher' => 'yes',
                ],
            ]
        );
        
        $this->add_control('link_new_tab',
            [
                'label'         => __('Open Link in New Tab', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'pixerex_image_separator_link_switcher' => 'yes',
                ],
            ]
        );
       
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_image_separator_style',
            [
                'label'         => __('Separator', 'pixerex-elementor-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'css_filters',
                'selector'  => '{{WRAPPER}} .pixerex-image-separator-container',
                'condition' => [
                    'separator_type!'    => 'icon'
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filters', 'pixerex-elementor-elements'),
                'selector'  => '{{WRAPPER}} .pixerex-image-separator-container:hover',
                'condition' => [
                    'separator_type!'    => 'icon'
                ]
			]
		);
        
        $this->add_control('icon_color',
		  	[
				'label'         => __( 'Color', 'pixerex-elementor-elements' ),
                'type' 			=> Controls_Manager::COLOR,
                'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-image-separator-container i' => 'color: {{VALUE}}'
				],
			  	'condition'     => [
			  		'separator_type' => 'icon'
			  	]
			]
        );

        $this->add_control('icon_hover_color',
            [
                'label'         => __( 'Hover Color', 'pixerex-elementor-elements' ),
                'type' 			=> Controls_Manager::COLOR,
                'scheme' 		=> [
                    'type' 	=> Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container i:hover' => 'color: {{VALUE}}'
                ],
                'condition'     => [
                    'separator_type' => 'icon'
                ]
            ]
        );
        
        $this->add_control('icon_background_color',
		  	[
				'label'         => __( 'Background Color', 'pixerex-elementor-elements' ),
                'type' 			=> Controls_Manager::COLOR,
                'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-image-separator-container i' => 'background-color: {{VALUE}}'
				],
			  	'condition'     => [
			  		'separator_type' => 'icon'
			  	]
			]
        );
 
        $this->add_control('icon_hover_background_color',
		  	[
				'label'         => __( 'Hover Background Color', 'pixerex-elementor-elements' ),
                'type' 			=> Controls_Manager::COLOR,
                'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-image-separator-container i:hover' => 'background-color: {{VALUE}}'
				],
			  	'condition'     => [
			  		'separator_type' => 'icon'
			  	]
			]
        );

        $this->add_responsive_control('separator_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container i, {{WRAPPER}} .pixerex-image-separator-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'separator_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-image-separator-container i',
                'condition'     => [
                    'separator_type' => 'icon'
                ]
            ]
        );
        
        $this->add_responsive_control('icon_padding',
            [
                'label'         => __('Padding', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-image-separator-container i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
                'condition'     => [
                    'separator_type' => 'icon'
                ]
            ]
        );
        
        $this->end_controls_section();
       
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $type   = $settings['separator_type'];

        if( 'yes' === $settings['pixerex_image_separator_link_switcher'] ) {
            $link_type = $settings['pixerex_image_separator_link_type'];

            if( 'url' === $link_type ) {
                $url = $settings['pixerex_image_separator_image_link'];
            } else {
                $url = get_permalink( $settings['pixerex_image_separator_existing_page'] );
            }

            $this->add_render_attribute( 'link', [
                'class' => 'pixerex-image-separator-link',
                'href'  => $url
            ]);

            if( 'yes' === $settings['link_new_tab'] ) {
                $this->add_render_attribute( 'link', 'target', '_blank');
            }

            if( ! empty ( $settings['pixerex_image_separator_image_link_text']) ) {
                $this->add_render_attribute( 'link', 'title', $settings['pixerex_image_separator_image_link_text'] );
            }
            
        }
        
        if( 'image' === $type ) {
            $alt = esc_attr( Control_Media::get_image_alt( $settings['pixerex_image_separator_image'] ) );
        } elseif ( 'animation' === $type ) {
            $this->add_render_attribute( 'separator_lottie', [
                'class' => 'pixerex-lottie-animation',
                'data-lottie-url' => $settings['lottie_url'],
                'data-lottie-loop' => $settings['lottie_loop'],
                'data-lottie-reverse' => $settings['lottie_reverse'],
                'data-lottie-hover' => $settings['lottie_hover']
            ]);
        }
    ?>

    <div class="pixerex-image-separator-container">
        <?php if( 'image' === $type ) : ?>
            <img src="<?php echo $settings['pixerex_image_separator_image']['url']; ?>" alt="<?php echo $alt; ?>">
        <?php elseif( 'icon' === $type ) :
            Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] );
        else: ?>
            <div <?php echo $this->get_render_attribute_string( 'separator_lottie' ); ?>></div>
        <?php endif; ?>
        <?php if (  $settings['pixerex_image_separator_link_switcher'] === 'yes' && ! empty( $url ) ) : ?>
            <a <?php echo $this->get_render_attribute_string( 'link' ); ?>></a>
        <?php endif; ?>
    </div>
    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
            var type        = settings.separator_type,
                linkSwitch  = settings.pixerex_image_separator_link_switcher;
                
            if( 'image' === type ) {
                var imgUrl = settings.pixerex_image_separator_image.url;
            } else if ( 'icon' === type ) {
                var iconHTML = elementor.helpers.renderIcon( view, settings.separator_icon, { 'aria-hidden': true }, 'i' , 'object' );    
            } else {

                view.addRenderAttribute( 'separator_lottie', {
                    'class': 'pixerex-lottie-animation',
                    'data-lottie-url': settings.lottie_url,
                    'data-lottie-loop': settings.lottie_loop,
                    'data-lottie-reverse': settings.lottie_reverse,
                    'data-lottie-hover': settings.lottie_hover
                });
                
            }

            if( 'yes' === linkSwitch ) {
                var linkType = settings.pixerex_image_separator_link_type,
                    linkTitle = settings.pixerex_image_separator_image_link_text,
                    linkUrl = ( 'url' == linkType ) ? settings.pixerex_image_separator_image_link : settings.pixerex_image_separator_existing_page;

                view.addRenderAttribute( 'link', 'class', 'pixerex-image-separator-link' );
                view.addRenderAttribute( 'link', 'href', linkUrl );

                if( '' !== linkTitle ) {
                    view.addRenderAttribute( 'link', 'title', linkTitle );
                }
                
            }

        #>

        <div class="pixerex-image-separator-container">
            <# if( 'image' === type ) { #>
                <img alt="image separator" src="{{ imgUrl }}">
            <# } else if( 'icon' === type ) { #>
                {{{ iconHTML.value }}} 
            <# } else { #>
                <div {{{ view.getRenderAttributeString('separator_lottie') }}}></div>
            <# } #>
            <# if( 'yes' === linkSwitch ) { #>
                <a {{{ view.getRenderAttributeString( 'link' ) }}}></a>
            <# } #>
        </div>
        
        <?php  
    }
}