<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and admin hooks
 *
 * @package    Syngency
 * @subpackage Syngency/admin
 * @author     Ryan Marshall <ryan@syngency.com>
 */

class Syngency_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */

     
    
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $measurements;
    private $image_sizes;
    private $page_status;

    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        // Fix Issue 3: Read options individually with defaults to avoid PHP 8 array offset on bool warnings
        $this->options = get_option( 'syngency_options', [] );
        $this->defaults = [];

        
        // Add top-level menu page with custom Posewell Models branding
        add_action( 'admin_menu', function() {
            add_menu_page(
                'Syngency (Posewell Models)', // page_title
                'Syngency PM', // menu_title - shorter for admin menu
                'manage_options', // capability
                'syngency', // menu_slug
                array( $this, 'create_admin_page' ), // function
                'dashicons-camera' // icon_url - camera icon for Posewell Models
            );
        });
        
        
        
        //add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

        // Measurement options
        $this->measurements = [
            'height' => __( 'Height', 'syngency' ),
            'chest' => __( 'Chest', 'syngency' ),
            'bust' => __( 'Bust', 'syngency' ),
            'waist' => __( 'Waist', 'syngency' ),
            'hip' => __( 'Hip', 'syngency' ),
            'outseam' => __( 'Outseam', 'syngency' ),
            'inseam' => __( 'Inseam', 'syngency' ),
            'sleeve' => __( 'Sleeve', 'syngency' ),
            'collar' => __( 'Collar', 'syngency' ),
            'shoe' => __( 'Shoe', 'syngency' ),
            'suit' => __( 'Suit', 'syngency' ),
            'dress' => __( 'Dress', 'syngency' ),
            'apparel' => __( 'Apparel', 'syngency' ),
            'bra' => __( 'Bra', 'syngency' ),
            'head' => __( 'Head', 'syngency' ),
            'weight' => __( 'Weight', 'syngency' ),
            'trouser' => __( 'Trouser', 'syngency' ),
            'shirt' => __( 'Shirt', 'syngency' ),
            'ring' => __( 'Ring', 'syngency' ),
            'glove' => __( 'Glove', 'syngency' ),
            'kids_clothing' => __( 'Kids Clothing', 'syngency' ),
            'kids_height' => __( 'Kids Clothing', 'syngency' ),
            'appearence_age' => __( 'Appearence Age', 'syngency' ),
            'hair_color' => __( 'Hair Color', 'syngency' ),
            'hair_length' => __( 'Hair Length', 'syngency' ),
            'hair_type' => __( 'Hair Type', 'syngency' ),
            'eye_color' => __( 'Eye Color', 'syngency' ),
            'complexion' => __( 'Complexion', 'syngency' ),
            'features' => __( 'Features', 'syngency' ),
            'plus_size' => __( 'Plus Size', 'syngency' ),
            'pregnant' => __( 'Pregnant', 'syngency' ),
        ];

        // Image Sizes
        $this->image_sizes = [
            'small' => 'Small',
            'medium' => 'Medium',
            'large' => 'Large'
        ];
        $this->page_status = [
            'draft' => 'Draft',
            'publish' => 'Publish',
        ];

        // Load default templates
        $templates = ['division','model'];
        foreach ( $templates as $template ) {
            $template_path = plugin_dir_path( __FILE__ ) . 'templates/' . $template . '-default.liquid';
            if ( file_exists($template_path) ) {
                $this->defaults[$template . '_template'] = file_get_contents($template_path);
            }
        }
    }

    /**
     * Add options page
     */
    public function add_settings_page()
    {
        add_options_page(
            'Syngency Admin', 
            'Syngency', 
            'manage_options', 
            'syngency-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        ?>
        <form class="syngency" method="post" action="options.php">
            <!-- Notification Caption -->
            <div class="notification-caption">
                <div class="notification-icon">
                    <span class="icon icon-clipboard"></span>
                </div>
                <div class="notification-message">
                    <p class="caption-title">Copied to Clipboard</p>
                    <p class="caption-message">[syngency division="models-main"]</p>
                </div>
            </div>
            <!-- End Caption -->
        <div class="wrap">
            <div class="syngency-header">
                <div class="syngency-main-header">
                    <h1 style="color: #fff; font-size: 24px; margin: 0;">📸 Posewell Models Syngency</h1>
                </div>
                <div class="syngency-section-header settings-header">
                    <h2><span>Plugin Settings</span></h2>
                    <div class="syngency-save-btn"><?php submit_button(); ?></div>
                </div>
            </div>  
                <div class="syngency-form-wrapper">
                    <?php
                        settings_fields( 'syngency_option_group' );
                    ?>
                    <div class="syngency-section-wrapper api-settings">
                        <?php
                            do_settings_sections( 'syngency-api-settings' ); 
                        ?>
                    </div>
                    <div class="syngency-section-wrapper division-settings">
                        <?php
                            do_settings_sections( 'syngency-wp-settings' ); 
                        ?>
                    </div>
                    <div class="syngency-section-wrapper template-settings">
                        <?php
                            do_settings_sections( 'syngency-templates-settings' );
                        ?>  
                    </div>
                    <div class="syngency-section-wrapper registered-settings">
                        <?php
                            do_settings_sections( 'syngency-registered-settings' );
                        ?>  
                    </div>
                </div>
            </div>
        </form>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {       
        // API SETTINGS
        register_setting(
            'syngency_option_group',
            'syngency_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'api_settings',
            'API Settings',
            array( $this, 'api_settings_info' ),
            'syngency-api-settings'
        );

        // WORDPRESS SETTINGS
        add_settings_section(
            'wordpress_settings',
            'Manage Division & Model Page Settings',
            array( $this, 'divisions_shortcodes' ),
            'syngency-wp-settings' 
        );


        // TEMPLATE
        add_settings_section(
            'wordpress_templates',
            'Customize Templates',
            array( $this, 'syngency_templates_callback' ),
            'syngency-templates-settings'
        );

       

        // DIVISIONS
        add_settings_section(
            'divisions',
            'Registered WordPress Division Pages ',
            array( $this, 'divisions_list' ),
            'syngency-registered-settings'
        );
        
        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if ( is_string($input) )
        {
            foreach ( $input as $key => $value )
            {
                $new_input[$key] = sanitize_text_field($value);
            }            
        }
        else
        {
            $new_input = $input;
        }
        return $new_input;
    }

    /** 
     * Print the API Settings text
     */
    public function api_settings_info()
    {
        $output = '<p class="syngency-section-note">Enter the following information from your Syngency Settings below.</p>';
        $output .= '<div class="syngency-group-wrapper">';
        echo $output;
        printf(
            '<div class="syngency-input-group"><label for="domain">Domain</label><div class="input-wrapper icon-input icon-domain"><input type="text" id="domain" class="regular-text" placeholder="eg: yourdomain.syngency.com" name="syngency_options[domain]" value="%s" /></div></div>',
            isset( $this->options['domain'] ) ? esc_attr( $this->options['domain']) : ''
        );
        printf(
            '<div class="syngency-input-group"><label for="api_key">API Key</label><div class="input-wrapper icon-input icon-lock"><input type="text" id="api_key" class="regular-text" name="syngency_options[api_key]" value="%s" /></div></div>',
            isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
        );
        echo '</div>';
    }


   
    public function create_page_status_selectbox($division_id)
    {
        echo '<select name="syngency_options[page_status_'. $division_id .']">';
        foreach ( $this->page_status as $value => $label )
        {
            echo '<option value="' . $value . '"';
            if ( isset($this->options['page_status']) && $value == $this->options['page_status'] )
            {
                echo ' selected="selected"';
            }
            echo '>' . $label . '</option>';
        }
        echo '</select>';
    }

    /** 
     * Print the Templates text
     */

    public function syngency_templates_callback()
    {
        $output = '<h3 class="icon-folder num1">Divisions</h3>';
        $output .= '<p class="syngency-section-note">This template dictates how the Division pages are displayed on your site.</p>';
        $output .= '<div class="syngency-wrapper">';
        echo $output;
        $val = (!isset($this->options['division_template']) || empty($this->options['division_template'])) ? $this->defaults['division_template'] : $this->options['division_template'];
        echo '<textarea class="syngency-text-editor" name="syngency_options[division_template]" id="syngency-division-template">' . esc_textarea($val) . '</textarea></div>';

        $output = '<h3 class="icon-page num2">Models</h3>';
        $output .= '<p class="syngency-section-note">This template dictates how the Models pages are displayed on your site.</p>';
        $output .= '<div class="syngency-wrapper">';
        echo $output;
        $val = (!isset($this->options['model_template']) || empty($this->options['model_template'])) ? $this->defaults['model_template'] : $this->options['model_template'];
        echo '<textarea name="syngency_options[model_template]" id="syngency-model-template">' . esc_textarea($val) . '</textarea></div>';
    }


    /**
     * Divisions
     */

    public function get_shortcode_attributes($shortcode_html)
    {
        $attributes = [];
        preg_match_all('/(\w+)\s*=\s*"(.*?)"/i', $shortcode_html, $matches);
        for ($i = 0; $i < count($matches[1]); $i++) {
            $attributes[$matches[1][$i]] = $matches[2][$i];
        }
        return $attributes;
    }

    public function divisions_list()
    {
        global $wpdb;
        $query = "SELECT ID, post_title, post_content, post_name, post_status FROM " . $wpdb->posts . " WHERE post_content LIKE '%[syngency%' AND post_status = 'publish' AND post_type = 'page'";
        $pages = $wpdb->get_results($query);

        $request_url = 'https://' . $this->options['domain'] . '/divisions.json';
        $request_args = array(
          'headers' => array(
            'Authorization' => 'API-Key ' . $this->options['api_key']
          ),
          'timeout' => 30
        );
        $response = wp_remote_get( $request_url, $request_args );
        if ( is_wp_error( $response ) ) {
            $output = '<div class="syngency-wrapper">
                    <div class="syngency-error-message">
                        <div>
                            <img src="' . plugin_dir_url( __FILE__ ) . 'images/disconnected-syn-api.svg" alt="Syngency Diconnected Syngency API" />
                        </div>
                        <div class="syngency-message">
                            <p><span>*Oops!</span></p>
                            <p>' . $response->get_error_message() . '</p>
                        </div>
                    </div>
            </div>';
            echo $output;
            //echo '<pre>Wordpress Error: ' . $response->get_error_message() . '</pre>';
        } else {
            if ( wp_remote_retrieve_response_code($response) == 200 ) {
                if($pages){
                    $output = '<p class="syngency-section-note">These pages are registered as Syngency divisions:</p>';
                    $output .= '<div class="syngency-wrapper">';
                    
                    foreach ( $pages as $page ) {
                        $this->console_log($page);
                        $post_permalink = get_permalink( $page->ID );
                        $output .= '<div class="syngency-wordpress-pages">';
                        if($page->post_status == 'publish'){
                            $output .= '<h4><span>' . $page->post_title . ' - (Published)</span></h4>';
                        }else{
                            $output .= '<h4><span>' . $page->post_title . ' - (Draft)</span></h4>';
                        }
                        $output .= '<div class="wp-page-actions">';
                        $output .= '<a href="post.php?post=' . $page->ID . '&action=edit" class="btn syngency-edit-button" target="_blank"></a>';
                        $output .= '<a href="' . $post_permalink. '" class="btn syngency-preview-button" target="_blank"></a>';
                        $output .= '</div></div>'; 
                    }
                    $output .= '</div>';
                    echo $output;
                }else{
                   echo $output = '<p class="syngency-section-note">There are no division pages saved. Select from the divisions above and save changes.</p>';
                }
            } else {
                $output = '<div class="syngency-wrapper">
                    <div class="syngency-error-message">
                        <div>
                            <img src="' . plugin_dir_url( __FILE__ ) . 'images/disconnected-syn-api.svg" alt="Syngency Diconnected Syngency API" />
                        </div>
                        <div class="syngency-message">
                            <p><span>*Oops!</p>
                            <p>Could not fetch URL: ' . $request_url . '</p>
                        </div>
                    </div>
                </div>';
                echo $output;
            }
        }
        
        
    }
    
    public function divisions_shortcodes()
    {
        echo '<h3 class="icon-divisions num1">Divisions</h3>';
        $request_url = 'https://' . $this->options['domain'] . '/divisions.json';
        $request_args = array(
          'headers' => array(
            'Authorization' => 'API-Key ' . $this->options['api_key']
          ),
          'timeout' => 30
        );
        $response = wp_remote_get( $request_url, $request_args );
        if ( is_wp_error( $response ) ) {
            $output = '<div class="syngency-wrapper">
                    <div class="syngency-error-message">
                        <div>
                            <img src="' . plugin_dir_url( __FILE__ ) . 'images/disconnected-syn-api.svg" alt="Syngency Diconnected Syngency API" />
                        </div>
                        <div class="syngency-message">
                            <p><span>*Oops!</span> - ' . $response->get_error_message() . '</p>
                        </div>
                    </div>
            </div>';
            echo $output;
        } else {
            if ( wp_remote_retrieve_response_code($response) == 200 ) {
                $body = wp_remote_retrieve_body($response); 
                $divisions = json_decode($body);
                $output = '<p class="syngency-section-note">Create division pages by selecting the options below or copy the shortcode and paste it directly into your post/page:</p>
                    <table class="syngency-table">
                        <thead>
                            <tr>
                                <th>Division</th>
                                <th>Page Status</th>
                                <th>Shortcode</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan=3>&nbsp;</td>
                        </tr>
                        ';

                // Register endpoint
                if($divisions){
                    foreach ( $divisions as $division ) {
                        $division_name = $division->name;
                        $new_division_name = str_replace(' ', '', strtolower($division_name));
                        $division_id = str_replace('-', '_', strtolower($new_division_name));
                        $shortcode = str_replace('_', '-', strtolower($division_id));
                        $shortcode_attributes = '[syngency division="' . $shortcode .'"]';
                        $page_status = $this->options['page_status_'.$division_id];
                        $page = get_page_by_title( $division_name, OBJECT, 'page' );
                        
                        $output .= '<tr>';
                        
                        if(isset( $this->options[$division_id] )){
                            $this->create_division_pages($division_name,$shortcode_attributes,$page_status,$shortcode);
                            if($page){
                                if ( $page_status == 'publish' ) {
                                    wp_update_post(array(
                                        'ID'    =>  $page->ID,
                                        'post_status'   =>  'publish'
                                    ));
                                } else {
                                    wp_update_post(array(
                                        'ID'    =>  $page->ID,
                                        'post_status'   =>  'draft'
                                    ));
                                }
                            };
                            $output .= '<td><label class="checkbox-container" for="'. $division_id .'">'. $division_name .'<input type="checkbox" id="'. $division_id .'" name="syngency_options['. $division_id .']" checked /><span class="checkmark"></span></label></td>';
                        }else{
                            $output .= '<td><label class="checkbox-container" for="'. $division_id .'">'. $division_name .'<input type="checkbox" id="'. $division_id .'" name="syngency_options['. $division_id .']" /><span class="checkmark"></span></label></td>';
                        }
                        $output .= '<td><select class="syngency-division-selectbox" name="syngency_options[page_status_'. $division_id .']">';
                        if($page_status == 'publish'){
                            $output .= '<option value="draft">Draft</option><option value="publish" selected>Publish</option>';
                        }else{
                            $output .= '<option value="draft" selected>Draft</option><option value="publish">Publish</option>';
                        };
                        
                        $output .= '</select></td>';
                        $output .= '<td><div class="syngency-copy-clipboard">';
                        $output .= '<button type="button" class="syngency-copy-button" ><span class="icon-copy">'. $shortcode_attributes .'</span></button>';
                        $output .= '</div></tr>';
                    }
                }            
                $output .= '</tbody></table>';
                // Note: flush_rewrite_rules() removed - rules are now registered on init hook
                echo $output;
            } else {
                $output = '<div class="syngency-wrapper">
                    <div class="syngency-error-message">
                        <div>
                            <img src="' . plugin_dir_url( __FILE__ ) . 'images/disconnected-syn-api.svg" alt="Syngency Diconnected Syngency API" />
                        </div>
                        <div class="syngency-message">
                            <p><span>*Oops!</p>
                            <p>Could not fetch URL: ' . $request_url . '</p>
                        </div>
                    </div>
                </div>';
                echo $output;
            }
        }

        // Measurements //

        $output = '<h3 class="icon-measurement num2">Appearance Information</h3>';
        $output .= '<p class="syngency-section-note">Select which measurements you do not want to show on your website:</p>';
        $output .= '<div class="syngency-wrapper grid col-3">';
        foreach ( $this->measurements as $measurement )
        {
            
            if ( isset($this->options['measurements']) && in_array($measurement, $this->options['measurements']) )
            {
                $output .= '<div><label class="checkbox-container" for="'. $measurement .'">'. $measurement .'<input type="checkbox" id="'. $measurement .'" name="syngency_options[measurements]['. $measurement .']" checked /><span class="checkmark"></span></label></div>';
            }else{
                $output .= '<div><label class="checkbox-container" for="'. $measurement .'">'. $measurement .'<input type="checkbox" id="'. $measurement .'" name="syngency_options[measurements]['. $measurement .']" /><span class="checkmark"></span></label></div>';
            }
            
        }
        $output .=  '</div>';
        echo $output;

        // Gallery Sizes //
        $output = '<h3 class="icon-images num2">Gallery Image Sizes</h3>';
        $output .= '<p class="syngency-section-note">Select what size images you would like to display on your website:</p>';
        $output .= '<div class="syngency-wrapper">';
        $output .= '<div class="selection-group">';
        $output .= '<label>Gallery</label>';
        $output .= '<select class="syngency-division-selectbox" name="syngency_options[image_size]">';
        echo $output;
        foreach ( $this->image_sizes as $value => $label )
        {
            echo '<option value="' . $value . '"';
            if ( isset($this->options['link_size']) && $value == $this->options['image_size'] )
            {
                echo ' selected="selected"';
            }
            echo '>' . $label . '</option>';
        }
        echo '</select></div>';

        // Link Sizes //
        $output = '<div class="selection-group">';
        $output .= '<label>Link</label>';
        $output .= '<select class="syngency-division-selectbox" name="syngency_options[link_size]">';
        $output .= '<option value="">None</option>';
        echo $output;
        foreach ( $this->image_sizes as $value => $label )
        {
            echo '<option value="' . $value . '"';
            if ( isset($this->options['link_size']) && $value == $this->options['link_size'] )
            {
                echo ' selected="selected"';
            }
            echo '>' . $label . '</option>';
        }
        echo '</select></div></div>';

        
        
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style('wp-codemirror');
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/settings-page-admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/html'));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);
        wp_enqueue_script('wp-theme-plugin-editor');
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/syngency.js', array( 'jquery' ), $this->version, false );
    }

    // CONSOLE LOG //

    public function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    // CREATE DIVISION PAGES //
    public function create_division_pages($title,$shortcode,$status,$slug){
        $new_page = array(
            'post_type'     => 'page',
            'post_title'    => $title,
            'post_content'  => $shortcode,
            'post_status'   => $status,
            'post_author'   => 1,
            'post_name'     => $slug
        );

        if (!get_page_by_path( $slug, OBJECT, 'page')) { // Check If Page Not Exits
            $new_page_id = wp_insert_post($new_page);
        }
    }
    
    
}