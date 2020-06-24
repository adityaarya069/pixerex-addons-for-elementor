<?php

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Embed;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Videobox extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-video-box';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Video Box', 'pixerex-addons-for-elementor') );
	}

    public function get_icon() {
        return 'pa-video-box';
    }

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }
    
    public function get_style_depends() {
        return [
            'font-awesome',
            'pixerex-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'pixerex-addons-js'
        ];
    }
    
    public function get_keywords() {
        return ['youtube', 'vimeo', 'self', 'hosted', 'media'];
    }
    
    public function get_custom_help_url() {
		return 'https://pixerexaddons.com/support/';
	}

    // Adding the controls fields for Pixerex Video Box
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        $this->start_controls_section('pixerex_video_box_general_settings',
            [
                'label'         => __('Video Box', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_video_box_video_type',
            [
                'label'         => __('Video Type', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'youtube',
                'options'       => [
                    'youtube'       => __('Youtube', 'pixerex-addons-for-elementor'),
                    'vimeo'         => __('Vimeo', 'pixerex-addons-for-elementor'),
                    'self'          => __('Self Hosted', 'pixerex-addons-for-elementor'),
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_video_id_embed_selection',
            [
                'label'         => __('Link', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::HIDDEN,
                'default'       => 'id',
                'options'       => [
                    'id'    => __('ID', 'pixerex-addons-for-elementor'),
                    'embed' => __('Embed URL', 'pixerex-addons-for-elementor'),
                ],
                'condition'     => [
                    'pixerex_video_box_video_type!' => 'self',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_video_id', 
            [
                'label'         => __('Video ID', 'pixerex-addons-for-elementor'),
                'description'   => __('Enter the numbers and letters after the equal sign which located in your YouTube video link or after the slash sign in your Vimeo video link. For example, z1hQgVpfTKU', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::HIDDEN,
                'condition'     => [
                    'pixerex_video_box_video_type!' => 'self',
                    'pixerex_video_box_video_id_embed_selection' => 'id',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_video_embed', 
            [
                'label'         => __('Embed URL', 'pixerex-addons-for-elementor'),
                'description'   => __('Enter your YouTube/Vimeo video link. For example, https://www.youtube.com/embed/z1hQgVpfTKU', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::HIDDEN,
                'condition'     => [
                    'pixerex_video_box_video_type!' => 'self',
                    'pixerex_video_box_video_id_embed_selection' => 'embed',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_link', 
            [
                'label'         => __('Link', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => 'https://www.youtube.com/watch?v=07d2dXHYb94',
                'dynamic'       => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'condition'     => [
                    'pixerex_video_box_video_type!' => 'self',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_self_hosted',
            [
                'label'         => __('URL', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ],
                ],
                'media_type' => 'video',
                'condition'     => [
                    'pixerex_video_box_video_type' => 'self',
                ]
            ]
        );
      
        $this->add_control('pixerex_video_box_self_hosted_remote',
            [
                'label'         => __('Remote Video URL', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active' => true,
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_video_box_video_type' => 'self',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_controls',
            [
                'label'         => __('Player Controls', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Show/hide player controls', 'pixerex-addons-for-elementor'),
                'default'       => 'yes'
            ]
        );
        
        $this->add_control('pixerex_video_box_mute',
            [
                'label'         => __('Mute', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('This will play the video muted', 'pixerex-addons-for-elementor')
            ]
        );
        
        $this->add_control('pixerex_video_box_self_autoplay',
            [
                'label'         => __('Autoplay', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('autoplay_notice',
			[
				'raw'           => __( 'Please note that autoplay option works only when Overlay option is disabled', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'     => [
                    'pixerex_video_box_self_autoplay'   => 'yes'
                ]    
			]
		);
        
        $this->add_control('pixerex_video_box_loop',
            [
                'label'         => __('Loop', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_video_box_start',
            [
                'label'     => __( 'Start Time', 'pixerex-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'separator' => 'before',
                'description'=> __( 'Specify a start time (in seconds)', 'pixerex-addons-for-elementor' ),
                'condition'  => [
                    'pixerex_video_box_video_type!' => 'vimeo'
                ]
            ]
        );

        $this->add_control('pixerex_video_box_end',
            [
                'label'         => __( 'End Time', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::NUMBER,
                'description'   => __( 'Specify an end time (in seconds)', 'pixerex-addons-for-elementor' ),
                'separator'     => 'after',
                'condition'     => [
                    'pixerex_video_box_video_type!' => 'vimeo'
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_suggested_videos',
            [
                'label'         => __('Suggested Videos From', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    ''      => __('Current Channel', 'pixerex-addons-for-elementor'),
                    'yes'   => __('Any Channel', 'pixerex-addons-for-elementor')
                ],
                'condition'     => [
                    'pixerex_video_box_video_type' => 'youtube',
                ]
            ]
        );
        
        $this->add_control('vimeo_controls_color',
            [
                'label'     => __( 'Controls Color', 'pixerex-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .pixerex-video-box-vimeo-title a, {{WRAPPER}} .pixerex-video-box-vimeo-byline a, {{WRAPPER}} .pixerex-video-box-vimeo-title a:hover, {{WRAPPER}} .pixerex-video-box-vimeo-byline a:hover, {{WRAPPER}} .pixerex-video-box-vimeo-title a:focus, {{WRAPPER}} .pixerex-video-box-vimeo-byline a:focus' => 'color: {{VALUE}}',
                ),
                'render_type'=> 'template',
                'condition' => [
                    'pixerex_video_box_video_type' => 'vimeo',
                ],
            ]
        );
        
        $this->add_control('vimeo_title',
			[
				'label' => __( 'Intro Title', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'pixerex_video_box_video_type' => 'vimeo',
				],
			]
		);

		$this->add_control('vimeo_portrait',
			[
				'label' => __( 'Intro Portrait', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'pixerex_video_box_video_type' => 'vimeo',
				],
			]
		);

		$this->add_control('vimeo_byline',
			[
				'label' => __( 'Intro Byline', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'pixerex_video_box_video_type' => 'vimeo',
				],
			]
		);

        $this->add_control('aspect_ratio',
            [
                'label'         => __( 'Aspect Ratio', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    '11'    => '1:1',
                    '169'   => '16:9',
                    '43'    => '4:3',
                    '32'    => '3:2',
                    '219'   => '21:9',
                    '916'   => '9:16',
                ],
                'default'       => '169',
                'prefix_class'  => 'pa-aspect-ratio-',
                'frontend_available' => true,
            ]
        );
        
        $this->add_control('pixerex_video_box_image_switcher',
            [
                'label'         => __('Overlay', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
        
        $this->add_control('pixerex_video_box_yt_thumbnail_size',
            [
                'label'     => __( 'Thumbnail Size', 'pixerex-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'maxresdefault' => __( 'Maximum Resolution', 'pixerex-addons-for-elementor' ),
                    'hqdefault'     => __( 'High Quality', 'pixerex-addons-for-elementor' ),
                    'mqdefault'     => __( 'Medium Quality', 'pixerex-addons-for-elementor' ),
                    'sddefault'     => __( 'Standard Quality', 'pixerex-addons-for-elementor' ),
                ],
                'default'   => 'maxresdefault',
                'condition' => [
                    'pixerex_video_box_video_type'      => 'youtube',
                    'pixerex_video_box_image_switcher!' => 'yes'
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_video_box_image_settings', 
            [
                'label'         => __('Overlay', 'pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_video_box_image_switcher'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_image',
            [
                'label'         => __('Image', 'pixerex-addons-for-elementor'),
                'description'   => __('Choose an image for the video box', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src()
                ],
                'label_block'   => true,
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_video_box_play_icon_settings', 
            [
                'label'         => __('Play Icon', 'pixerex-addons-for-elementor')
            ]
        );
        
        $this->add_control('pixerex_video_box_play_icon_switcher',
            [
                'label'         => __('Play Icon', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
        
        $this->add_control('pixerex_video_box_icon_hor_position', 
            [
                'label'         => __('Horizontal Position (%)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'label_block'   => true,
                'default'       => [
                    'size' => 50,
                ],
                'condition'     => [
                    'pixerex_video_box_play_icon_switcher'  => 'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon-container' => 'left: {{SIZE}}%;',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_icon_ver_position', 
            [
                'label'         => __('Vertical Position (%)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'label_block'   => true,
                'default'       => [
                    'size' => 50,
                ],
                'condition'     => [
                    'pixerex_video_box_play_icon_switcher'  => 'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon-container' => 'top: {{SIZE}}%;',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_video_box_description_text_section', 
            [
                'label'         => __('Description', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_video_box_video_text_switcher',
            [
                'label'         => __('Video Text', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_video_box_description_text', 
            [
                'label'         => __('Text', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::TEXTAREA,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Play Video','pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_video_box_video_text_switcher' => 'yes'
                ],
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('pixerex_video_box_description_ver_position', 
            [
                'label'         => __('Vertical Position (%)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'label_block'   => true,
                'default'       => [
                    'size' => 60,
                ],
                'condition'     => [
                    'pixerex_video_box_video_text_switcher' => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-description-container' => 'top: {{SIZE}}%;',
                ]
            ]
        );
        
         $this->add_control('pixerex_video_box_description_hor_position', 
            [
                'label'         => __('Horizontal Position (%)', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'label_block'   => true,
                'default'       => [
                    'size' => 50,
                    ],
                'condition'     => [
                    'pixerex_video_box_video_text_switcher' => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-description-container' => 'left: {{SIZE}}%;',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_video_box_text_style_section', 
            [
                'label'         => __('Video Box','pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'image_border',        
                'selector'      => '{{WRAPPER}} .pixerex-video-box-image-container, {{WRAPPER}} .pixerex-video-box-video-container',
            ]
        );
        
        //Border Radius Properties sepearated for responsive issues
        $this->add_responsive_control('pixerex_video_box_image_border_radius', 
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-image-container, {{WRAPPER}} .pixerex-video-box-video-container'  => 'border-top-left-radius: {{SIZE}}{{UNIT}}; border-top-right-radius: {{SIZE}}{{UNIT}}; border-bottom-left-radius: {{SIZE}}{{UNIT}}; border-bottom-right-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-addons-for-elementor'),
                'name'          => 'box_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-video-box-image-container',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_video_box_icon_style', 
            [
                'label'         => __('Play Icon','pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_video_box_play_icon_switcher'  => 'yes',
                ],
            ]
        );
        
        $this->add_control('pixerex_video_box_play_icon_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_play_icon_color_hover', 
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon-container:hover .pixerex-video-box-play-icon'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_play_icon_size',
            [
                'label'         => __('Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'  => 'px',
                    'size'  => 30,
                ],
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'          => 'pixerex_video_box_play_icon_background_color',
                'types'         => ['classic', 'gradient'],
                'selector'      => '{{WRAPPER}} .pixerex-video-box-play-icon-container',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'icon_border',   
                'selector'      => '{{WRAPPER}} .pixerex-video-box-play-icon-container',
            ]
        );
    
        $this->add_control('pixerex_video_box_icon_border_radius', 
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'  => 'px',
                    'size'  => 100,
                ],
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon-container'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_video_box_icon_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'default'       => [
                    'top'   => 40,
                    'right' => 40,
                    'bottom'=> 40,
                    'left'  => 40,
                    'unit'  => 'px'
                ],
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_video_box_icon_padding_hover',
            [
                'label'         => __('Hover Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-play-icon:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        
        $this->end_controls_section();
       
        $this->start_controls_section('pixerex_video_box_text_style', 
            [
                'label'         => __('Video Text', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_video_box_video_text_switcher' => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_text_color',
            [
                'label'         => __('Text Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-text'   => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_video_box_text_color_hover',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-description-container:hover .pixerex-video-box-text'   => 'color: {{VALUE}};',
                ]
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'text_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-video-box-text',
            ]
        );
        
        $this->add_control('pixerex_video_box_text_background_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-description-container'   => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_video_box_text_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-video-box-description-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','pixerex-addons-for-elementor'),
                'name'          => 'pixerex_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-video-box-text'
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        
        $settings   = $this->get_settings_for_display();
        
        $id         = $this->get_id();
        
        $video_type = $settings['pixerex_video_box_video_type'];
        
        $params     = $this->get_video_params();
        
        $thumbnail  = $this->get_video_thumbnail( $params['id'] );

        $image      = 'transparent';
    
        if( ! empty( $thumbnail ) ) {
            $image      = sprintf( 'url(\'%s\')', $thumbnail );
        }
    
        if( 'self' === $video_type ) {
            
            $overlay        = $settings['pixerex_video_box_image_switcher'];
            
            if( 'yes' !== $overlay )
                $image      = 'transparent';
            
            if ( empty( $settings['pixerex_video_box_self_hosted_remote'] ) ) {
                $hosted_url = $settings['pixerex_video_box_self_hosted']['url'];
            } else {
                $hosted_url = $settings['pixerex_video_box_self_hosted_remote'];
            }
        }
        
        $link       = $params['link'];
        
        $related = $settings['pixerex_video_box_suggested_videos'];
        
        $autoplay = $settings['pixerex_video_box_self_autoplay'];
        
        $mute = $settings['pixerex_video_box_mute'];
        
        $loop = $settings['pixerex_video_box_loop'];
        
        $controls = $settings['pixerex_video_box_controls'];
        
        $options = 'youtube' === $video_type ? '&rel=' : '?rel';
        $options .= 'yes' === $related ? '1' : '0';
        $options .= 'youtube' === $video_type ? '&mute=' : '&muted=';
        $options .= 'yes' === $mute ? '1' : '0';
        $options .= '&loop=';
        $options .= 'yes' === $loop ? '1' : '0';
        $options .= '&controls=';
        $options .= 'yes' === $controls ? '1' : '0';
        
        if( 'self' !== $video_type ) {
            if ( 'yes' === $autoplay && ! $this->has_image_overlay() ) {
                $options .= '&autoplay=1';
            }
        }
        
        if( 'vimeo' === $video_type ) {
            $options .= '&color=' . str_replace('#', '', $settings['vimeo_controls_color'] );
            
            if( 'yes' === $settings['vimeo_title'] ) {
                $options .= '&title=1';
            }
            
            if( 'yes' === $settings['vimeo_portrait'] ) {
                $options .= '&portrait=1';
            }
            
            if( 'yes' === $settings['vimeo_byline'] ) {
                $options .= '&byline=1';
            }
            
        }
        
        if ( $settings['pixerex_video_box_start'] || $settings['pixerex_video_box_end'] ) {
            
            if ( 'youtube' === $video_type ) {
                
                if ( $settings['pixerex_video_box_start'] ) {
                    $options .= '&start=' . $settings['pixerex_video_box_start'];
                }
                
                if ( $settings['pixerex_video_box_end'] ) {
                    $options .= '&end=' . $settings['pixerex_video_box_end'];
                }
                
            } elseif ( 'self' === $video_type ) {
                
                $hosted_url .= '#t=';
                
                if ( $settings['pixerex_video_box_start'] ) {
                    $hosted_url .= $settings['pixerex_video_box_start'];
                }
                
                if ( $settings['pixerex_video_box_end'] ) {
                    $hosted_url .= ',' . $settings['pixerex_video_box_end'];
                }
                
            }
            
        }
        
        if ( $loop ) {
            $options .= '&playlist=' . $params['id'];
        }
        
        if( 'self' === $video_type ) {
            
            $video_params = '';
            
            if( $controls ) {
                $video_params .= 'controls ';
            }
            if( $mute ) {
                $video_params .= 'muted ';
            }
            if( $loop ) {
                $video_params .= 'loop ';
            }
            if( $autoplay ) {
                $video_params .= 'autoplay';
            }
            
        }
        
        $this->add_inline_editing_attributes( 'pixerex_video_box_description_text' );
        
        $this->add_render_attribute('container', [
                'id'    => 'pixerex-video-box-container-' . $id,
                'class' => 'pixerex-video-box-container',
                'data-overlay'  => 'yes' === $settings['pixerex_video_box_image_switcher'] ? 'true' : 'false',
                'data-type'     => $video_type,
                'data-thumbnail' => !empty( $thumbnail )
            ]
        );
        
        $this->add_render_attribute('video_container', [
                'class' => 'pixerex-video-box-video-container',
            ]
        );
        
        
        if ( 'self' !== $video_type ) {
            $this->add_render_attribute('video_container', [
                    'data-src'  => $link . $options
                ]
            );
        }
        
    ?>

    <div <?php echo $this->get_render_attribute_string('container'); ?>>
        <?php $this->get_vimeo_header( $params['id'] ); ?>
        <div <?php echo $this->get_render_attribute_string('video_container'); ?>>
            <?php if ( 'self' === $video_type ) : ?>
                <video src="<?php echo esc_url( $hosted_url ); ?>" <?php echo $video_params; ?>></video>
            <?php endif; ?>
        </div>
            <div class="pixerex-video-box-image-container" style="background-image: <?php echo $image; ?>;">
        </div>
        
        <?php if( 'yes' === $settings['pixerex_video_box_play_icon_switcher'] && 'yes' !== $autoplay && !empty($thumbnail) ) : ?>
            <div class="pixerex-video-box-play-icon-container">
                <i class="pixerex-video-box-play-icon fa fa-play fa-lg"></i>
            </div>
        <?php endif; ?>
        <?php if( $settings['pixerex_video_box_video_text_switcher'] == 'yes' && !empty( $settings['pixerex_video_box_description_text'] ) ) : ?>
            <div class="pixerex-video-box-description-container">
                <p class="pixerex-video-box-text"><span <?php echo $this->get_render_attribute_string('pixerex_video_box_description_text'); ?>><?php echo $settings['pixerex_video_box_description_text']; ?></span></p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    }
    
    private function get_video_thumbnail( $id = '' ) {
        
        $settings       = $this->get_settings_for_display();
        
        $type           = $settings['pixerex_video_box_video_type'];
        
        $overlay        = $settings['pixerex_video_box_image_switcher'];
        
        if ( 'yes' !== $overlay ) {
            $size           = '';
            if( 'youtube' === $type ) {
                $size = $settings['pixerex_video_box_yt_thumbnail_size'];
            }
            $thumbnail_src  = Helper_Functions::get_video_thumbnail( $id, $type, $size );
        } else {
            $thumbnail_src  = $settings['pixerex_video_box_image']['url'];
        }
        
        return $thumbnail_src;
        
    }
    
    private function get_video_params() {
        
        $settings   = $this->get_settings_for_display();
        
        $type       = $settings['pixerex_video_box_video_type'];
        
        $identifier = $settings['pixerex_video_box_video_id_embed_selection'];
        
        $id         = $settings['pixerex_video_box_video_id'];
        
        $embed      = $settings['pixerex_video_box_video_embed'];
        
        $link       = $settings['pixerex_video_box_link'];
        
        if ( ! empty( $link ) ) {
            if ( 'youtube' === $type ) {
                $video_props    = Embed::get_video_properties( $link );
                $link           = Embed::get_embed_url( $link );
                $video_id       = $video_props['video_id'];
            } elseif ( 'vimeo' === $type ) {
                $mask = '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
                $video_id = substr( $link, strpos( $link, '.com/' ) + 5 );
				preg_match( $mask, $link, $matches );
				if( $matches ) {
					$video_id = $matches[1];
				} else {
					$video_id = substr( $link, strpos( $link, '.com/' ) + 5 );
				}
                $link = sprintf( 'https://player.vimeo.com/video/%s', $video_id );
            }
            
            $id = $video_id;
        } elseif ( ! empty( $id ) || ! empty ( $embed ) ) {
            
            if( 'id' === $identifier ) {
                $link = 'youtube' === $type ? sprintf('https://www.youtube.com/embed/%s', $id ) : sprintf('https://player.vimeo.com/video/%s', $id );
            } else {
                $link = $embed;
            }
            
        }
        
        return [ 
            'link' => $link,
            'id'    => $id
        ];
        
    }
    
    private function get_vimeo_header( $id ) {
        
        $settings = $this->get_settings_for_display();
        
        if( 'vimeo' !== $settings['pixerex_video_box_video_type'] ) {
            return;
        }
        
        $vimeo_data = Helper_Functions::get_vimeo_video_data( $id );

        if ( 'yes' === $settings['vimeo_portrait'] || 'yes' === $settings['vimeo_title'] || 'yes' === $settings['vimeo_byline']
		) {  
        ?>
		<div class="pixerex-video-box-vimeo-wrap">
			<?php if ( 'yes' === $settings['vimeo_portrait'] && !empty($vimeo_data['portrait']) ) { ?>
			<div class="pixerex-video-box-vimeo-portrait">
				<a href="<?php echo $vimeo_data['url']; ?>" target="_blank">
                    <img src="<?php echo $vimeo_data['portrait']; ?>" alt="">
                </a>
			</div>
			<?php } ?>
			<?php
			if ( 'yes' === $settings['vimeo_title'] || 'yes' === $settings['vimeo_byline'] ) { ?>
			<div class="pixerex-video-box-vimeo-headers">
				<?php if ( 'yes' === $settings['vimeo_title'] && !empty( $vimeo_data['title'] ) ) { ?>
				<div class="pixerex-video-box-vimeo-title">
					<a href="<?php echo $settings['pixerex_video_box_link']; ?>" target="_blank">
                        <?php echo $vimeo_data['title']; ?>
                    </a>
				</div>
				<?php } ?>
				<?php if ( 'yes' === $settings['vimeo_byline'] && !empty( $vimeo_data['user'] ) ) { ?>
				<div class="pixerex-video-box-vimeo-byline">
					<?php _e( 'from ', 'pixerex-addons-for-elementor' ); ?> <a href="<?php echo $vimeo_data['url']; ?>" target="_blank"><?php echo $vimeo_data['user']; ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
        <?php

        return isset( $vimeo_data['user'] ) ? true : false;
    }
    
    private function has_image_overlay() {
        
        $settings = $this->get_settings_for_display();

		return ! empty( $settings['pixerex_video_box_image']['url'] ) && 'yes' === $settings['pixerex_video_box_image_switcher'];
        
    }
    
}