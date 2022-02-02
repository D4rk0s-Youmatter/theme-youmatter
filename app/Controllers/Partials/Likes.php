<?php
namespace App\Controllers\Partials;

trait Likes
{
    private static $types = array(
        'post' => 'post',
        'category' => 'cat',
        'comment' => 'comment',
        'option' => 'option'
    );

    public function __construct()
    {
        add_action('wp_ajax_add_like', [$this, 'addLike']);
        add_action('wp_ajax_nopriv_add_like', [$this, 'addLike']);
        add_action('wp_ajax_liked_articles', [$this, 'likedArticlesListAjax']);
        add_action('wp_ajax_nopriv_liked_articles', [$this, 'likedArticlesListAjax']);
    }

    public static function addLike()
    {
        check_ajax_referer('likes_nonce', 'security');

        $id = $_POST['id'];
        $type = sanitize_text_field($_POST['type']);

        if (!intval($id) && $type !== self::$types['option']) {
            wp_send_json_error('You sneaky bastard.', 400);
            wp_die();
        }

        $likes = (int) self::getLikes($id, $type);
        $new_likes = $likes + 1;

        $update = self::updateLikes($id, $type, strval($likes + 1));

        if ($update) {
            wp_send_json_success($new_likes);
        } else {
            wp_send_json_error(pll__('An error occurred.'), 500);
        }

        wp_die();
    }

    public static function updateLikes($id = null, $type = null, $likes)
    {

        if ($type === self::$types['comment']) {
            return update_comment_meta($id, 'likes', $likes);
        }

        if ($type === self::$types['category']) {
            return update_term_meta($id, 'likes', $likes);
        }

        if($type === self::$types['option']) {
            return update_option('likes', $likes);
        }

        return update_post_meta($id, 'likes', $likes);
    }

    public static function getLikes($id = null, $type = null)
    {
        $default = 0;

        if (!$id) {
            $details = self::likesDetails();
            $id = $details['id'];
            $type = $details['type'];
        }

        $likes = get_post_meta($id, 'likes', true);

        if ($type === self::$types['comment']) {
            $likes = get_comment_meta($id, 'likes', true);
        }

        if ($type === self::$types['category']) {
            $likes = get_term_meta($id, 'likes', true);
        }

        if ($type === self::$types['option']) {
            $likes = get_option('likes', $default);
        }

        return $likes ? $likes : $default;
    }

    public static function likedArticlesListAjax()
    {
        check_ajax_referer('liked_articles_nonce', 'security');

        $cat = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : null;
        $data = self::likedArticlesList();

        if ($data) {
            $articles_html = array_map(function ($article) {
                return \App\template('partials.card', $article);
            }, $data['articles']);
            $data['articles'] = $articles_html;

            wp_send_json_success($data);
        } else {
            wp_send_json_error(pll__('An error occurred.'), 500);
        }

        wp_die();
    }

    public static function likedArticlesList($cat = null)
    {
        if(!$cat) {
            $cat = \Category::categoryId();
        }

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'order' => 'DESC',
            'orderby' => array( 'meta_value_num' => 'DESC', 'date' => 'DESC'),
            'meta_key' => 'likes',
            'posts_per_page' => 6,
            'paged' => self::likedArticlesPage()

        );

        if ($cat) {
            $args['cat'] = $cat;
        }

        $query = new \WP_Query($args);

        return array(
            'total_pages' => $query->max_num_pages,
            'articles' => array_map(function ($article) {
                return \App::getCardDetails($article, 'classique', false);
            }, $query->posts)
        );
    }

    public static function likedArticlesPage()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    public static function likesDetails()
    {
        if (is_single()) {
            return array(
                'id' => get_the_ID(),
                'type' => self::$types['post']
            );
        }

        if (is_category()) {
            return array(
                'id' => \Category::categoryId(),
                'type' => self::$types['category']
            );
        }

        return array(
            'id' => null,
            'type' => self::$types['option']
        );
    }
}
