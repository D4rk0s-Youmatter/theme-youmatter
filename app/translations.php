<?php

namespace App;

/*
 * All partials strings are handled by plugin: Polylang Theme Strings (Blade support)
 * Only strings added in app folder need to be added here
 */
if (function_exists('pll_register_string')) :

pll_register_string('youmatter', 'Homepage');
pll_register_string('youmatter', 'Go to definitions');
pll_register_string('youmatter', 'All articles');
pll_register_string('youmatter', 'Article');
pll_register_string('youmatter', 'An error occurred.');
pll_register_string('youmatter', 'Your comment was submitted.');
pll_register_string('youmatter', 'Latest Posts');
pll_register_string('youmatter', '%s articles');
pll_register_string('youmatter', 'Search Results for %s');
pll_register_string('youmatter', 'Not Found');
pll_register_string('youmatter', '%d results found');
pll_register_string('youmatter', 'See %s category');
pll_register_string('youmatter', 'Follow this category and receive all the related news in your inbox each week!');
pll_register_string('youmatter', 'Definitions');
pll_register_string('youmatter', 'Look for an article, theme...');
pll_register_string('youmatter', 'Transition program');
pll_register_string('youmatter', '%s ago');

/**
 * Register polylang strings
 */
add_action('admin_init', function() {
    $types = get_taxonomies(array('_builtin' => false));

    if($types) {
        foreach($types as $type) {
            pll_register_string('taxonomies', $type, 'taxonomies');
        }
    }
});

endif;