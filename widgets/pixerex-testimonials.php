<?php

/**
 * Class: Pixerex_Testimonials
 * Name: Testimonials
 * Slug: pixerex-addon-testimonials
 */

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Testimonials extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-testimonials';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Testimonial', 'pixerex-elementor-elements') );
	}

    public function get_icon() {
        return 'pa-testimonials';
    }
    
    public function get_style_depends() {
        return [
            'font-awesome',
            'pixerex-addons'
        ];
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }

    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}
    
    // Adding the controls fields for the pixerex testimonial
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {   
        
        $this->start_controls_section('pixerex_testimonial_person_settings',
            [
                'label'             => __('Author', 'pixerex-elementor-elements'),
            ]
        );
        
        $this->add_control('pixerex_testimonial_person_image',
            [
                'label'             => __('Image','pixerex-elementor-elements'),
                'type'              => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'      => [
                    'url'   => Utils::get_placeholder_image_src()
                ],
                'description'       => __( 'Choose an image for the author', 'pixerex-elementor-elements' ),
                'show_label'        => true,
            ]
        );

        $this->add_control('pixerex_testimonial_person_image_shape',
            [
                'label'             => __('Image Style', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Choose image style', 'pixerex-elementor-elements' ),
                'options'           => [
                    'square'  => __('Square','pixerex-elementor-elements'),
                    'circle'  => __('Circle','pixerex-elementor-elements'),
                    'rounded' => __('Rounded','pixerex-elementor-elements'),
                ],
                'default'           => 'circle',
            ]
        );
        
        $this->add_control('pixerex_testimonial_person_name',
            [
                'label'             => __('Name', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::TEXT,
                'default'           => 'John Doe',
                'dynamic'           => [ 'active' => true ],
                'label_block'       => true
            ]
        );
        
        $this->add_control('pixerex_testimonial_person_name_size',
            [
                'label'             => __('HTML Tag', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select a heading tag for author name', 'pixerex-elementor-elements' ),
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
                'default'           => 'h3',
                'label_block'       => true,
            ]
        );

        $this->add_control('separator_text',
            [
                'label'         => __('Separator', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '-',
                'separator'     => 'befpre'
            ]
        );

        $this->add_control('separator_align',
            [
                'label'             => __('Align', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'row'  => __('Inline','pixerex-elementor-elements'),
                    'column'  => __('Block','pixerex-elementor-elements'),
                ],
                'default'           => 'row',
                'prefix_class'      => 'pixerex-testimonial-separator-',
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-author-info'=> 'flex-direction: {{VALUE}}',
                ]
            ]
        );

        $this->add_control('separator_spacing',
            [
                'label'             => __('Spacing', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em'],
                'default'           => [
                    'unit'  => 'px',
                    'size'  => 5,
                ],
                'selectors'         => [
                    '{{WRAPPER}}.pixerex-testimonial-separator-row .pixerex-testimonial-separator' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}}.pixerex-testimonial-separator-column .pixerex-testimonial-separator' => 'margin-top: calc( {{SIZE}}{{UNIT}}/2 ); margin-bottom: calc( {{SIZE}}{{UNIT}}/2 );',
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_testimonial_company_settings',
            [
                'label'             => __('Company', 'pixerex-elementor-elements')
            ]
        );
        
        $this->add_control('pixerex_testimonial_company_name',
            [
                'label'             => __('Name', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'default'           => 'Pixerex',
                'label_block'       => true,
            ]
        );
        
        $this->add_control('pixerex_testimonial_company_name_size',
            [
                'label'             => __('HTML Tag', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select a heading tag for company name', 'pixerex-elementor-elements' ),
                'options'           => [
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
                'default'           => 'h4',
                'label_block'       => true,
            ]
        );
        
        $this->add_control('pixerex_testimonial_company_link_switcher',
            [
                'label'         => __('Link', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );

        $this->add_control('pixerex_testimonial_company_link',
            [
                'label'             => __('Link', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [
                'active'            => true,
                'categories'        => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'description'       => __( 'Add company URL', 'pixerex-elementor-elements' ),
                'label_block'       => true,
                'condition'         => [
                    'pixerex_testimonial_company_link_switcher' => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_testimonial_link_target',
            [
                'label'             => __('Link Target', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SELECT,
                'description'       => __( 'Select link target', 'pixerex-elementor-elements' ),
                'options'           => [
                    'blank'  => __('Blank'),
                    'parent' => __('Parent'),
                    'self'   => __('Self'),
                    'top'    => __('Top'),
                ],
                'default'           => __('blank','pixerex-elementor-elements'),
                'condition'         => [
                    'pixerex_testimonial_company_link_switcher' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_testimonial_settings',
            [
                'label'                 => __('Content', 'pixerex-elementor-elements'),
            ]
        );

        $this->add_control('pixerex_testimonial_content',
            [    
                'label'             => __('Testimonial Content', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::WYSIWYG,
                'dynamic'           => [ 'active' => true ],
                'default'           => __('Donec id elit non mi porta gravida at eget metus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis consectetur purus sit amet fermentum. Nullam id dolor id nibh ultricies vehicula ut id elit. Donec id elit non mi porta gravida at eget metus.','pixerex-elementor-elements'),
                'label_block'       => true,
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
        
        $this->start_controls_section('pixerex_testimonial_image_style',
            [
                'label'             => __('Image', 'pixerex-elementor-elements'),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );
        
        $this->add_control('pixerex_testimonial_img_size',
            [
                'label'             => __('Size', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em'],
                'default'           => [
                    'unit'  =>  'px',
                    'size'  =>  110,
                ],
                'range'             => [
                    'px'=> [
                        'min' => 10,
                        'max' => 150,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-img-wrapper'=> 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control('pixerex_testimonial_img_border_width',
            [
                'label'             => __('Border Width (PX)', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => 'px',
                    'size'  =>  2,
                ],
                'range'             => [
                    'px'=> [
                        'min' => 0,
                        'max' => 15,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-img-wrapper' => 'border-width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_control('pixerex_testimonial_image_border_color',
             [
                'label'                 => __('Border Color', 'pixerex-elementor-elements'),
                'type'                  => Controls_Manager::COLOR,
                'scheme'            => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                 'selectors'            => [
                    '{{WRAPPER}} .pixerex-testimonial-img-wrapper' => 'border-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_testimonials_person_style', 
            [
                'label'                 => __('Author', 'pixerex-elementor-elements'),
                'tab'                   => Controls_Manager::TAB_STYLE, 
            ]
        );
        
        $this->add_control('pixerex_testimonial_person_name_color',
            [
                'label'             => __('Author Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-person-name' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'author_name_typography',
                'label'         => __('Name Typograhy', 'pixerex-elementor-elements'),
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-person-name',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'author_name_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-person-name'
            ]
        );
        
        $this->add_control('pixerex_testimonial_separator_color',
            [
                'label'             => __('Separator Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'separator'         => 'before',
                'condition'         => [
                    'separator_text!'  => ''
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'separator_typography',
                'label'         => __('Separator Typograhy', 'pixerex-elementor-elements'),
                'condition'     => [
                    'separator_text!'  => ''
                ],
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-separator',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_testimonial_company_style',
            [
                'label'             => __('Company', 'pixerex-elementor-elements'),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );

        $this->add_control('pixerex_testimonial_company_name_color',
            [
                'label'             => __('Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-company-link' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'company_name_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-company-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'company_name_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-company-link'
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_testimonial_content_style',
            [
                'label'             => __('Content', 'pixerex-elementor-elements'),
                'tab'               => Controls_Manager::TAB_STYLE, 
            ]
        );

        $this->add_control('pixerex_testimonial_content_color',
            [
                'label'             => __('Color', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-text-wrapper' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'content_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-testimonial-text-wrapper',
            ]
        ); 
        
        $this->add_responsive_control('pixerex_testimonial_margin',
            [
                'label'                 => __('Margin', 'pixerex-elementor-elements'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', 'em', '%'],
                'default'               =>[
                    'top'   =>  15,
                    'bottom'=>  15,
                    'left'  =>  0 ,
                    'right' =>  0 ,
                    'unit'  => 'px',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .pixerex-testimonial-text-wrapper' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_testimonial_quotes',
            [
                'label'             => __('Quotation Icon', 'pixerex-elementor-elements'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_testimonial_quote_icon_color',
            [
                'label'              => __('Color','pixerex-elementor-elements'),
                'type'               => Controls_Manager::COLOR,
                'default'            => 'rgba(110,193,228,0.2)',
                'selectors'         =>  [
                    '{{WRAPPER}} .pixerex-testimonial-upper-quote, {{WRAPPER}} .pixerex-testimonial-lower-quote'   =>  'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('pixerex_testimonial_quotes_size',
            [
                'label'             => __('Size', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'default'           => [
                    'unit'  => 'px',
                    'size'  => 120,
                ],
                'range'             => [
                    'px' => [
                        'min' => 5,
                        'max' => 250,
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-upper-quote, {{WRAPPER}} .pixerex-testimonial-lower-quote' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_testimonial_upper_quote_position',
            [
                'label'             => __('Top Icon Position', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', 'em', '%'],
                'default'           =>[
                    'top'   =>  70,
                    'left'  =>  12 ,
                    'unit'  =>  'px',
                    ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-upper-quote' => 'top: {{TOP}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_testimonial_lower_quote_position',
            [
                'label'             => __('Bottom Icon Position', 'pixerex-elementor-elements'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'default'           =>[
                    'bottom'    =>  3,
                    'right'     =>  12,
                    'unit'      =>  'px',
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-testimonial-lower-quote' => 'right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_testimonial_container_style',
            [
                'label'     => __('Container','pixerex-elementor-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_testimonial_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-testimonial-content-wrapper'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'pixerex_testimonial_container_border',
                'selector'          => '{{WRAPPER}} .pixerex-testimonial-content-wrapper',
            ]
        );

        $this->add_control('pixerex_testimonial_container_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elementor-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-testimonial-content-wrapper' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'pixerex_testimonial_container_box_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-testimonial-content-wrapper',
            ]
        );
        
        $this->add_responsive_control('pixerex_testimonial_box_padding',
                [
                    'label'         => __('Padding', 'pixerex-elementor-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-testimonial-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );

        $this->end_controls_section();
        
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('pixerex_testimonial_person_name');
        $this->add_inline_editing_attributes('pixerex_testimonial_company_name');
        $this->add_inline_editing_attributes('pixerex_testimonial_content', 'advanced');
        $person_title_tag = $settings['pixerex_testimonial_person_name_size'];
        
        $company_title_tag = $settings['pixerex_testimonial_company_name_size'];
        
        $image_src = '';
        
        if( ! empty( $settings['pixerex_testimonial_person_image']['url'] ) ) {
            $image_src = $settings['pixerex_testimonial_person_image']['url'];
            $alt = esc_attr( Control_Media::get_image_alt( $settings['pixerex_testimonial_person_image'] ) );
        }
        
        $this->add_render_attribute('testimonial', 'class', [
            'pixerex-testimonial-box'
        ]);

        $this->add_render_attribute('img_wrap', 'class', [
            'pixerex-testimonial-img-wrapper',
            $settings['pixerex_testimonial_person_image_shape']
        ]);
        
    ?>
    
    <div <?php echo $this->get_render_attribute_string('testimonial'); ?>>
        <div class="pixerex-testimonial-container">
            <i class="fa fa-quote-left pixerex-testimonial-upper-quote"></i>
            <div class="pixerex-testimonial-content-wrapper">
                <?php if ( ! empty( $image_src ) ) : ?>
                    <div <?php echo $this->get_render_attribute_string('img_wrap'); ?>>
                        <img src="<?php echo $image_src; ?>" alt="<?php echo $alt; ?>" class="pixerex-testimonial-person-image">
                    </div>
                <?php endif; ?>

                <div class="pixerex-testimonial-text-wrapper">
                    <div <?php echo $this->get_render_attribute_string('pixerex_testimonial_content'); ?>>
                        <?php echo $settings['pixerex_testimonial_content']; ?>
                    </div>
                </div>

                <div class="pixerex-testimonial-author-info">
                    <<?php echo $person_title_tag; ?> class="pixerex-testimonial-person-name">
                        <span <?php echo $this->get_render_attribute_string('pixerex_testimonial_person_name'); ?>><?php echo $settings['pixerex_testimonial_person_name']; ?></span>
                    </<?php echo $person_title_tag; ?>>
                    
                    <span class="pixerex-testimonial-separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
                    
                    <<?php echo $company_title_tag; ?> class="pixerex-testimonial-company-name">
                    <?php if( $settings['pixerex_testimonial_company_link_switcher'] === 'yes') : ?>
                        <a class="pixerex-testimonial-company-link" href="<?php echo $settings['pixerex_testimonial_company_link']; ?>" target="_<?php echo $settings['pixerex_testimonial_link_target']; ?>">
                            <span <?php echo $this->get_render_attribute_string('pixerex_testimonial_company_name'); ?>><?php echo $settings['pixerex_testimonial_company_name']; ?></span>
                        </a>
                    <?php else: ?>
                        <span class="pixerex-testimonial-company-link" <?php echo $this->get_render_attribute_string('pixerex_testimonial_company_name'); ?>>
                            <?php echo $settings['pixerex_testimonial_company_name']; ?>
                        </span>
                    <?php endif; ?>
                    </<?php echo $company_title_tag; ?>>
                </div>
            </div>
            <i class="fa fa-quote-right pixerex-testimonial-lower-quote"></i>
        </div>
    </div>
    <?php
    
    }
    
    protected function _content_template() {
        ?>
        <#
        
            view.addInlineEditingAttributes('pixerex_testimonial_person_name');
            view.addInlineEditingAttributes('pixerex_testimonial_company_name');
            view.addInlineEditingAttributes('pixerex_testimonial_content', 'advanced');
            view.addRenderAttribute('pixerex_testimonial_company_name', 'class', 'pixerex-testimonial-company-link');
            
            var personTag = settings.pixerex_testimonial_person_name_size,
                companyTag = settings.pixerex_testimonial_company_name_size,
                imageSrc = '',
                imageSrc,
                borderRadius;

            if( '' != settings.pixerex_testimonial_person_image.url ) {
                imageSrc = settings.pixerex_testimonial_person_image.url;
            }
        
            view.addRenderAttribute('testimonial', 'class', [
                'pixerex-testimonial-box'
            ]);

            view.addRenderAttribute('img_wrap', 'class', [
                'pixerex-testimonial-img-wrapper',
                settings.pixerex_testimonial_person_image_shape
            ]);
            
        
        #>
        
            <div {{{ view.getRenderAttributeString('testimonial') }}}>
                <div class="pixerex-testimonial-container">
                    <i class="fa fa-quote-left pixerex-testimonial-upper-quote"></i>
                    <div class="pixerex-testimonial-content-wrapper">
                        <# if ( '' != imageSrc ) { #>
                            <div {{{ view.getRenderAttributeString('img_wrap') }}}>
                                <img src="{{ imageSrc }}" alt="pixerex-image" class="pixerex-testimonial-person-image">
                            </div>
                        <# } #>
                        <div class="pixerex-testimonial-text-wrapper">
                            <div {{{ view.getRenderAttributeString('pixerex_testimonial_content') }}}>{{{ settings.pixerex_testimonial_content }}}</div>
                        </div>
                        
                        <div class="pixerex-testimonial-author-info">
                            <{{{personTag}}} class="pixerex-testimonial-person-name">
                                <span {{{ view.getRenderAttributeString('pixerex_testimonial_person_name') }}}>
                                {{{ settings.pixerex_testimonial_person_name }}}
                                </span>
                            </{{{personTag}}}>
                            
                            <span class="pixerex-testimonial-separator"> {{{ settings.separator_text }}} </span>
                            
                            <{{{companyTag}}} class="pixerex-testimonial-company-name">
                                <a href="{{ settings.pixerex_testimonial_company_link }}" {{{ view.getRenderAttributeString('pixerex_testimonial_company_name') }}}>
                                    {{{ settings.pixerex_testimonial_company_name }}}
                                </a>
                            </{{{companyTag}}}>
                        </div>
                        
                    </div>
                    
                    <i class="fa fa-quote-right pixerex-testimonial-lower-quote"></i>
                    
                </div>
            </div>
        
        <?php
    }

}