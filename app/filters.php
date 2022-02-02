<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . pll__('Read more') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory() . '/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory() . '/index.php';
    }

    return $comments_template;
}, 100);

/**
 * Add "…" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip;';
});

/**
 * Trim excerpt
 */
add_filter('excerpt_length', function () {
    return 20;
}, 999);

/**
 * Remove contact form 7 css and js
 */
add_filter('wpcf7_load_css', '__return_false');
add_filter('wpcf7_load_js', '__return_false');

/**
 * Set search results to showposts and pages only
 */
add_filter('pre_get_posts', function ($query) {
    if (is_search() && $query->is_main_query() && $query->get('s')) {
        $query->set('post_type', array('post', 'page'));
    }

    return $query;
});

/**
 * Only query published posts in ACF post_object
 */
add_filter('acf/fields/post_object/query', function ($args, $field, $post_id) {
    $args['post_status'] = 'publish';

    return $args;
}, 10, 3);

/*
* Remove images width attr
*/
add_filter('post_thumbnail_html', function ($html) {
    $html = preg_replace('/(width|height)="\d*"\s/', "", $html);

    return $html;
});

add_filter('wp_get_attachment_image_attributes', function ($attr) {
    unset($attr['width']);

    return $attr;
});