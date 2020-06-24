<?php

namespace PixerexAddons\Compatibility\WPML;

if ( ! defined('ABSPATH') ) exit; // No access of directly access

if ( ! class_exists ('Pixerex_Addons_Wpml') ) {
    
    /**
    * Class Pixerex_Addons_Wpml.
    */
   class Pixerex_Addons_Wpml {

       /*
        * Instance of the class
        * @access private
        * @since 3.1.9
        */
        private static $instance = null;

       /**
        * Constructor
        */
       public function __construct() {
           
           $is_wpml_active = self::is_wpml_active();
           
           // WPML String Translation plugin exist check.
           if ( $is_wpml_active ) {
               
               $this->includes();

               add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'translatable_widgets' ] );
           }
       }
       
       
       /*
        * Is WPML Active
        * 
        * Check if WPML Multilingual CMS and WPML String Translation active
        * 
        * @since 3.1.9
        * @access private
        * 
        * @return boolean is WPML String Translation 
        */
       public static function is_wpml_active() {
           
           include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
           
           $wpml_active = is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );
           
           $string_translation_active = is_plugin_active( 'wpml-string-translation/plugin.php' );
           
           return $wpml_active && $string_translation_active;
           
       }

       /**
        * 
        * Includes
        * 
        * Integrations class for widgets with complex controls.
        *
        * @since 3.1.9
        */
       public function includes() {
    
            include_once( 'widgets/carousel.php' );
            include_once( 'widgets/fancy-text.php' );
            include_once( 'widgets/grid.php' );
            include_once( 'widgets/maps.php' );
            include_once( 'widgets/pricing-table.php' );
            include_once( 'widgets/progress-bar.php' );
            include_once( 'widgets/vertical-scroll.php' );
    
       }

       /**
        * Widgets to translate.
        *
        * @since 3.1.9
        * @param array $widgets Widget array.
        * @return array
        */
       function translatable_widgets( $widgets ) {

           $widgets['pixerex-addon-banner'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-banner' ],
               'fields'     => [
                   [
                       'field'       => 'premium_banner_title',
                       'type'        => __( 'Banner: Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_banner_description',
                       'type'        => __( 'Banner: Description', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ],
                   [
                       'field'       => 'premium_banner_more_text',
                       'type'        => __( 'Banner: Button Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_banner_image_custom_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Banner: URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
                   'premium_banner_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Banner: Button URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
               ]
           ];
           
           $widgets['pixerex-addon-button'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-button' ],
               'fields'     => [
                   [
                       'field'       => 'premium_button_text',
                       'type'        => __( 'Button: Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_button_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Button: URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
               ]
           ];
           
           $widgets['pixerex-countdown-timer'] = [
               'conditions' => [ 'widgetType' => 'pixerex-countdown-timer' ],
               'fields'     => [
                   [
                       'field'       => 'premium_countdown_expiry_text_',
                       'type'        => __( 'Countdown: Expiration Message', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ],
                   [
                       'field'       => 'premium_countdown_day_singular',
                       'type'        => __( 'Countdown: Day Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_day_plural',
                       'type'        => __( 'Countdown: Day Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_week_singular',
                       'type'        => __( 'Countdown: Week Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_week_plural',
                       'type'        => __( 'Countdown: Week Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_month_singular',
                       'type'        => __( 'Countdown: Month Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_month_plural',
                       'type'        => __( 'Countdown: Month Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_year_singular',
                       'type'        => __( 'Countdown: Year Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_year_plural',
                       'type'        => __( 'Countdown: Year Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_hour_singular',
                       'type'        => __( 'Countdown: Hour Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_hour_plural',
                       'type'        => __( 'Countdown: Hour Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_minute_singular',
                       'type'        => __( 'Countdown: Minute Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_minute_plural',
                       'type'        => __( 'Countdown: Minute Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_second_singular',
                       'type'        => __( 'Countdown: Second Singular', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_countdown_second_plural',
                       'type'        => __( 'Countdown: Second Plural', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_countdown_expiry_redirection_' => [
                       'field'       => 'url',
                       'type'        => __( 'Countdown: Direction URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
               ]
           ];
           
           $widgets['pixerex-counter'] = [
               'conditions' => [ 'widgetType' => 'pixerex-counter' ],
               'fields'     => [
                   [
                       'field'       => 'premium_counter_title',
                       'type'        => __( 'Counter: Title Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_counter_t_separator',
                       'type'        => __( 'Counter: Thousands Separator', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_counter_preffix',
                       'type'        => __( 'Counter: Prefix', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_counter_suffix',
                       'type'        => __( 'Counter: Suffix', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_dual_heading_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Advanced Heading: Heading URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ]
               ]
           ];
           
           $widgets['pixerex-addon-dual-header'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-dual-header' ],
               'fields'     => [
                   [
                       'field'       => 'premium_dual_header_first_header_text',
                       'type'        => __( 'Dual Heading: First Heading', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_dual_header_second_header_text',
                       'type'        => __( 'Dual Heading: Second Heading', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_dual_heading_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Advanced Heading: Heading URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ]
               ]
           ];
           
           $widgets['pixerex-carousel-widget'] = [
               'conditions' => [ 'widgetType' => 'pixerex-carousel-widget' ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Carousel',
           ];
           
           $widgets['pixerex-addon-fancy-text'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-fancy-text' ],
               'fields'     => [
                   [
                       'field'       => 'premium_fancy_prefix_text',
                       'type'        => __( 'Fancy Text: Prefix', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_fancy_suffix_text',
                       'type'        => __( 'Fancy Text: Suffix', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_fancy_text_cursor_text',
                       'type'        => __( 'Fancy Text: Cursor Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\FancyText',
           ];
           
           $widgets['pixerex-img-gallery'] = [
               'conditions' => [ 'widgetType' => 'pixerex-img-gallery' ],
               'fields'     => [
                   [
                       'field'       => 'premium_gallery_load_more_text',
                       'type'        => __( 'Grid: Load More Button', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ]
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Grid',
           ];
           
           $widgets['pixerex-addon-image-button'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-image-button' ],
               'fields'     => [
                   [
                       'field'       => 'premium_image_button_text',
                       'type'        => __( 'Button: Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'premium_image_button_link' => [
                       'field'       => 'url',
                       'type'        => __( 'Button: URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
               ]
           ];
           
           $widgets['pixerex-image-scroll'] = [
               'conditions' => [ 'widgetType' => 'pixerex-image-scroll' ],
               'fields'     => [
                   [
                       'field'       => 'link_text',
                       'type'        => __( 'Image Scroll: Link Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'link' => [
                       'field'       => 'url',
                       'type'        => __( 'Image Scroll: URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ]
               ]
           ];
           
           $widgets['pixerex-addon-image-separator'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-image-separator' ],
               'fields'     => [
                   [
                       'field'       => 'premium_image_separator_image_link_text',
                       'type'        => __( 'Image Separator: Link Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   'link' => [
                       'field'       => 'premium_image_separator_image_link',
                       'type'        => __( 'Image Separator: URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ]
               ]
           ];
           
           $widgets['pixerex-addon-maps'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-maps' ],
               'fields'     => [
                   [
                       'field'       => 'premium_maps_center_lat',
                       'type'        => __( 'Maps: Center Latitude', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_maps_center_long',
                       'type'        => __( 'Maps: Center Longitude', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ]
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Maps',
           ];
           
           $widgets['pixerex-addon-modal-box'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-modal-box' ],
               'fields'     => [
                   [
                       'field'       => 'premium_modal_box_title',
                       'type'        => __( 'Modal Box: Header Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_modal_box_content',
                       'type'        => __( 'Modal Box: Content Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'VISUAL',
                   ],
                   [
                       'field'       => 'premium_modal_close_text',
                       'type'        => __( 'Modal Box: Close Button', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_modal_box_button_text',
                       'type'        => __( 'Modal Box: Trigger Button', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_modal_box_selector_text',
                       'type'        => __( 'Modal Box: Trigger Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],  
               ],
           ];
           
           $widgets['pixerex-addon-person'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-person' ],
               'fields'     => [
                   [
                       'field'       => 'premium_person_name',
                       'type'        => __( 'Person: Name', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_person_title',
                       'type'        => __( 'Person: Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_person_content',
                       'type'        => __( 'Person: Description', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ],
               ],
           ];
           
           $widgets['pixerex-addon-pricing-table'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-pricing-table' ],
               'fields'     => [
                   [
                       'field'       => 'premium_pricing_table_title_text',
                       'type'        => __( 'Pricing Table: Title', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_slashed_price_value',
                       'type'        => __( 'Pricing Table: Slashed Price', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_price_currency',
                       'type'        => __( 'Pricing Table: Currency', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_price_value',
                       'type'        => __( 'Pricing Table: Price Value', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_price_separator',
                       'type'        => __( 'Pricing Table: Separator', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_price_duration',
                       'type'        => __( 'Pricing Table: Duration', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_description_text',
                       'type'        => __( 'Pricing Table: Description', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ],
                   [
                       'field'       => 'premium_pricing_table_button_text',
                       'type'        => __( 'Pricing Table: Button Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_pricing_table_button_link',
                       'type'        => __( 'Pricing Table: Button URL', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
                   [
                       'field'       => 'premium_pricing_table_badge_text',
                       'type'        => __( 'Pricing Table: Badge', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Pricing_Table',
           ];
           
           $widgets['pixerex-addon-progressbar'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-progressbar' ],
               'fields'     => [
                   [
                       'field'       => 'premium_progressbar_left_label',
                       'type'        => __( 'Progress Bar: Left Label', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Progress_Bar',
           ];
           
           $widgets['pixerex-addon-testimonials'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-testimonials' ],
               'fields'     => [
                   [
                       'field'       => 'premium_testimonial_person_name',
                       'type'        => __( 'Testimonial: Name', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_testimonial_company_name',
                       'type'        => __( 'Testimonial: Company', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ],
                   [
                       'field'       => 'premium_testimonial_company_link',
                       'type'        => __( 'Testimonial: Company Link', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
                   [
                       'field'       => 'premium_testimonial_content',
                       'type'        => __( 'Testimonial: Content', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ],
               ],
           ];
           
           $widgets['pixerex-addon-title'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-title' ],
               'fields'     => [
                   [
                       'field'       => 'premium_title_text',
                       'type'        => __( 'Title: Text', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ]
               ],
           ];
           
           $widgets['pixerex-addon-video-box'] = [
               'conditions' => [ 'widgetType' => 'pixerex-addon-video-box' ],
               'fields'     => [
                   [
                       'field'       => 'premium_video_box_link',
                       'type'        => __( 'Video Box: Link', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINK',
                   ],
                   [
                       'field'       => 'premium_video_box_description_text',
                       'type'        => __( 'Video Box: Description', 'pixerex-elementor-elements' ),
                       'editor_type' => 'AREA',
                   ]
               ]
           ];
           
           $widgets['pixerex-vscroll'] = [
               'conditions' => [ 'widgetType' => 'pixerex-vscroll' ],
               'fields'     => [
                   [
                       'field'       => 'dots_tooltips',
                       'type'        => __( 'Vertical Scroll: Tooltips', 'pixerex-elementor-elements' ),
                       'editor_type' => 'LINE',
                   ]
               ],
               'integration-class' => 'PixerexAddons\Compatibility\WPML\Widgets\Vertical_Scroll',
           ];

           return $widgets;
       }
       
       /**
         * Creates and returns an instance of the class
         * @since 0.0.1
         * @access public
         * return object
         */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
       
   }
 
}

if( ! function_exists('premium_addons_wpml') ) {
    
    /**
    * Triggers `get_instance` method
    * @since 0.0.1 
   * @access public
    * return object
    */
    function premium_addons_wpml() {
        
     Pixerex_Addons_Wpml::get_instance();
        
    }
    
}
premium_addons_wpml();