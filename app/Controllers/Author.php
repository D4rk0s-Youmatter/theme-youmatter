<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Author extends Controller
{
    protected $acf = true;

    public function __construct()
    {
        add_action('wp_ajax_author_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_author_articles', [$this, 'articlesListAjax']);
    }

    private static function articlesPageStatic()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    private static function articlesListStatic($query_args = [])
    {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true
        );

        $query = new \WP_Query(array_merge($args, $query_args));

        return array(
            'total_pages' => $query->max_num_pages,
            'articles' => array_map(function ($article) {
                return $article;
            }, $query->posts)
        );
    }

    public static function articlesListAjax()
    {
        check_ajax_referer('author_nonce', 'security');

        $paged = self::articlesPageStatic();
        $lang = sanitize_text_field($_POST['lang']);
        $author = sanitize_text_field($_POST['author']);

        $args = array(
            'posts_per_page' => 3,
            'paged' => $paged,
            'lang' => $lang,
            'author' => $author,
            'tax_query' => array(
                'relation' => 'AND'
            )
        );

        $data = self::articlesListStatic($args);
        $articles = $data['articles'];

        if ($articles) {
            $articles_html = array_map(function ($article, $i) use ($paged) {
                $layout = $paged === 1 && $i === 0 ? 'large' : 'classique';
                $article_details = \App::getCardDetails($article, $layout, false);
                return \App\template('partials.card', $article_details);
            }, $articles, array_keys($articles));
            $data['articles'] = $articles_html;
        }

        wp_send_json_success($data);

        wp_die();
    }


    public function author()
    {
        $uID = get_queried_object()->ID;
        $orgID = get_field('organisation', 'user_' . $uID);
        $field_sufix = pll_current_language() === 'en' ? '_' . pll_current_language() : '';
        switch_to_blog(4);
        $avatar = get_field('profile_image', get_queried_object());
        restore_current_blog();
        $author =  array(
            'name' => get_the_author(),
            'link' => get_author_posts_url($uID),
            'description' => get_field('description' . $field_sufix, get_queried_object()),
            'image' => wp_get_attachment_image_url(get_the_author_meta('user_profile_picture')),
            'avatar' => $avatar,
            'fonction' => get_field('fonction' . $field_sufix, get_queried_object()),
            'linkedin' => get_the_author_meta('linkedin', $uID) ? get_the_author_meta('linkedin', $uID) : get_the_author_meta('user_linkedin', $uID),
            'twitter' => get_the_author_meta('twitter', $uID) ? get_the_author_meta('twitter', $uID) : get_the_author_meta('user_twitter', $uID),
            'org' => '',
            'org_link' => '',
        );

        switch_to_blog(4);

        $args = array(
            'post_type' => 'organisations',
            'posts_per_page' => -1,
            'post_status' => 'published'
        );

        $query = new \WP_Query($args);

        if (!empty($query->posts)) {
            foreach ($query->posts as $org) {
                $orgUsers = get_field('users', $org->ID);
                if ($orgUsers) {
                    foreach ($orgUsers as $u) {
                        if ($u['user']['ID'] === $uID) {
                            $author['org'] = $org->post_title;
                            $author['org_link'] = get_permalink($org->ID);
                            break;
                        }
                    }
                }
            }
        }

        restore_current_blog();

        return $author;
    }

    public function authorPosts()
    {
        $user = get_queried_object();

        $args = array(
            'author' => $user->data->ID,
            'posts_per_page' => 3,
            'post_status' => 'publish',
        );

        $query = new \WP_Query($args);
        wp_reset_postdata();
        return $query;
    }
}
