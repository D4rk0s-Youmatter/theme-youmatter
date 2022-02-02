<?php

namespace App;

use Partials\GetFilteredCategories;

class NavWalker extends \Walker_Nav_Menu
{
    private $cpt;
    private $archive;
    private static $children;

    public function __construct()
    {
        add_filter('nav_menu_item_id', '__return_null');
        $cpt           = get_post_type();
        $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
        $this->archive = get_post_type_archive_link($cpt);
    }

    public function checkCurrent($classes)
    {
        return preg_match('/(current[-_])|active/', $classes);
    }

    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '<div class="sub-menu">';
        $output .= '<div class="sub-categories">';
        $output .= '<ul>';
    }

    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '</ul>';
        $output .= '</div>';

        $output .= '<div class="menu-articles">';
        if (!empty($this::$children)) {
            foreach ($this::$children as $children) {
                //print_r($children);

                $output .= '<div class="menu-articles__card ' . $children['class'] . '">';
                if ($children['type'] == 'sponsored') {
                    $output .= '<div class="cat_pill">';
                    $output .= '<a href="' . $children['cat_link'] . '" target="_blank">' . $children['cat_name'] . '</a>';
                    $output .= '<div class="sponsored_message">' . get_field("sponsored_message", "option") . '</div>';
                    $output .= '</div>';


/*
    <div href="{{ $post->permalink }}" class="cat_pill">
        <a href="{{ $post->permalink }}">{{ $sponsored_text }}</a>
        <div class="sponsored_message">{!! $sponsored_message !!}</div>
    </div>
*/



                } else {
                    $output .= '<a href="' . $children['cat_link'] . '" class="cat_pill">' . $children['cat_name'] . '</a>';
                }
                if ($children['type'] == 'sponsored') {
                    $output .= '<a target="_blank" href="' . $children['link'] . '" class="menu-articles__link">';
                } else {
                    $output .= '<a href="' . $children['link'] . '" class="menu-articles__link">';
                }
                $output .= '<figure class="menu-articles__image" data-image="' . $children['image'] . '"></figure>';
                $output .= '<h3 class="menu-articles__title">' . $children['title'] . '</h3>';
                if ($children['type'] == 'sponsored') {
                    $output .= '<p class="menu-articles__author">' . '<a target="_blank" href="' . $children['cat_link'] . '">Par ' . $children['author'] . '</a></p>';
                } else {
                    $output .= '<p class="menu-articles__author">' . 'Par ' . $children['author'] . '</p>';
                }
                //$output .= '<p class="menu-articles__readmore">'.pll__('Read more').'</p>';
                $output .= '</a>';
                $output .= '</div>';
            }
        }
        $output .= '</div>';
        $output .= '</div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $item_html = '';
        parent::start_el($item_html, $item, $depth, $args);

        if ($item->object === 'category' && $depth === 0 && $item->object === 'category') {
            $this::$children = array();

            $current_blog_posts_to_get = 3;

            $featured_post_meta = get_post_meta($item->ID, "featured_post", true);
            $featured_post_data = json_decode($featured_post_meta);

            if ($featured_post_meta) {
                $current_blog_posts_to_get = 2;
            } else {
                $current_blog_posts_to_get = 3;
            }
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $current_blog_posts_to_get,
                'cat' => $item->object_id,
                'order' => 'DSC',
                'orderby' => 'date',
            );
            $query = new \WP_Query($args);


            if (!empty($query->posts)) {
                foreach ($query->posts as $article) {
                    $cat = \App::GetFilteredCategories($article->ID)[0];
                    $cat_name = $cat->name;
                    $cat_link = get_category_link($cat->term_id);
                    array_push(
                        $this::$children,
                        array(
                            'title' => $article->post_title,
                            'link' => get_permalink($article->ID),
                            'image' => get_the_post_thumbnail_url($article->ID, 'medium'),
                            'author' => get_the_author_meta('display_name', $article->post_author),
                            'cat_name' => $cat_name,
                            'class' => 'article__regular',
                            'cat_link' => $cat_link,
                            'type' => 'post'
                        )
                    );
                }
            }
            if ($featured_post_meta) {
                array_push(
                    $this::$children,
                    array(
                        'title' => $featured_post_data->title,
                        'link' => $featured_post_data->permalink,
                        'organisation' => $featured_post_data->author,
                        'image' => $featured_post_data->thumbnail_url,
                        'author' => $featured_post_data->author,
                        'cat_name' => pll__('Transition program'),
                        'class' => 'article__sponsored',
                        'cat_link' => $featured_post_data->author_link,
                        'type' => 'sponsored'
                    )
                );
            }
        }


        /*if ($item->object === 'category' && $depth > 0) {
            $category = get_category($item->object_id);
            if ($category->parent === 0) {
                $item_html = str_replace('<a', '<a class="has-icon" style="background-image: url('.wp_get_attachment_url(get_field('icon', 'category_' . $category->term_id)).')"', $item_html);
            }
        }*/

        $item_html = apply_filters('wp_nav_menu_item', $item_html);
        $output .= $item_html;
    }
}

function nav_menu_args($args = '')
{
    if ($args['theme_location'] === 'main_menu') {
        $args['walker'] = new NavWalker();
    }

    return $args;
}
add_filter('wp_nav_menu_args', __NAMESPACE__ . '\\nav_menu_args');
add_filter('nav_menu_item_id', '__return_null');
