<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Category extends Controller
{
    use Partials\Hero;
    use Partials\Sponsored;

    protected $acf = true;

    private static $articles_per_page = 6;

    public function __construct()
    {
        add_action('wp_ajax_category_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_category_articles', [$this, 'articlesListAjax']);
    }

    public function sponsored_articles()
    {
        return self::sponsoredArticles();
    }

    public static function articlesListAjax()
    {
        check_ajax_referer('category_nonce', 'security');

        $paged = self::articlesPageStatic();
        $subcategory = isset($_POST['subcategory']) ?
            \App::getParamsList('subcategory') :
            self::CategoryId();
        $tag = \App::getParamsList('tag');
        $lang = sanitize_text_field($_POST['lang']);

        $args = array(
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'lang' => $lang,
            'tax_query' => array(
                'relation' => 'AND'
            )
        );

        if ($subcategory) {
            $args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $subcategory
            );
        }

        if ($tag) {
            $args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tag
            );
        }

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

    public static function categoryId()
    {
        if (isset($_POST['category'])) {
            return sanitize_text_field($_POST['category']);
        }

        $cat = get_queried_object();

        if ($cat) {
            return $cat->term_id;
        }

        return null;
    }

    public static function categoryDetails($cat, $renderImg = false)
    {
        $cat_icon = get_field('icon', 'category_' . $cat->term_id);

        return array(
            'id' => $cat->term_id,
            'title' => $cat->name,
            'image' => $renderImg ?
            wp_get_attachment_image($cat_icon, 'full') :
            wp_get_attachment_url($cat_icon),
            'url' => get_category_link($cat->term_id)
        );
    }

    public static function getLatestArticles($articles = null, $count = 4)
    {
        if ($articles) {
            return $articles;
        }

        $args = array(
            'cat' => self::categoryId(),
            'posts_per_page' => $count
        );

        return self::articlesListStatic($args)['articles'];
    }

    public static function getRandomArticles($articles, $count)
    {
        if ($articles) {
            return $articles;
        }

        $args = array(
            'cat' => self::categoryId(),
            'posts_per_page' => $count,
            'orderby' => 'rand',
            'date_query' => array(
                array(
                    'year' => date('Y', strtotime('-1 year')),
                    'compare' => '>='
                )
            )
        );

        return self::articlesListStatic($args)['articles'];
    }

    public static function getRandomArticlesFaq($articles, $count)
    {
        if ($articles) {
            return $articles;
        }

        $args = array(
            'cat' => self::categoryId(),
            'posts_per_page' => $count,
            'orderby' => 'rand',
            'tag_id' => get_field('faqs_tag', 'option')
        );

        return self::articlesListStatic($args)['articles'];
    }

    public function articlesCount()
    {
        global $wp_query;

        return $wp_query->found_posts;
    }

    public function articlesPage()
    {
        return self::articlesPageStatic();
    }

    public function articlesPagesCount()
    {
        return self::articlesPagesCountStatic();
    }

    public static function articlesUrl()
    {
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        return $current_url . '/articles';
    }

    public static function isArticlesPage()
    {
        global $wp_query;

        return get_query_var('articles');
    }

    public function latestArticles()
    {
        return self::getLatestArticles(null, 4);
    }

    public function latestArticlesAction()
    {
        $field_data = get_field('take_action', 'category_' . self::categoryId());
        $initial_items = null;

        if ($field_data) {
            $initial_items = $field_data['articles'];
        }

        return self::getLatestArticles($initial_items, 3);
    }

    public function discoverItems()
    {
        $category_id = self::categoryId();
        $items = get_field('related', 'category_' . $category_id);

        if (!$items) {
            $items = get_categories(array(
                'exclude' => [$category_id],
                'number' => 3,
                'parent' => 0,
                'orderby' => 'count'
            ));
        }

        return array_map(function ($item) {
            return self::categoryDetails($item);
        }, $items);
    }

    public function subcategories()
    {
        $items = get_categories(array(
            'parent' => self::categoryId(),
        ));

        return array_map(function ($item) {
            return array(
                'name' => $item->name,
                'id' => $item->term_id
            );
        }, $items);
    }

    public function tags()
    {
        $items = get_tags();

        return array_map(function ($item) {
            return array(
                'name' => $item->name,
                'id' => $item->term_id
            );
        }, $items);
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
            'articles_label' => sprintf(pll__('%d articles found', 'youmatter'), $query->found_posts),
            'articles' => array_map(function ($article) {
                return $article;
            }, $query->posts)
        );
    }

    private static function articlesPagesCountStatic()
    {
        global $wp_query;

        return $wp_query->max_num_pages;
    }

    private static function articlesPageStatic()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }
}
