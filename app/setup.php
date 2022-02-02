<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/montserrat', "//fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,900&display=swap", '', '1.0');
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), [], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_localize_script(
            'sage/main.js',
            'comments_list',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('comments_nonce'),
            )
        );
        wp_localize_script(
            'sage/main.js',
            'comments_reply',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('reply_nonce'),
            )
        );
    }

    if (is_author()) {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('author_nonce'),
        );
        wp_localize_script('sage/main.js', 'author_articles', $ajax_params);
    }

    if (is_single() || get_post_type() === 'organisations') {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('organisations_nonce'),
        );
        wp_localize_script('sage/main.js', 'organisations_articles', $ajax_params);
    }

    if (is_category() || is_home()) {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('category_nonce'),
        );
        wp_localize_script('sage/main.js', 'category_articles', $ajax_params);
    }

    if (get_page_template_slug() == 'views/template-latest.blade.php') {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('latest_nonce'),
        );
        wp_localize_script('sage/main.js', 'latest_articles', $ajax_params);
    }

    if (get_page_template_slug() == 'views/template-newsroom.blade.php') {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('newsroom_nonce'),
        );
        wp_localize_script('sage/main.js', 'newsroom_articles', $ajax_params);
    }

    if (is_search()) {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('search_nonce'),
        );
        wp_localize_script('sage/main.js', 'search_items', $ajax_params);
    }

    if (
        is_front_page() && get_current_blog_id() === 4 ||
        basename(get_page_template()) == 'transitions-tax.blade.php'
    ) {
        $ajax_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('transitions_nonce'),
        );
        wp_localize_script('sage/main.js', 'list_transitions', $ajax_params);
    }

    wp_localize_script(
        'sage/main.js',
        'add_like',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('likes_nonce'),
        )
    );

    wp_localize_script(
        'sage/main.js',
        'liked_articles',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('liked_articles_nonce'),
        )
    );

    wp_localize_script(
        'sage/main.js',
        'reset_pass',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('reset_pass_nonce'),
        )
    );

    wp_localize_script(
        'sage/main.js',
        'register_user',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('register_user_nonce'),
        )
    );

    wp_localize_script(
        'sage/main.js',
        'update_profile',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('update_profile_nonce'),
        )
    );

    wp_localize_script(
        'sage/main.js',
        'change_pass',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('change_pass_nonce'),
        )
    );
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'top_menu' => __('Top Menu'),
        'services_menu' => __('Services Menu'),
        'sectors_menu' => __('Sectors Menu'),
        'donate_menu' => __('Donate Menu'),
        'main_menu' => __('Main Menu'),
        'footer_menu_1' => __('Footer Menu 1'),
        'footer_menu_2' => __('Footer Menu 2'),
        'footer_menu_3' => __('Footer Menu 3'),
        'footer_menu_4' => __('Footer Menu 4'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Custom shorcode for box
 */
add_shortcode('box', function ($atts, $content = null) {
    return '<div class="et-box et-shadow"><div class="et-box-content">' . $content . '</div></div>';
});

/**
 * Acf options
 */

add_action('acf/init', function () {

    // Check function exists.
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    // register options page.
    $option_page = acf_add_options_page(array(
        'page_title'    => __('Theme General Settings'),
        'menu_title'    => __('Theme Settings'),
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
});

// Set save point
add_filter('acf/settings/save_json', function ($path) {
    $path = get_stylesheet_directory() . '/assets/acf-json';
    return $path;
});

// Set load point(s) - ACF loads all.json files from multiple load points
add_filter('acf/settings/load_json', function ($paths) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/assets/acf-json';
    return $paths;
});

//Add svg support
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    global $wp_version;
    if ($wp_version == '4.7' || ((float) $wp_version < 4.7)) {
        return $data;
    }
    $filetype = wp_check_filetype($filename, $mimes);
    return ['ext' => $filetype['ext'], 'type' => $filetype['type'], 'proper_filename' => $data['proper_filename']];
}, 10, 4);

add_action('admin_head', function () {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
        </style>';
});

/**
 * Remove emojis
 */

add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rest_output_link_wp_head');
});

/**
 * Setup category info page
 */

add_filter('query_vars', function ($vars) {
    $vars[] = 'articles';

    return $vars;
});

add_filter('rewrite_rules_array',  function ($rules) {
    $newRules = array();
    //$newRules['/fr/organisation/(.+)/?$'] = 'index.php?organisation=$matches[1]&ang=$matches[2]';

    return array_merge($newRules, $rules);
});

add_filter('init', function () {
    global $wp;
    $wp->add_query_var('tab');
    $wp->add_query_var('commitment');
});


/** TODO IMPROVE REWRITE RULE */
add_action('init', function () {
    add_rewrite_rule('([^/]*)/articles/?', 'index.php?category_name=$matches[1]&articles=true', 'top');
    add_rewrite_rule('([^/]*)/([^/]*)/articles/?', 'index.php?category_name=$matches[2]&articles=true', 'top');
    add_rewrite_rule('search?', 'index.php?s=$matches[1]', 'top');
}, 10, 0);

add_action('template_redirect', function () {
    if (!get_query_var('articles') && is_category()) {
        add_filter('template_include', function () {
            return locate_template(['views/category-home.blade.php']);
        });
    }

    if (is_search()) {
        add_filter('template_include', function () {
            return locate_template(['views/search.blade.php']);
        });
    }
});

add_action('restrict_manage_posts', function () {
    $params = array(
        'name' => 'author', // this is the "name" attribute for filter <select>
        'show_option_all' => 'All authors' // label for all authors (display posts without filter)
    );

    if (isset($_GET['user']))
        $params['selected'] = $_GET['user']; // choose selected user by $_GET variable

    wp_dropdown_users($params); // print the ready author list
});

/*
add_action('wp_head', function () {
    echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TNSCK2');</script>";
});

add_action('wp_footer', function () {
    echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNSCK2"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
});
*/

add_action('init', function () {
    //init organizations
    if (get_current_blog_id() === 4) {
        register_post_type(
            'organisations',
            array(
                'labels' => array(
                    'name' => __('Organisations'),
                    'singular_name' => __('Organisation'),
                    'add_new' => __('New Organisation'),
                    'add_new_item' => 'Add New Organisation',
                    'edit_item' => 'Edit Organisation'
                ),
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                'rewrite' => array('slug' => 'organisation'),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'author'
                )
            )
        );

        register_taxonomy(
            'sector',
            array('organisations'),
            array(
                'labels'                => array(
                    'name'              => 'Sectors',
                    'singular_name'     => 'Sector',
                    'add_new'           => 'Add New Sector',
                    'add_new_item'      => 'Add Sector'
                ),
                'sort'                  => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'args'                  => array('orderby' => 'term_order'),
                'hierarchical'          => true,
                'rewrite'               => array(
                    'slug' => 'sector',
                    'hierarchical' => true,
                    'with_front' => false
                )
            )
        );

        register_taxonomy(
            'org-size',
            array('organisations'),
            array(
                'labels'                => array(
                    'name'              => 'Organisation sizes',
                    'singular_name'     => 'Organisation size',
                    'add_new'           => 'Add New Organisation size',
                    'add_new_item'      => 'Add Organisation size'
                ),
                'sort'                  => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'args'                  => array('orderby' => 'term_order'),
                'hierarchical'          => true,
                'rewrite'               => array(
                    'slug' => 'org-size',
                    'hierarchical' => true,
                    'with_front' => false
                )
            )
        );

        register_taxonomy(
            'org-type',
            array('organisations'),
            array(
                'labels'                => array(
                    'name'              => 'Organisation types',
                    'singular_name'     => 'Organisation type',
                    'add_new'           => 'Add New Organisation type',
                    'add_new_item'      => 'Add Organisation type'
                ),
                'sort'                  => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'args'                  => array('orderby' => 'term_order'),
                'hierarchical'          => true,
                'rewrite'               => array(
                    'slug' => 'org-type',
                    'hierarchical' => true,
                    'with_front' => false
                )
            )
        );
    }

    //init definitions, newsroom and jobs
    if (get_current_blog_id() === 2 || get_current_blog_id() == 3) {
        register_post_type(
            'definition',
            array(
                'labels' => array(
                    'name' => __('Definitions'),
                    'singular_name' => __('Definition'),
                    'add_new' => __('New Definition'),
                    'add_new_item' => 'Add New Definition',
                    'edit_item' => 'Edit Definition'
                ),
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                'rewrite' => array('slug' => 'definition'),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                    'comments',
                    'author'
                )
            )
        );

        register_post_type(
            'jobs',
            array(
                'labels' => array(
                    'name' => __('Jobs'),
                    'singular_name' => __('Job'),
                    'add_new' => __('New Job'),
                    'add_new_item' => 'Add New Job',
                    'edit_item' => 'Edit Job'
                ),
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                'rewrite' => array('slug' => 'job'),
                'supports' => array(
                    'title',
                    'editor',
                    'author'
                )
            )
        );

        register_post_type(
            'newsroom',
            array(
                'labels' => array(
                    'name' => __('Newsroom'),
                    'singular_name' => __('Press release'),
                    'add_new' => __('New Press release'),
                    'add_new_item' => 'Add New Press release',
                    'edit_item' => 'Edit Press release'
                ),
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                'rewrite' => array('slug' => 'press-release'),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'author'
                )
            )
        );

        register_taxonomy(
            'newsroom_tax',
            array('newsroom'),
            array(
                'labels'                => array(
                    'name'              => 'Press release category',
                    'singular_name'     => 'Press release category',
                    'add_new'           => 'Add New Press category',
                    'add_new_item'      => 'Edit Press release category'
                ),
                'sort'                  => true,
                'show_admin_column'     => true,
                'args'                  => array('orderby' => 'term_order'),
                'hierarchical'          => true,
                'rewrite'               => array(
                    'slug' => 'newsroom-tax',
                    'hierarchical' => true,
                    'with_front' => false
                )
            )
        );
    }
}, 10, 0);
