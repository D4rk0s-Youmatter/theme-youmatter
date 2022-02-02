<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    use Partials\Breadcrumbs;
    use Partials\Card;
    use Partials\PostCard;
    use Partials\CategoryCard;
    use Partials\Likes;
    use Partials\Newsletter;
    use Partials\Share;
    use Partials\Messages;
    use Utils\GetFilteredCategories;
    use Utils\GetSectors;

    public function __construct()
    {
        add_action('wp_ajax_reset_pass', [$this, 'resetPassAjax']);
        add_action('wp_ajax_nopriv_reset_pass', [$this, 'resetPassAjax']);

        add_action('wp_ajax_register_user', [$this, 'registerUserAjax']);
        add_action('wp_ajax_nopriv_register_user', [$this, 'registerUserAjax']);
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function currentLanguage()
    {
        if (function_exists('pll_current_language')) {
            return pll_current_language();
        }

        return null;
    }

    public static function homeUrl()
    {
        if (function_exists('pll_home_url')) {
            return pll_home_url();
        }

        return site_url();
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return pll__('Latest Posts');
        }

        if (is_category()) {
            $category = single_cat_title('', false);

            if (get_query_var('articles')) {
                return sprintf(pll__('%s articles'), $category);
            }

            return $category;
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(pll__('Search Results for %s'), get_search_query());
        }

        if (is_404()) {
            return pll__('Not Found');
        }

        return get_the_title();
    }

    public static function canInteract()
    {
        if (is_user_logged_in()) {
            return true;
        }

        return false;
    }

    public static function contactForm()
    {
        return get_field('contact_form', 'options');
    }

    public static function get_attachment_image($id, $size, $args = array())
    {
        if (get_post_type() === 'organisations' && isset($args['class']) && $args['class'] === 'hero__img') {
            $image = get_field('association_banniere');
            $size = 'full';
            if ($image) {
                $id = $image;
            }
        }

        if (!self::showAttachmentImage($id, $size)) {
            $args_string = implode(' ', array_map(
                function ($k, $v) {
                    return $k .'="'. htmlspecialchars($v) .'"';
                },
                array_keys($args),
                $args
            ));

            return \App\template('partials.svg.shape');
        }

        return preg_replace(
            '/(height|width)="\d*"\s/',
            '',
            wp_get_attachment_image($id, $size, false, $args)
        );
    }

    public static function showAttachmentImage($id, $size = 'full')
    {
        if ($id) {
            $image = wp_get_attachment_image_src($id, $size);

            if ($size === 'full' && $image[1] < 800) {
                return false;
            }

            return true;
        }

        return false;
    }

    public static function options()
    {
        return $options = array(
            'facebook' => get_field('facebook', 'options'),
            'instagram' => get_field('instagram', 'options'),
            'twitter' => get_field('twitter', 'options'),
            'linkedin' => get_field('linkedin', 'options'),
            'youtube' => get_field('youtube', 'options'),
            'soundcloud' => get_field('soundcloud', 'options'),
            'logo_id' => get_field('logo', 'options'),
            'card_image' => get_field('card_default_image', 'options'),
            'date' => date('Y'),
            'terms_and_conditions_link' => get_field('terms_and_conditions_link', 'options'),
            'privacy_policy' => get_field('privacy_policy', 'options'),
            'definition_page_url' => get_field('definition_page_url', 'options'),
            'newsletter_subscription' => get_field('newsletter_subscription', 'options'),
            'organizations_site_link' => get_field('organizations_site_link', 'options'),
            'services_site_link' => get_field('services_site_link', 'options'),
            'login_main_screen_title_bold' => get_field('login_main_screen_title_bold', 'options'),
            'login_main_screen_title_light' => get_field('login_main_screen_title_light', 'options'),
            'login_text' => get_field('login_text', 'options'),
            'login_with_email_screen_title_bold' => get_field('login_with_email_screen_title_bold', 'options'),
            'login_with_email_screen_title_light' => get_field('login_with_email_screen_title_light', 'options'),
            'login_with_email_intro' => get_field('login_with_email_intro', 'options'),
            'search_screen_title_bold' => get_field('search_screen_title_bold', 'options'),
            'search_screen_title_light' => get_field('search_screen_title_light', 'options'),
            'search_screen_intro' => get_field('search_screen_intro', 'options'),
            'current_month_views' => get_field('current_month_views', 'options'),
            'previous_month_views' => get_field('previous_month_views', 'options'),
            'newsroom_page_url' => get_field('newsroom_page_url', 'options'),
            'excluded_category' => get_field('excluded_category', 'options'),
            'donation_text' => get_field('donation_text', 'options'),
            'show_donations' => get_field('show_donations', 'options'),
            'donation_embed_code' => get_field('donation_embed_code', 'options'),
            'my_account' => get_field('my_account_url', 'options'),
            'message' => get_field('messages', 'options')
        );
    }

    public static function echo_shortcode($shortcode)
    {
        return do_shortcode($shortcode);
    }

    public static function getOrganizationsCount()
    {
        global $wpdb;
        $query = 'SELECT count(ID) FROM wp_4_posts WHERE post_type="organisations"';
        $count = $wpdb->get_var($query);
        return $count;
    }

    public static function getFeaturedCompanies($count)
    {
        $featuredCompanies = get_option('featured_organisations');
        $response = [];

        //TODO define logo size
        if (!empty($featuredCompanies)) {
            switch_to_blog(4);

            foreach ($featuredCompanies as $key=>$value) {
                array_push($response, array(
                    'title' => $value,
                    'link' => get_permalink($key),
                    'thumb' => has_post_thumbnail($key) ? get_the_post_thumbnail_url($key, 'full') : get_template_directory_uri() . '/assets/images/company-card.png',
                    'date' => get_field('association_date_de_creation', $key) ? get_field('association_date_de_creation', $key) : ''
                ));
            }
            restore_current_blog();
        }

        if (empty($featuredCompanies) || count($featuredCompanies) < $count) {
            $lang = get_locale();
            $langPrefix = explode('_', $lang);
            switch_to_blog(4);
            $organisations = get_posts(array(
                'post_type' => 'organisations',
                'lang' => $langPrefix[0],
                'posts_per_page' => is_array($featuredCompanies) ? ($count - count($featuredCompanies)) : $count,
                'order' => 'ASC',
                'orderby' => 'title'
              ));
            foreach ($organisations as $organisation) {
                array_push($response, array(
                    'title' => $organisation->post_title,
                    'link' => get_permalink($organisation->ID),
                    'thumb' => has_post_thumbnail($organisation->ID) ? get_the_post_thumbnail_url($organisation->ID, 'full') : get_template_directory_uri() . '/assets/images/company-card.png',
                    'date' => get_field('association_date_de_creation', $organisation->ID) ? get_field('association_date_de_creation', $organisation->ID) : ''
                ));
            }
            restore_current_blog();
        }
        return $response;
    }

    public static function themeColor()
    {
        return get_field('highlight_color', 'option');
    }

    public static function latestArticlesList()
    {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'order' => 'DESC',
            'orderby' => 'date',
            'posts_per_page' => 3,
        );

        $query = new \WP_Query($args);

        return array(
            'total_pages' => $query->max_num_pages,
            'articles' => array_map(function ($article) {
                return \App::getCardDetails($article, 'classique', false);
            }, $query->posts)
        );
    }

    public static function isProduction()
    {
        if (WP_ENV === 'development' || WP_ENV === 'staging') {
            return false;
        }
        return true;
    }

    public static function menuAlignment()
    {
        if (get_current_blog_id() === 4) {
            return 'start';
        }

        return 'default';
    }

    public static function getRandomSession($page = 1)
    {
        if (!session_id()) {
            session_start();
        }

        if ($page === 1 && isset($_SESSION['seed'])) {
            unset($_SESSION['seed']);
        }

        if (!isset($_SESSION['seed'])) {
            $_SESSION['seed'] = rand();
        }

        return $_SESSION['seed'];
    }

    public static function getLanguageCount()
    {
        $languages = pll_languages_list();
        return count($languages);
    }

    public static function pageviews()
    {
        $current_year = (int) get_option('analytics_pageviews_' . date('Y'));
        $last_year = (int) get_option('analytics_pageviews_' . date('Y', strtotime('-1 year')));

        if ($last_year === 0) {
            $last_year = (int) self::options()['previous_month_views'];
        }

        $difference = ($current_year * 100 / $last_year) - 100;

        return array(
            'current' => number_format($current_year, 0, '.', ' '),
            'previous' => number_format($last_year, 0, '.', ' '),
            'difference' => round($difference),
            'operator' => $current_year > $last_year ? '+' : '',
        );
    }

    public static function currentLang()
    {
        return pll_current_language();
    }

    public static function getParamsList($name)
    {
        $list = array();

        foreach($_POST[$name] as $item) {
            $list[] = sanitize_text_field($item);
        }

        return $list;
    }

    public static function resetPassAjax()
    {
        check_ajax_referer('reset_pass_nonce', 'security');
        global $wpdb, $current_site;

        $email = isset($_POST['email']) ? $_POST['email'] : null;
       
        $errors = new \WP_Error();
     
        $user_login = $user_email;
     
        do_action('retrieve_password', $user_login);
     
        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if ( empty($key) ) {
            $key = wp_generate_password(20, false);
            do_action('retrieve_password_key', $user_login, $key);
            $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
        $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
        $message .= network_site_url() . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
        $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
     
        if ( is_multisite() )
        {
            $blogname = $GLOBALS['current_site']->site_name;
        }
        else{
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        }
     
        $title = sprintf( __('[%s] Password Reset'), $blogname );
        $title = apply_filters('retrieve_password_title', $title);
        $message = apply_filters('retrieve_password_message', $message, $key);
     
        if ( $message && !wp_mail($user_email, $title, $message) )
        {
            wp_send_json_error( pll__('The e-mail with a password reset link could not be sent.', 'youmatter') );
        }
        else
        {
            wp_send_json_success(pll__('The e-mail could not be sent.', 'youmatter'));
        }
        wp_die();
    }

    public static function registerUserAjax()
    {
        check_ajax_referer('register_user_nonce', 'security');

        $reg_errors = new \WP_Error;

        $useremail=$_POST['user_login'];
        $password=$_POST['password'];
        $firstName=$_POST['first_name'];
        $lastName=$_POST['last_name'];
        
        if( empty( $useremail ) || empty($password)){
            $reg_errors->add('field', pll__('Required form field is missing', 'youmatter'));
        }    
        if ( username_exists( $useremail ) ){
            $reg_errors->add('user_name', pll__('The username you entered already exists!', 'youmatter'));
        }
        if ( ! validate_username( $useremail ) ){
            $reg_errors->add( 'username_invalid', pll__('The username you entered is not valid!', 'youmatter' ));
        }
        if ( !is_email( $useremail ) ){
            $reg_errors->add( 'email_invalid', pll__('Email id is not valid!', 'youmatter' ));
        }
        if ( email_exists( $useremail ) ){
            $reg_errors->add( 'email', pll__('Email already exist!', 'youmatter' ));
        }
        if ( 8 > strlen( $password ) ){
            $reg_errors->add( 'password', pll__('Password length must be greater than 9!', 'youmatter' ));
        }
        if ( 3 > strlen( $firstName ) ){
            $reg_errors->add( 'first_name', pll__('First name length must be greater than 3!', 'youmatter' ));
        }
        if ( empty( $firstName ) || ! empty( $firstName ) && trim( $firstName ) == '' ) {
            $reg_errors->add( 'first_name', pll__('You must include a first name!', 'youmatter' ));
        }
        if ( 3 > strlen( $lastName ) ){
            $reg_errors->add( 'last_name', pll__('Last name length must be greater than 3!', 'youmatter' ));
        }
        if ( empty( $lastName ) || ! empty( $lastName ) && trim( $lastName ) == '' ) {
            $reg_errors->add( 'last_name', pll__('You must include a last name.', 'youmatter' ));
        }
  
        if ( 1 > count( $reg_errors->get_error_messages() ) ){
            $useremail = sanitize_email( $useremail );
            $password = esc_attr( $password );
            $userFirstName = esc_attr( wp_unslash($firstName));
            $userLastName = esc_attr( wp_unslash($lastName));

            $userdata = array(
                'user_login'    =>   $useremail,
                'user_email'    =>   $useremail,
                'user_pass'     =>   $password,
                'first_name'    =>   $userFirstName,
                'last_name'     =>   $userLastName,
            );

            $user_id = wp_insert_user( $userdata );

            wp_send_json_success(pll__('You were registered sucessfully!', 'youmatter'));

            wp_die();
        } else {
            wp_send_json_error($reg_errors);
            wp_die();
        }

        
        
    }
}