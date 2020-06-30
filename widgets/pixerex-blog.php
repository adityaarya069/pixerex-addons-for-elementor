<?php

namespace PixerexAddons\Widgets;

use PixerexAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Blog extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-blog';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Blog', 'pixerex-addons-for-elementor') );
	}

    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_style_depends() {
        return [
            'font-awesome',
            'pixerex-addons'
        ];
    }
    
    public function get_script_depends() {
        return [
            'isotope-js',
            'jquery-slick',
            'pixerex-addons-js'
        ];
    }

    public function get_icon() {
        return 'pr-blog';
    }
    
    public function get_keywords() {
		return [ 'posts', 'grid', 'item', 'loop', 'query', 'portfolio' ];
	}

    public function get_categories() {
        return [ 'pixerex-elements' ];
    }
    
    
 
    // Adding the controls fields for Pixerex Blog
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        
        $this->start_controls_section('general_settings_section',
            [
                'label'         => __('General', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_skin',
            [
                'label'         => __('Skin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'classic'       => __('Classic', 'pixerex-addons-for-elementor'),
                    'modern'        => __('Modern', 'pixerex-addons-for-elementor'),
                    'cards'         => __('Cards', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'modern',
                'label_block'   => true
            ]
        );
        
        $this->add_control('pixerex_blog_grid',
            [
                'label'         => __('Grid', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
        
        $this->add_control('pixerex_blog_layout',
            [
                'label'             => __('Layout', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'even'      => __('Even', 'pixerex-addons-for-elementor'),
                    'masonry'   => __('Masonry', 'pixerex-addons-for-elementor'),
                ],
                'default'           => 'masonry',
                'condition'         => [
                    'pixerex_blog_grid' => 'yes'
                ]
            ]
        );
        
        $this->add_control('even_layout_notice', 
            [
                'raw'               => __('For even layout, you need to set a background color from style tab -> Box', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'         => [
                    'pixerex_blog_grid'     => 'yes',
                    'pixerex_blog_layout'   => 'even'
                ]
            ] 
        );
        
        $this->add_responsive_control('pixerex_blog_columns_number',
            [
                'label'         => __('Number of Columns', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    '100%'  => __('1 Column', 'pixerex-addons-for-elementor'),
                    '50%'   => __('2 Columns', 'pixerex-addons-for-elementor'),
                    '33.33%'=> __('3 Columns', 'pixerex-addons-for-elementor'),
                    '25%'   => __('4 Columns', 'pixerex-addons-for-elementor'),
                    '20%'       => __( '5 Columns', 'pixerex-addons-for-elementor' ),
					'16.66%'    => __( '6 Columns', 'pixerex-addons-for-elementor' ),
                ],
                'default'       => '33.33%',
                'tablet_default'=> '50%',
                'mobile_default'=> '100%',
                'render_type'   => 'template',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container'  => 'width: {{VALUE}};'
                ],
            ]
        );
        
        $this->add_control('pixerex_blog_number_of_posts',
            [
                'label'         => __('Posts Per Page', 'pixerex-addons-for-elementor'),
                'description'   => __('Set the number of per page','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'min'			=> 1,
                'default'		=> 3,
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('section_query_options',
            [
                'label'         => __('Query', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('category_filter_rule',
            [
                'label'       => __( 'Filter By Category Rule', 'pixerex-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'category__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'category__in'     => __( 'Match Categories', 'pixerex-addons-for-elementor' ),
                    'category__not_in' => __( 'Exclude Categories', 'pixerex-addons-for-elementor' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_categories',
            [
                'label'         => __( 'Categories', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'description'   => __('Get posts for specific category(s)','pixerex-addons-for-elementor'),
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_categories(),
            ]
        );
        
        $this->add_control('tags_filter_rule',
            [
                'label'       => __( 'Filter By Tag Rule', 'pixerex-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'tag__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'tag__in'     => __( 'Match Tags', 'pixerex-addons-for-elementor' ),
                    'tag__not_in' => __( 'Exclude Tags', 'pixerex-addons-for-elementor' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_tags',
            [
                'label'         => __( 'Tags', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'description'   => __('Get posts for specific tag(s)','pixerex-addons-for-elementor'),
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_tags(),        
            ]
        );
        
        $this->add_control('author_filter_rule',
            [
                'label'       => __( 'Filter By Author Rule', 'pixerex-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'author__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'author__in'     => __( 'Match Authors', 'pixerex-addons-for-elementor' ),
                    'author__not_in' => __( 'Exclude Authors', 'pixerex-addons-for-elementor' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_users',
            [
                'label'         => __( 'Authors', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_users(),        
            ]
        );
        
        $this->add_control('posts_filter_rule',
            [
                'label'       => __( 'Filter By Post Rule', 'pixerex-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'post__not_in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'post__in'     => __( 'Match Post', 'pixerex-addons-for-elementor' ),
                    'post__not_in' => __( 'Exclude Post', 'pixerex-addons-for-elementor' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_posts_exclude',
            [
                'label'         => __( 'Posts', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_posts_list(),        
            ]
        );
        
        $this->add_control('pixerex_blog_offset',
			[
				'label'         => __( 'Offset Count', 'pixerex-addons-for-elementor' ),
                'description'   => __('This option is used to exclude number of initial posts from being display.','pixerex-addons-for-elementor'),
				'type' 			=> Controls_Manager::NUMBER,
                'default' 		=> '0',
				'min' 			=> '0',
			]
		);
        
        $this->add_control('pixerex_blog_order_by',
            [
                'label'         => __( 'Order By', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'label_block'   => true,
                'options'       => [
                    'none'  => __('None', 'pixerex-addons-for-elementor'),
                    'ID'    => __('ID', 'pixerex-addons-for-elementor'),
                    'author'=> __('Author', 'pixerex-addons-for-elementor'),
                    'title' => __('Title', 'pixerex-addons-for-elementor'),
                    'name'  => __('Name', 'pixerex-addons-for-elementor'),
                    'date'  => __('Date', 'pixerex-addons-for-elementor'),
                    'modified'=> __('Last Modified', 'pixerex-addons-for-elementor'),
                    'rand'  => __('Random', 'pixerex-addons-for-elementor'),
                    'comment_count'=> __('Number of Comments', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'date'
            ]
        );
        
        $this->add_control('pixerex_blog_order',
            [
                'label'         => __( 'Order', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'label_block'   => true,
                'options'       => [
                    'DESC'  => __('Descending', 'pixerex-addons-for-elementor'),
                    'ASC'   => __('Ascending', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'DESC'
            ]
        );
            
        $this->end_controls_section();

        $this->start_controls_section('pixerex_blog_general_settings',
            [
                'label'         => __('Featured Image', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'featured_image',
				'default' => 'full'
			]
		);
        
        $this->add_control('pixerex_blog_hover_color_effect',
            [
                'label'         => __('Overlay Effect', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __('Choose an overlay color effect','pixerex-addons-for-elementor'),
                'options'       => [
                    'none'     => __('None', 'pixerex-addons-for-elementor'),
                    'framed'   => __('Framed', 'pixerex-addons-for-elementor'),
                    'diagonal' => __('Diagonal', 'pixerex-addons-for-elementor'),
                    'bordered' => __('Bordered', 'pixerex-addons-for-elementor'),
                    'squares'  => __('Squares', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'framed',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_blog_skin!' => 'classic'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_hover_image_effect',
            [
                'label'         => __('Hover Effect', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __('Choose a hover effect for the image','pixerex-addons-for-elementor'),
                'options'       => [
                    'none'   => __('None', 'pixerex-addons-for-elementor'),
                    'zoomin' => __('Zoom In', 'pixerex-addons-for-elementor'),
                    'zoomout'=> __('Zoom Out', 'pixerex-addons-for-elementor'),
                    'scale'  => __('Scale', 'pixerex-addons-for-elementor'),
                    'gray'   => __('Grayscale', 'pixerex-addons-for-elementor'),
                    'blur'   => __('Blur', 'pixerex-addons-for-elementor'),
                    'bright' => __('Bright', 'pixerex-addons-for-elementor'),
                    'sepia'  => __('Sepia', 'pixerex-addons-for-elementor'),
                    'trans'  => __('Translate', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'zoomin',
                'label_block'   => true
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumb_min_height',
            [
                'label'         => __('Thumbnail Min Height', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 300,
                    ],
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'min-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumb_max_height',
            [
                'label'         => __('Thumbnail Max Height', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 300,
                    ],
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'max-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumbnail_fit',
            [
                'label'         => __('Thumbnail Fit', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'cover'  => __('Cover', 'pixerex-addons-for-elementor'),
                    'fill'   => __('Fill', 'pixerex-addons-for-elementor'),
                    'contain'=> __('Contain', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'cover',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'object-fit: {{VALUE}}'
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_content_settings',
            [
                'label'         => __('Display Options', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_title_tag',
			[
				'label'			=> __( 'Title HTML Tag', 'pixerex-addons-for-elementor' ),
				'description'	=> __( 'Select a heading tag for the post title.', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'h2',
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
				'label_block'	=> true,
			]
		);
        
        $this->add_responsive_control('pixerex_blog_posts_columns_spacing',
            [
                'label'         => __('Rows Spacing', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 200,
                    ],
                ],
                'render_type'   => 'template',
                'condition'     => [
                    'pixerex_blog_grid'   => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container' => 'margin-bottom: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_posts_spacing',
            [
                'label'         => __('Columns Spacing', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
					'size' => 5,
				],
                'range'         => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
                'selectors'     => [
					'{{WRAPPER}} .pixerex-blog-post-outer-container' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 )',
					'{{WRAPPER}} .pixerex-blog-wrap' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
				],
                'condition'     => [
                    'pixerex_blog_grid'   => 'yes'
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_flip_text_align',
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
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_posts_options',
            [
                'label'         => __('Post Options', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_excerpt',
            [
                'label'         => __('Show Post Content', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('content_source',
            [
                'label'         => __('Get Content From', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'excerpt'       => __('Post Excerpt', 'pixerex-addons-for-elementor'),
                    'full'          => __('Post Full Content', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'excerpt',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_blog_excerpt'  => 'yes',
                ]
            ]
        );

        $this->add_control('pixerex_blog_excerpt_length',
            [
                'label'         => __('Excerpt Length', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'description'   => __('Excerpt is used for article summary with a link to the whole entry. The default except length is 55','pixerex-addons-for-elementor'),
                'default'       => 55,
                'condition'     => [
                    'pixerex_blog_excerpt'  => 'yes',
                    'content_source'        => 'excerpt'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_excerpt_type',
            [
                'label'         => __('Excerpt Type', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'dots'   => __('Dots', 'pixerex-addons-for-elementor'),
                    'link'   => __('Link', 'pixerex-addons-for-elementor'),
                ],
                'default'       => 'dots',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_blog_excerpt'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('read_more_full_width',
            [
                'label'         => __('Full Width', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'prefix_class'  => 'pixerex-blog-cta-full-',
                'condition'     => [
                    'pixerex_blog_excerpt'      => 'yes',
                    'pixerex_blog_excerpt_type' => 'link'
                ]
            ]
        );

        $this->add_control('pixerex_blog_excerpt_text',
			[
				'label'			=> __( 'Read More Text', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'default'   => __( 'Read More →', 'pixerex-addons-for-elementor' ),
                'condition'     => [
                    'pixerex_blog_excerpt'      => 'yes',
                    'pixerex_blog_excerpt_type' => 'link'
                ]
			]
		);
        
        $this->add_control('pixerex_blog_author_meta',
            [
                'label'         => __('Author Meta', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_date_meta',
            [
                'label'         => __('Date Meta', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_categories_meta',
            [
                'label'         => __('Categories Meta', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Display or hide categories meta','pixerex-addons-for-elementor'),
                'default'       => 'yes',
            ]
        );

        $this->add_control('pixerex_blog_comments_meta',
            [
                'label'         => __('Comments Meta', 'pixerex-addons-for-elementor'),
                'description'   => __('Display or hide comments meta','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_tags_meta',
            [
                'label'         => __('Tags Meta', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Display or hide post tags','pixerex-addons-for-elementor'),
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_post_format_icon',
            [
                'label'         => __( 'Post Format Icon', 'pixerex-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __( 'Please note that post format icon is hidden for 3 and 4 columns', 'pixerex-addons-for-elementor' ),
                'default'       => 'yes',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_advanced_settings',
            [
                'label'         => __('Advanced Settings', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_cat_tabs',
            [
                'label'         => __('Filter Tabs', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel!'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('filter_tabs_type',
            [
                'label'       => __( 'Get Tabs From', 'pixerex-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'categories',
                'label_block' => true,
                'options'     => [
                    'categories'    => __( 'Categories', 'pixerex-addons-for-elementor' ),
                    'tags'          => __( 'Tags', 'pixerex-addons-for-elementor' ),
                ],
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
            ]
        );
        
        $this->add_control('filter_tabs_notice', 
            [
                'raw'               => __('Please make sure to select the categories/tags you need to show from Query tab.', 'pixerex-addons-for-elemeentor'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
            ] 
        );
        
        $this->add_control('pixerex_blog_tab_label',
			[
				'label'			=> __( 'First Tab Label', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('All', 'pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_blog_filter_align',
            [
                'label'         => __( 'Alignment', 'pixerex-addons-for-elementor' ),
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
                    'flex-end'      => [
                        'title' => __( 'Right', 'pixerex-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'toggle'        => false,
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-filter' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('pixerex_blog_new_tab',
            [
                'label'         => __('Links in New Tab', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable links to be opened in a new tab','pixerex-addons-for-elementor'),
                'default'       => 'yes',
            ]
        );
 
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_carousel_settings',
            [
                'label'         => __('Carousel', 'pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_blog_grid' => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel',
            [
                'label'         => __('Enable Carousel', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_fade',
            [
                'label'         => __('Fade', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_columns_number' => '100%'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_play',
            [
                'label'         => __('Auto Play', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_autoplay_speed',
			[
				'label'			=> __( 'Autoplay Speed', 'pixerex-addons-for-elementor' ),
				'description'	=> __( 'Autoplay Speed means at which time the next slide should come. Set a value in milliseconds (ms)', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 5000,
				'condition'		=> [
					'pixerex_blog_carousel' => 'yes',
                    'pixerex_blog_carousel_play' => 'yes',
				],
			]
        );
        
        $this->add_control('pixerex_blog_carousel_center',
            [
                'label'         => __('Center Mode', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel' => 'yes',
                ]
            ]
        );

        $this->add_control('pixerex_blog_carousel_spacing',
			[
				'label' 		=> __( 'Slides\' Spacing', 'pixerex-addons-for-elementor' ),
                'description'   => __('Set a spacing value in pixels (px)', 'pixerex-addons-for-elementor'),
				'type'			=> Controls_Manager::NUMBER,
                'default'		=> '15',
                'condition'     => [
                    'pixerex_blog_carousel' => 'yes',
                ]
			]
		);
        
        $this->add_control('pixerex_blog_carousel_dots',
            [
                'label'         => __('Navigation Dots', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_arrows',
            [
                'label'         => __('Navigation Arrows', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_carousel_arrows_pos',
            [
                'label'         => __('Arrows Position', 'pixerex-addons-for-elementor'),
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
					'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_arrows'  => 'yes'
				],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap a.carousel-arrow.carousel-next' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pixerex-blog-wrap a.carousel-arrow.carousel-prev' => 'left: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_pagination_section',
            [
                'label'         => __('Pagination', 'pixerex-addons-for-elementor')
            ]
        );
        
        $this->add_control('pixerex_blog_paging',
            [
                'label'         => __('Enable Pagination', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Pagination is the process of dividing the posts into discrete pages','pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_total_posts_number',
            [
                'label'         => __('Total Number of Posts', 'pixerex-addons-for-elementor'),
                'description'   => __('Set the number of posts in all pages','pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => wp_count_posts()->publish,
                'min'			=> 1,
                'condition'     => [
                    'pixerex_blog_paging'      => 'yes',
                ]
            ]
        );
        
        $this->add_control('pagination_strings',
            [
                'label'         => __('Enable Pagination Next/Prev Strings', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_prev_text',
			[
				'label'			=> __( 'Previous Page String', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('Previous','pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                    'pagination_strings'    => 'yes'
                ]
			]
		);

        $this->add_control('pixerex_blog_next_text',
			[
				'label'			=> __( 'Next Page String', 'pixerex-addons-for-elementor' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('Next','pixerex-addons-for-elementor'),
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                    'pagination_strings'    => 'yes'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_blog_pagination_align',
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
                'selectors_dictionary'  => [
                    'left'      => 'flex-start',
                    'center'    => 'center',
                    'right'     => 'flex-end',
                ],
                'default'       => 'right',
                'condition'     => [
                    'pixerex_blog_paging'      => 'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container .page-numbers' => 'justify-content: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_image_style_section',
            [
                'label'         => __('Image', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_blog_plus_color',
            [
                'label'         => __('Plus Sign Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container:before, {{WRAPPER}} .pixerex-blog-thumbnail-container:after' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'pixerex_blog_skin!' => 'classic'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_overlay_color',
            [
                'label'         => __('Overlay Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-framed-effect, {{WRAPPER}} .pixerex-blog-bordered-effect, {{WRAPPER}} .pixerex-blog-squares-effect:before,{{WRAPPER}} .pixerex-blog-squares-effect:after,{{WRAPPER}} .pixerex-blog-squares-square-container:before,{{WRAPPER}} .pixerex-blog-squares-square-container:after, {{WRAPPER}} .pixerex-blog-format-container:hover, {{WRAPPER}} .pixerex-blog-thumbnail-overlay' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_border_effect_color',
            [
                'label'         => __('Border Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'condition'     => [
                    'pixerex_blog_hover_color_effect'  => 'bordered',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-link:before, {{WRAPPER}} .pixerex-blog-post-link:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .pixerex-blog-thumbnail-container img',
            ]
        );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filters', 'pixerex-addons-for-elementor'),
				'selector'  => '{{WRAPPER}} .pixerex-blog-post-container:hover .pixerex-blog-thumbnail-container img'
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_format_style_section',
            [
                'label'         => __('Post Format Icon', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_post_format_icon' => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_format_icon_size',
            [
                'label'         => __('Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'description'   => __('Choose icon size in (PX, EM)', 'pixerex-addons-for-elementor'),
                'range'         => [
                    'em'    => [
                        'min'       => 1,
                        'max'       => 10,
                    ],
                ],
                'size_units'    => ['px', "em"],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-format-icon, {{WRAPPER}} .pixerex-blog-thumbnail-overlay i' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_format_icon_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-format-container i, {{WRAPPER}} .pixerex-blog-thumbnail-overlay i'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('pixerex_blog_format_icon_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-format-container:hover i, {{WRAPPER}} .pixerex-blog-thumbnail-overlay i:hover'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('pixerex_blog_format_back_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-format-container, {{WRAPPER}} .pixerex-blog-thumbnail-overlay i'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_format_back_hover_color',
            [
                'label'         => __('Hover Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-format-container:hover, {{WRAPPER}} .pixerex-blog-thumbnail-overlay i:hover'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_blog_format_border',
                'selector'      => '{{WRAPPER}} .pixerex-blog-thumbnail-overlay i',
            ]
        );
        
        $this->add_control('pixerex_blog_format_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-overlay i' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_format_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-overlay i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'     => [
                    'pixerex_blog_skin' => 'classic'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_title_style_section',
            [
                'label'         => __('Title', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_title_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-entry-title, {{WRAPPER}} .pixerex-blog-entry-title a',
            ]
        );
        
        $this->add_control('pixerex_blog_title_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-title a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_title_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-title:hover a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_meta_style_section',
            [
                'label'         => __('Meta', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_meta_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-entry-meta a',
            ]
        );
        
        $this->add_control('pixerex_blog_meta_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-meta, {{WRAPPER}} .pixerex-blog-entry-meta a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_meta_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-meta a:hover, {{WRAPPER}} .pixerex-blog-entry-meta span:hover'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_tags_style_section',
            [
                'label'         => __('Tags', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_tags_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-post-tags-container a',
            ]
        );
        
        $this->add_control('pixerex_blog_tags_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-tags-container, {{WRAPPER}} .pixerex-blog-post-tags-container a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_tags_hoer_color',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-tags-container a:hover'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_content_style_section',
            [
                'label'         => __('Content Box', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_content_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-post-content',
            ]
        );
        
        $this->add_control('pixerex_blog_post_content_color',
            [
                'label'         => __('Text Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_content_background_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#f5f5f5',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_blog_box_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-blog-content-wrapper',
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_content_margin',
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_content_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_box_style_section',
            [
                'label'         => __('Box', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_blog_box_background_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-container'  => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('prmeium_blog_box_padding',
            [
                'label'         => __('Spacing', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_inner_box_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_pagination_Style',
            [
                'label'         => __('Pagination', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'pixerex_blog_pagination_typo',
                'selector'          => '{{WRAPPER}} .pixerex-blog-pagination-container li > .page-numbers',
            ]
        );
        
        $this->start_controls_tabs('pixerex_blog_pagination_colors');
        
        $this->start_controls_tab('pixerex_blog_pagination_nomral',
            [
                'label'         => __('Normal', 'pixerex-addons-for-elementor'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_color', 
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_blog_pagination_hover',
            [
                'label'         => __('Hover', 'pixerex-addons-for-elementor'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_hover_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers:hover' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_hover_color', 
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_blog_pagination_active',
            [
                'label'         => __('Active', 'pixerex-addons-for-elementor'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_active_color', 
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li span.current' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_active_color', 
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li span.current' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_blog_border',
                'separator'     => 'before',
                'selector'      => '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers',
            ]
        );
        
        $this->add_control('pixerex_blog_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_responsive_control('prmeium_blog_pagination_margin',
            [
                'label'         => __('Margin', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_pagination_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_dots_style',
            [
                'label'         => __('Carousel Dots', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_dots'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('carousel_dot_navigation_color',
			[
				'label' 		=> __( 'Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control('carousel_dot_navigation_active_color',
			[
				'label' 		=> __( 'Active Color', 'pixerex-addons-for-elementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li.slick-active' => 'color: {{VALUE}}'
				]
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_arrows_style',
            [
                'label'         => __('Carousel Arrows', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_arrows'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('arrow_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_blog_carousel_arrow_size',
            [
                'label'         => __('Size', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_arrow_background',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control('pixerex_blog_carousel_arrow_padding',
            [
                'label'         => __('Padding', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_read_more_style',
            [
                'label'         => __('Call to Action', 'pixerex-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_excerpt'      => 'yes',
                    'pixerex_blog_excerpt_type' => 'link'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_read_more_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link',
            ]
        );
        
        $this->add_responsive_control('read_more_spacing',
            [
                'label'             => __('Spacing', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::SLIDER,
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link'  => 'margin-top: {{SIZE}}px',
                ]
            ]
        );
        
        $this->start_controls_tabs('read_more_style_tabs');
        
        $this->start_controls_tab('read_more_tab_normal',
            [
                'label'         => __('Normal', 'pixerex-addons-for-elementor'),
                
            ]
        );
        
         $this->add_control('pixerex_blog_read_more_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link'  => 'color: {{VALUE}};',
                ]
            ]
        );
         
        $this->add_control('read_more_background_color',
            [
                'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('read_more_tab_hover',
            [
                'label'         => __('Hover', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_read_more_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link:hover'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('read_more_hover_background_color',
            [
                'label'         => __('Hover Background Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link:hover'  => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'read_more_border',
                'separator'         => 'before',
                'selector'          => '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link',
            ]
        );

        $this->add_control('read_more_border_radius',
            [
                'label'             => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px','em','%'],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('read_more_padding',
            [
                'label'             => __('Padding', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-blog-post-content .pixerex-blog-excerpt-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_filter_style',
            [
                'label'     => __('Filter','pixerex-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pixerex_blog_cat_tabs'    => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_filter_typo',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .pixerex-blog-cats-container li a.category',
            ]
        );

        $this->start_controls_tabs('tabs_filter');

        $this->start_controls_tab('tab_filter_normal',
            [
                'label'         => __('Normal', 'pixerex-addons-for-elementor'),
            ]
        );

        $this->add_control('pixerex_blog_filter_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.category span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control('pixerex_blog_background_color',
           [
               'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
               'type'          => Controls_Manager::COLOR,
               'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'background-color: {{VALUE}};',
               ],
           ]
       );

       $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'pixerex_blog_filter_border',
                'selector'          => '{{WRAPPER}} .pixerex-blog-cats-container li a.category',
            ]
        );

        $this->add_control('pixerex_blog_filter_border_radius',
            [
                'label'             => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px','em','%'],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.category'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator'         => 'after'
            ]
        );

       $this->end_controls_tab();

       $this->start_controls_tab('tab_filter_active',
            [
                'label'         => __('Active', 'pixerex-addons-for-elementor'),
            ]
        );
        
        $this->add_control('pixerex_blog_filter_active_color',
            [
                'label'         => __('Color', 'pixerex-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.active span' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_background_active_color',
            [
               'label'         => __('Background Color', 'pixerex-addons-for-elementor'),
               'type'          => Controls_Manager::COLOR,
               'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                   '{{WRAPPER}} .pixerex-blog-cats-container li a.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'              => 'filter_active_border',
                'selector'          => '{{WRAPPER}} .pixerex-blog-cats-container li a.active',
            ]
        );

        $this->add_control('filter_active_border_radius',
            [
                'label'             => __('Border Radius', 'pixerex-addons-for-elementor'),
                'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px','em','%'],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.active'  => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'separator'         => 'after'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_blog_filter_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-blog-cats-container li a.category'
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_filter_margin',
                [
                    'label'             => __('Margin', 'pixerex-addons-for-elementor'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'             => [
                        '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_filter_padding',
                [
                    'label'             => __('Padding', 'pixerex-addons-for-elementor'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                'selectors'             => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
       
    }
    
    /*
     * Renders post content
     * 
     * @since 3.0.5
     * @access protected
     */
    protected function get_post_content() {
        
        $settings = $this->get_settings();
        
        if ( 'yes' !== $settings['pixerex_blog_excerpt'] ) {
            return;
        }
        
        $src = $settings['content_source'];
        
        $excerpt_type = $settings['pixerex_blog_excerpt_type'];
        $excerpt_text = $settings['pixerex_blog_excerpt_text'];
        
        $length = $settings['pixerex_blog_excerpt_length']
        
    ?>
        <div class="pixerex-blog-post-content" style="<?php if ( $settings['pixerex_blog_post_format_icon'] !== 'yes' ) : echo 'margin-left:0px;'; endif; ?>">
            <?php
                echo pixerex_blog_get_excerpt_by_id( $src, $length, $excerpt_type, $excerpt_text );
            ?>
        </div>
    <?php
    }

    /*
     * Renders post format icon
     * 
     * @since 3.0.5
     * @access protected
     */
    protected function get_post_format_icon() {
        
        $post_format = get_post_format();
        
        switch( $post_format ) {
            case 'aside':
                $post_format = 'file-text-o';
                break;
            case 'audio':
                $post_format = 'music';
                break;
            case 'gallery':
                $post_format = 'file-image-o';
                break;
            case 'image':
                $post_format = 'picture-o';
                break;
            case 'link':
                $post_format = 'link';
                break;
            case 'quote':
                $post_format = 'quote-left';
                break;
            case 'video':
                $post_format = 'video-camera';
                break;
            default: 
                $post_format = 'thumb-tack';
        }
    ?>
        <i class="pixerex-blog-format-icon fa fa-<?php echo $post_format; ?>"></i>
    <?php 
    }
    
    /*
     * Get Post Thumbnail
     * 
     * 
     * Renders HTML markup for post thumbnail
     * 
     * @since 3.0.5
     * @access protected
     * 
     * @param $target string link target
     */
    protected function get_post_thumbnail( $target ) {
        
        $settings = $this->get_settings_for_display();
        
        $skin = $settings['pixerex_blog_skin'];
        
        $settings['featured_image']      = [
			'id' => get_post_thumbnail_id(),
		];
        
        $thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'featured_image' );
        
        if( empty( $thumbnail_html ) )
            return;
        
        if( 'classic' !== $skin ): ?>
            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>">
        <?php endif;
            echo $thumbnail_html;
        if( 'classic' !== $skin ): ?>
            </a>
        <?php endif;
    }

    /*
     * Renders post skin
     * 
     * @since 3.0.5
     * @access protected
     */
    protected function get_post_layout() {
        
        $settings = $this->get_settings();
        
        $image_effect = $settings['pixerex_blog_hover_image_effect'];
        
        $post_effect = $settings['pixerex_blog_hover_color_effect'];
        
        if( $settings['pixerex_blog_new_tab'] == 'yes' ) {
            $target = '_blank';
        } else {
            $target = '_self';
        }
        
        $skin = $settings['pixerex_blog_skin'];
        
        $post_id = get_the_ID();
        
        $key = 'post_' . $post_id;
        
        $tax_key = sprintf( '%s_tax', $key );
        
        $wrap_key = sprintf( '%s_wrap', $key );
        
        $content_key = sprintf( '%s_content', $key );
        
        $this->add_render_attribute( $tax_key, 'class', 'pixerex-blog-post-outer-container' );
        
        $this->add_render_attribute( $wrap_key, 'class', [ 
            'pixerex-blog-post-container',
            'pixerex-blog-skin-' . $skin,
        ] );
        
        $thumb = ( ! has_post_thumbnail() ) ? 'empty-thumb' : '';
        
        if ( 'yes' === $settings['pixerex_blog_cat_tabs'] && 'yes' !== $settings['pixerex_blog_carousel'] ) {
            
            $filter_rule = $settings['filter_tabs_type'];
            
            $taxonomies = 'categories' === $filter_rule ? get_the_category( $post_id ) : get_the_tags( $post_id );
            
            if( ! empty( $taxonomies ) ) {
                foreach( $taxonomies as $index => $taxonomy ) {
                
                    $taxonomy_key = 'categories' === $filter_rule ? $taxonomy->cat_name : $taxonomy->name;

                    $attr_key = str_replace( ' ', '-', $taxonomy_key );

                    $this->add_render_attribute( $tax_key, 'class', strtolower( $attr_key ) );
                }
            }
            
            
        }
        
        $this->add_render_attribute( $content_key, 'class', [ 
            'pixerex-blog-content-wrapper',
            $thumb,
        ] );
        
    ?>
        <div <?php echo $this->get_render_attribute_string( $tax_key ); ?>>
            <div <?php echo $this->get_render_attribute_string( $wrap_key ); ?>>
                <div class="pixerex-blog-thumb-effect-wrapper">
                    <div class="pixerex-blog-thumbnail-container <?php echo 'pixerex-blog-' . $image_effect . '-effect';?>">
                        <?php $this->get_post_thumbnail( $target ); ?>
                    </div>
                    <?php if( 'classic' !== $skin ) : ?>
                        <div class="pixerex-blog-effect-container <?php echo 'pixerex-blog-'. $post_effect . '-effect'; ?>">
                            <a class="pixerex-blog-post-link" href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
                            <?php if( $settings['pixerex_blog_hover_color_effect'] === 'squares' ) : ?>
                                <div class="pixerex-blog-squares-square-container"></div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="pixerex-blog-thumbnail-overlay">    
                            <a class="elementor-icon" href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>">
                                <?php if( $settings['pixerex_blog_post_format_icon'] === 'yes' ) : ?>
                                    <?php echo $this->get_post_format_icon(); ?>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if( 'cards' === $skin ) : ?>
                    <div class="pixerex-blog-author-thumbnail">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) ); ?>
                    </div>
                <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
                    <div class="pixerex-blog-inner-container">
                        <?php if( $settings['pixerex_blog_post_format_icon'] === 'yes' ) : ?>
                        <div class="pixerex-blog-format-container">
                            <a class="pixerex-blog-format-link" href="<?php the_permalink(); ?>" title="<?php if( get_post_format() === ' ') : echo 'standard' ; else : echo get_post_format();  endif; ?>" target="<?php echo esc_attr( $target ); ?>"><?php $this->get_post_format_icon(); ?></a>
                        </div>
                        <?php endif; ?>
                        <div class="pixerex-blog-entry-container">
                            <?php
                                $this->get_post_title( $target );
                                if ( 'cards' !== $skin ) {
                                    $this->get_post_meta( $target );
                                }

                            ?>

                        </div>
                    </div>

                    <?php
                        $this->get_post_content();
                        if ( 'cards' === $skin ) {
                            $this->get_post_meta( $target );
                        }
                        
                    ?>
                    
                    <?php if( $settings['pixerex_blog_tags_meta'] === 'yes' && has_tag() ) : ?>
                        <div class="pixerex-blog-post-tags-container" style="<?php if( $settings['pixerex_blog_post_format_icon'] !== 'yes' ) : echo 'margin-left:0px;'; endif; ?>">
                            <span class="pixerex-blog-post-tags">
                                <i class="fa fa-tags fa-fw"></i>
                                    <?php the_tags(' ', ', '); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php }
    
    /*
     * Render post title
     * 
     * @since 3.4.4
     * @access protected
     */
    protected function get_post_title( $link_target ) {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'title', 'class', 'pixerex-blog-entry-title' );
        
    ?>
        
        <<?php echo $settings['pixerex_blog_title_tag'] . ' ' . $this->get_render_attribute_string('title'); ?>>
            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                <?php the_title(); ?>
            </a>
        </<?php echo $settings['pixerex_blog_title_tag']; ?>>
        
    <?php   
    }
    
    /*
     * Get Post Meta
     * 
     * @since 3.4.4
     * @access protected
     */
    protected function get_post_meta( $link_target ) {
        
        $settings = $this->get_settings();

        $author_meta = $settings['pixerex_blog_author_meta'];
        
        $data_meta = $settings['pixerex_blog_date_meta'];

        $categories_meta = $settings['pixerex_blog_categories_meta'];

        $comments_meta = $settings['pixerex_blog_comments_meta'];

        if( 'yes' === $data_meta ) {
            $date_format = get_option('date_format');
        }
        
        if( 'yes' === $comments_meta ) {

            $comments_strings = [
                'no-comments'           => __( 'No Comments', 'pixerex-addons-for-elementor' ),
				'one-comment'           => __( '1 Comment', 'pixerex-addons-for-elementor' ),
				'multiple-comments'     => __( '% Comments', 'pixerex-addons-for-elementor' ),
            ];

        }

        
        
    ?>
        
        <div class="pixerex-blog-entry-meta" style="<?php if( $settings['pixerex_blog_post_format_icon'] !== 'yes' ) : echo 'margin-left:0px'; endif; ?>">
        
            <?php if( $author_meta === 'yes' ) : ?>
                <span class="pixerex-blog-post-author pixerex-blog-meta-data">
                    <i class="fa fa-user fa-fw"></i><?php the_author_posts_link(); ?>
                </span>
            <?php endif; ?>

            <?php if( $data_meta === 'yes' ) : ?>
                <span class="pixerex-blog-meta-separator">|</span>
                <span class="pixerex-blog-post-time pixerex-blog-meta-data">
                    <i class="fa fa-calendar fa-fw"></i>
                    <span><?php the_time( $date_format ); ?></span>
                </span>
            <?php endif; ?>

            <?php if( $categories_meta === 'yes' ) : ?>
                <span class="pixerex-blog-meta-separator">|</span>
                <span class="pixerex-blog-post-categories pixerex-blog-meta-data">
                    <i class="fa fa-align-left fa-fw"></i>
                    <?php the_category(', '); ?>
                </span>
            <?php endif; ?>

            <?php if( $comments_meta === 'yes' ) : ?>
                <span class="pixerex-blog-meta-separator">|</span>
                <span class="pixerex-blog-post-comments pixerex-blog-meta-data">
                    <i class="fa fa-comments-o fa-fw"></i>
                    <span>
                        <?php comments_popup_link( $comments_strings['no-comments'], $comments_strings['one-comment'], $comments_strings['multiple-comments'] ); ?>
                    </span>
                </span>
            <?php endif; ?>
        </div>
        
    <?php
    }
    
    /*
     * Get Filter Tabs Markup
     * 
     * @since 3.11.2
     * @access protected
     */
    protected function get_filter_tabs_markup() {
        
        $settings = $this->get_settings();
        
        $filter_rule = $settings['filter_tabs_type'];
        
        $filters = 'categories' === $filter_rule ? $settings['pixerex_blog_categories'] : $settings['pixerex_blog_tags'];
        
        if( empty( $filters ) )
            return;
        
        ?>
        <div class="pixerex-blog-filter">
            <ul class="pixerex-blog-cats-container">
                <?php if( ! empty( $settings['pixerex_blog_tab_label'] ) ) : ?>
                    <li>
                        <a href="javascript:;" class="category active" data-filter="*">
                            <span><?php echo esc_html( $settings['pixerex_blog_tab_label'] ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php foreach( $filters as $index => $filter ) {
                        $key = 'blog_category_' . $index;

                        if( 'categories' === $filter_rule ) {
                            $name = get_cat_name( $filter );
                        } else {
                            $tag = get_tag( $filter );
                            
                            $name = ucfirst( $tag->name );
                        }
                        
                        $name_filter = str_replace(' ', '-', $name );
                        $name_lower = strtolower( $name_filter );

                        $this->add_render_attribute( $key,
                            'class', [
                                'category'
                            ]
                        );

                        if( empty( $settings['pixerex_blog_tab_label'] ) && 0 === $index ) {
                            $this->add_render_attribute( $key,
                                'class', [
                                    'active'
                                ]
                            );
                        }
                    ?>
                        <li>
                            <a href="javascript:;" <?php echo $this->get_render_attribute_string( $key ); ?> data-filter=".<?php echo esc_attr( $name_lower ); ?>">
                                <span><?php echo $name; ?></span>
                            </a>
                        </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }

    /**
	 * Render Blog output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
    protected function render() {
        
        $paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
        
        $settings = $this->get_settings();

        $offset = ! empty( $settings['pixerex_blog_offset'] ) ? $settings['pixerex_blog_offset'] : 0;
        
        $post_per_page = ! empty( $settings['pixerex_blog_number_of_posts'] ) ? $settings['pixerex_blog_number_of_posts'] : 3;
        
        $new_offset = $offset + ( ( $paged - 1 ) * $post_per_page );
        
        $post_args = pixerex_blog_get_post_settings( $settings );

        $posts = pixerex_blog_get_post_data( $post_args, $paged , $new_offset );

        if( ! count( $posts ) ) {

            $this->get_empty_query_message();
            return;

        }
        
        switch( $settings['pixerex_blog_columns_number'] ) {
            case '100%' :
                $col_number = 'col-1';
                break;
            case '50%' :
                $col_number = 'col-2';
                break;
            case '33.33%' :
                $col_number = 'col-3';
                break;
            case '25%' :
                $col_number = 'col-4';
                break;
        }
        
        $carousel = 'yes' == $settings['pixerex_blog_carousel'] ? true : false; 
        
        $this->add_render_attribute('blog', 'class', [
            'pixerex-blog-wrap',
            'pixerex-blog-' . $settings['pixerex_blog_layout'],
            'pixerex-blog-' . $col_number
            ]
        );

        $this->add_render_attribute('blog', 'data-layout', $settings['pixerex_blog_layout'] );
        
        if ( $carousel ) {
            
            $play   = 'yes' === $settings['pixerex_blog_carousel_play'] ? true : false;
            $fade   = 'yes' === $settings['pixerex_blog_carousel_fade'] ? 'true' : 'false';
            $arrows = 'yes' === $settings['pixerex_blog_carousel_arrows'] ? 'true' : 'false';
            $grid   = 'yes' === $settings['pixerex_blog_grid'] ? 'true' : 'false';
            $center_mode   = 'yes' === $settings['pixerex_blog_carousel_center'] ? 'true' : 'false';
            $spacing   = intval( $settings['pixerex_blog_carousel_spacing'] );
            
            $speed  = ! empty( $settings['pixerex_blog_carousel_autoplay_speed'] ) ? $settings['pixerex_blog_carousel_autoplay_speed'] : 5000;
            $dots   = 'yes' === $settings['pixerex_blog_carousel_dots'] ? 'true' : 'false';

            $columns = intval ( 100 / substr( $settings['pixerex_blog_columns_number'], 0, strpos( $settings['pixerex_blog_columns_number'], '%') ) );
            
            $columns_tablet = intval ( 100 / substr( $settings['pixerex_blog_columns_number_tablet'], 0, strpos( $settings['pixerex_blog_columns_number_tablet'], '%') ) );

            $columns_mobile = intval ( 100 / substr( $settings['pixerex_blog_columns_number_mobile'], 0, strpos( $settings['pixerex_blog_columns_number_mobile'], '%') ) );

            $carousel_settings = [
                'data-carousel' => $carousel,
                'data-grid' => $grid,
                'data-fade' => $fade,
                'data-play' => $play,
                'data-center' => $center_mode,
                'data-slides-spacing' => $spacing,
                'data-speed' => $speed,
                'data-col' => $columns,
                'data-col-tablet' => $columns_tablet,
                'data-col-mobile' => $columns_mobile,
                'data-arrows' => $arrows,
                'data-dots' => $dots
            ];

            $this->add_render_attribute('blog', $carousel_settings );
        
            
        }
        
    ?>
    <div class="pixerex-blog">
        <?php if ( 'yes' === $settings['pixerex_blog_cat_tabs'] && 'yes' !== $settings['pixerex_blog_carousel'] ) : ?>
            <?php $this->get_filter_tabs_markup(); ?>
        <?php endif; ?>
        <div <?php echo $this->get_render_attribute_string('blog'); ?>>

            <?php

            if( count( $posts ) ) {
                global $post;
                foreach( $posts as $post ) {
                    setup_postdata( $post );
                    $this->get_post_layout();
                }
            ?>
        </div>
    </div>
    <?php if ( $settings['pixerex_blog_paging'] === 'yes' ) : ?>
        <div class="pixerex-blog-pagination-container">
            <?php 
            $count_posts = wp_count_posts();
            $published_posts = $count_posts->publish;
            
            $total_posts = ! empty ( $settings['pixerex_blog_total_posts_number'] ) ? $settings['pixerex_blog_total_posts_number'] : $published_posts;
            
            if( $total_posts > $published_posts )
                $total_posts = $published_posts;
            
            $page_tot = ceil( ( $total_posts - $offset ) / $settings['pixerex_blog_number_of_posts'] );
            
            if ( $page_tot > 1 ) {
                $big        = 999999999;
                echo paginate_links( 
                    array(
                        'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $paged,
                        'total'     => $page_tot,
                        'prev_next' => 'yes' === $settings['pagination_strings'] ? true : false,
                        'prev_text' => sprintf( "&lsaquo; %s", $settings['pixerex_blog_prev_text'] ),
                        'next_text' => sprintf( "%s &rsaquo;", $settings['pixerex_blog_next_text'] ),
                        'end_size'  => 1,
                        'mid_size'  => 2,
                        'type'      => 'list'
                    ));
                }
            ?>
        </div>
    <?php endif;
            wp_reset_postdata();
            
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {

                if ( 'masonry' === $settings['pixerex_blog_layout'] && 'yes' !== $settings['pixerex_blog_carousel'] ) {
                    $this->render_editor_script();
                }
            }

        }
    }

    /**
	 * Render Editor Masonry Script.
	 *
	 * @since 3.12.3
	 * @access protected
	 */
	protected function render_editor_script() {

		?><script type="text/javascript">
			jQuery( document ).ready( function( $ ) {

				$( '.pixerex-blog-wrap' ).each( function() {

                    var $node_id 	= '<?php echo $this->get_id(); ?>',
                        scope 		= $( '[data-id="' + $node_id + '"]' ),
                        selector 	= $(this);
                    
					if ( selector.closest( scope ).length < 1 ) {
						return;
					}
					
                    var masonryArgs = {
                        itemSelector	: '.pixerex-blog-post-outer-container',
                        percentPosition : true,
                        layoutMode		: 'masonry',
                    };

                    var $isotopeObj = {};

                    selector.imagesLoaded( function() {

                        $isotopeObj = selector.isotope( masonryArgs );

                        selector.find('.pixerex-blog-post-outer-container').resize( function() {
                            $isotopeObj.isotope( 'layout' );
                        });
                    });

				});
			});
		</script>
		<?php
    }

    /*
     * Get Empty Query Message
     * 
     * Written in PHP and used to generate the final HTML when the query is empty
     * 
     * @since 3.20.3
     * @access protected
     * 
     */
    protected function get_empty_query_message() {
        ?>
        <div class="pixerex-error-notice">
            <?php echo __('The current query has no posts. Please make sure you have published items matching your query.','pixerex-addons-for-elementor'); ?>
        </div>
        <?php
    }
    
}
