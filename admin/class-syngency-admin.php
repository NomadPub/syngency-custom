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
        $this->options = get_option( 'syngency_options' );
        $this->defaults = [];

        
        // Add top-level menu page
        add_action( 'admin_menu', function() {
            add_menu_page(
                'Syngency', // page_title
                'Syngency', // menu_title
                'manage_options', // capability
                'syngency', // menu_slug
                array( $this, 'create_admin_page' ), // function
                'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="126.413" height="134.54" viewBox="0 0 126.413 134.54"><defs><filter id="Path_2775" x="0" y="0" width="126.413" height="134.54" filterUnits="userSpaceOnUse"><feOffset dy="3" input="SourceAlpha"/><feGaussianBlur stdDeviation="3" result="blur"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="blur"/><feComposite in="SourceGraphic"/></filter></defs><g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#Path_2775)"><path id="Path_2775-2" data-name="Path 2775" d="M108.413,31.282,54.13,0,3.68,29.135V60.417L23.308,71.764,0,85.258,54.13,116.54,104.579,87.4V56.123L84.951,44.776ZM57.963,10.734,93.538,31.282l-15.948,9.2L57.963,29.135ZM54.9,35.882,70.23,44.776l-15.948,9.2L38.949,45.082Zm-43.7-2.453L50.449,10.734V29.9L11.194,52.6Zm4.294,25.3,15.948-9.2,15.334,8.894-15.948,9.2Zm34.962,47.076L14.874,85.258l15.948-9.2L50.449,87.4ZM38.182,71.764l15.948-9.2,15.948,9.2-15.948,9.2ZM97.219,83.111,57.963,105.806V87.4L97.219,64.71ZM93.538,58.27l-15.948,9.2-15.948-9.2,15.948-9.2Z" transform="translate(9 6)" fill="#006899"/></g></svg>') // icon_url
                // position
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="140.182" height="40" viewBox="0 0 140.182 40">
                        <g id="Group_8951" data-name="Group 8951" transform="translate(-29 -16)">
                            <g id="sygency" transform="translate(73.972 28.392)">
                            <path id="Path_2663" data-name="Path 2663" d="M90.858,196.374h2.947l-3.842,9v4.421H87.279v-4.368l-3.842-9.053h2.947l2.263,5.789Zm12.526,5.579.105,3-4.474-8.632H96.174v13.421H98.7v-5.579l-.105-3,4.474,8.632h2.842V196.374h-2.526Zm18.947,7.789h8.158v-2.316h-5.474v-3.421h4.579v-2.316h-4.579v-3.105h5.474v-2.316h-8.158Zm18.368-7.789.105,3-4.474-8.632H133.49v13.421h2.526v-5.579l-.105-3,4.474,8.632h2.842V196.374H140.7Zm24.316-5.579-2.263,5.789-2.263-5.789h-2.947l3.842,9.053v4.368h2.684v-4.421l3.842-9Zm-51,2.053h.158c.789,0,1.789.211,2,2.105v.105h2.684v-.105c-.105-3.053-1.579-4.421-4.842-4.421-3.526,0-5.105,2.053-5.105,6.579v.684c0,4.632,1.579,6.579,5.316,6.579a6.525,6.525,0,0,0,4.632-1.526l.053-.053v-5.789h-4.474V204.9h1.789v2.263h-.053a3.1,3.1,0,0,1-1.895.526h-.158c-1.526,0-2.474-.737-2.474-4.263v-.684C111.647,200.111,112.016,198.426,114.016,198.426Zm39.158,6.947c-.053,1.526-.684,2.316-1.947,2.316h-.158c-1.684,0-2.316-1.211-2.316-4.263v-.684c0-3.105.632-4.263,2.316-4.263h.158c.737,0,1.737.211,1.895,2.105v.105h2.684v-.105c-.105-3.053-1.579-4.421-4.79-4.421-3.526,0-5,1.947-5,6.579v.684c0,4.632,1.526,6.579,5,6.579,3.316,0,4.79-1.421,4.79-4.579v-.105h-2.684ZM80.226,196.9a3.8,3.8,0,0,0-1.368-.737,4.631,4.631,0,0,0-1.737-.263,5.6,5.6,0,0,0-1.947.316,3.554,3.554,0,0,0-1.368.842,4.085,4.085,0,0,0-.842,1.263,3.736,3.736,0,0,0-.263,1.526,4.376,4.376,0,0,0,.579,2.263,3.921,3.921,0,0,0,2.263,1.421l1.789.579c.316.105.579.211.737.263a2.914,2.914,0,0,1,.421.316,1.221,1.221,0,0,1,.211.526,7.184,7.184,0,0,1,0,1.737,1.483,1.483,0,0,1-.211.579,1.146,1.146,0,0,1-.474.368,2.2,2.2,0,0,1-.947.158,1.649,1.649,0,0,1-1.263-.421,1.233,1.233,0,0,1-.368-.895v-.737H72.7v.842a2.55,2.55,0,0,0,.368,1.368,3.134,3.134,0,0,0,.947,1.105,4.828,4.828,0,0,0,1.368.737,6.009,6.009,0,0,0,1.737.263,6.328,6.328,0,0,0,2.105-.316,3.3,3.3,0,0,0,2.105-2.21,5.682,5.682,0,0,0,.211-1.684,10.351,10.351,0,0,0-.105-1.368,2.553,2.553,0,0,0-.421-1.105,3.2,3.2,0,0,0-.842-.842,11.406,11.406,0,0,0-1.368-.632l-1.895-.632a3.393,3.393,0,0,1-.737-.316,1.143,1.143,0,0,1-.368-.316.6.6,0,0,1-.158-.421c0-.158-.053-.421-.053-.684a2.562,2.562,0,0,1,.053-.632,1,1,0,0,1,.263-.526,1.146,1.146,0,0,1,.474-.368,1.757,1.757,0,0,1,.789-.158,1.486,1.486,0,0,1,1.263.474,1.652,1.652,0,0,1,.368,1.105v.579h2.737v-1.105a2.6,2.6,0,0,0-.316-1.211A4.749,4.749,0,0,0,80.226,196.9Z" transform="translate(-72.7 -195.9)" fill="#fff"/>
                            </g>
                            <g id="sygency-2" data-name="sygency" transform="translate(29 16)">
                            <path id="Path_2662" data-name="Path 2662" d="M22.251,182.237,4.6,171.5l-16.4,10v10.737l6.382,3.895L-13,200.763,4.6,211.5l16.4-10V190.763l-6.382-3.895Zm-16.4-7.053,11.567,7.053-5.185,3.158L5.847,181.5Zm-1,8.632,4.986,3.053L4.65,190.026l-4.986-3.053Zm-14.21-.842L3.4,175.184v6.579l-12.764,7.79Zm1.4,8.684,5.185-3.158,4.986,3.053-5.185,3.158ZM3.4,207.816l-11.567-7.053,5.185-3.158L3.4,201.5v6.316ZM-.585,196.132,4.6,192.974l5.185,3.158L4.6,199.29Zm19.2,3.895-12.764,7.79V201.5l12.764-7.789Zm-1.2-8.526-5.185,3.158L7.044,191.5l5.185-3.158Z" transform="translate(13 -171.5)" fill="#4ea6e6"/>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="syngency-section-header settings-header">
                    <h2><span>Syngency Settings</span></h2>
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

        $request_url = 'http://' . $this->options['domain'] . '/divisions.json';
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
        $request_url = 'http://' . $this->options['domain'] . '/divisions.json';
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
                flush_rewrite_rules();
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