<?php
namespace App\Controllers\Partials;

trait Transitions
{
    public function __construct()
    {
        add_action('wp_ajax_list_transitions', [$this, 'getTransitionsAjax']);
        add_action('wp_ajax_nopriv_list_transitions', [$this, 'getTransitionsAjax']);
    }

    public function currentPage()
    {
        return self::getcurrentPage();
    }

    public static function getFeaturedTransitions($count = 6)
    {
        $args = array(
            'posts_per_page' => $count,
            'meta_key' => 'featured',
            'meta_value' => 1
        );

        return self::getTransitions($args);
    }

    public static function getLatestTransitions($count = 6)
    {
        $args = array(
            'posts_per_page' => $count,
            'tax_query' => array(
                'relation' => 'AND'
            )
        );

        return self::getTransitions($args);
    }

     public static function getRandomTransitions($sector = null, $size = null, $type = null)
     {
        $current_page = self::getcurrentPage();
        $seed = \App::getRandomSession($current_page);

        $args = array(
            'posts_per_page' => get_option('posts_per_page'),
            'orderby' => 'rand(' . $seed . ')',
            'paged' => $current_page
        );

        if($sector) {
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'sector',
                    'field' => 'term_id',
                    'terms' => $sector
                )
            );
        }

        if($size) {
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'org-size',
                    'field' => 'term_id',
                    'terms' => $size
                )
            );
        }

        if($type) {
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'org-type',
                    'field' => 'term_id',
                    'terms' => $type
                )
            );
        }

        return self::getTransitions($args);
    }

    public static function getTax($tax = 'sector')
    {
        $terms = get_terms(array(
            'taxonomy' => $tax,
            'hide_empty' => false,
        ));

        if(!is_wp_error($terms)) {
            return array_map(function($item) {
                return array(
                    'name' => $item->name,
                    'id' => $item->term_id
                );
            }, $terms);
        }

        return null;
    }

    public static function getTransitionsAjax()
    {
        check_ajax_referer('transitions_nonce', 'security');

        $sector = isset($_POST['sector']) ? \App::getParamsList('sector') : null;
        $size = isset($_POST['org-size']) ? \App::getParamsList('org-size') : null;
        $type = isset($_POST['org-type']) ? \App::getParamsList('org-type') : null;

        $data = self::getRandomTransitions($sector, $size, $type);

        $data['items'] = array_map(function($item) {
          return \App\template('partials.card-transition', $item);
        }, $data['items']);

        wp_send_json_success($data);

        wp_die();
    }

    public static function getTransitionDetails($id)
    {
      return array(
        'url' => get_permalink($id),
        'title' => get_the_title($id),
        'image' => self::getImage($id)
      );
    }

    public static function getTotalTransitions()
    {
        global $wpdb;

        $count_posts = $wpdb->get_var(
            "SELECT COUNT(ID)
            FROM {$wpdb->get_blog_prefix(4)}posts
            WHERE post_type = 'organisations'"
        );

        return (int) $count_posts;
    }

    private static function getcurrentPage()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    private static function getImage($id)
    {
        $image = get_the_post_thumbnail($id);

        if(!$image) {
            $image = '<img src="' . \App::options()['card_image'] . '" />';
        }

        return $image;
    }

    private static function getTransitions($query_args)
    {
        switch_to_blog(4);

        $args = array(
            'lang' => isset($_POST['lang']) ?
                    sanitize_text_field($_POST['lang']) :
                    \App::currentLang(),
            'post_type' => 'organisations',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'fields' => 'ids'
        );

        $query = new \WP_Query(array_merge($args, $query_args));

        $items = array(
            'total_pages' => $query->max_num_pages,
            'items' => array_map(function ($id) {
                return self::getTransitionDetails($id);
            }, $query->posts)
        );

        restore_current_blog();

        return $items;
    }

}
