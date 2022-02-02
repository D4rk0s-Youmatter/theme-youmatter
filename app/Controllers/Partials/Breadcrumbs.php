<?php
namespace App\Controllers\Partials;

trait Breadcrumbs
{
    public static function breadcrumbsList()
    {
        global $post;

        $list = array(
            array(
                'title' => pll__('Homepage'),
                'url' => site_url()
            )
        );

        if (is_category()) {
            $list[] = self::getCategoryDetails(get_queried_object());

            if (\Category::isArticlesPage()) {
                $list[] = array(
                    'title' => pll__('All articles'),
                    'url' => self::getCurrentUrl()
                );
            }
        }

        if (is_home()) {
            $list[] = array(
                'title' => pll__('Latest articles'),
                'url' => self::getCurrentUrl()
            );
        }

        if (is_single()) {
            if ( get_post_type() === 'organisations'){
                $list[] = array(
                    'title' => pll__('Organization'),
                    'url' => ''
                );
            } else if ( get_post_type() === 'newsroom') {
                $list[] = array(
                    'title' => pll__('Newsroom'),
                    'url' => \App::options()['newsroom_page_url']
                );
            } else if ( get_post_type() === 'definition') {
                $list[] = array(
                    'title' => pll__('Definitions'),
                    'url' => \App::options()['definition_page_url']
                );
            } else {


                if ( function_exists('yoast_breadcrumb') ) {
                    $yoast_breadcrumb = yoast_breadcrumb( '', '', false );
                    return $yoast_breadcrumb;
                  }
                else {
                    $first_cat = get_category(\Single::getFirstCategory());
                    //print_r($first_cat);
                    if ($first_cat && !is_wp_error($first_cat)) {
                        $list[] = self::getCategoryDetails($first_cat);
    
                        $items = \Single::getCategories();
    
                        foreach($items['subcats'] as $subcat) {
                            $details = get_category($subcat);
                            if($details->parent === $first_cat->term_id) {
                                $list[] = self::getCategoryDetails($details);
                                break;
                            }
                        }
                    }
                }

            }
        }

        if (is_page()) {
            $pages = get_ancestors($post->ID, $post->post_type);

            if ($pages) {
                $pages = array_reverse($pages);
                $pages = array_diff($pages, array(get_option('page_on_front')));

                $list = array_merge(
                    $list,
                    array_map(function ($page) {
                        return array(
                        'title' => get_the_title($page),
                        'url' => get_permalink($page)
                    );
                    }, $pages)
                );
            }

            $list[] = array(
                'title' => get_the_title(),
                'url' => get_permalink()
            );
        }

        if (is_search()) {
            $list[] = array(
                'title' => pll__('Search'),
                'url' => self::getCurrentUrl()
            );
        }

        if(is_front_page()) {
            $list = null;
        }

        return $list;
    }

    private static function getCategoryDetails($cat)
    {
        $details = \Category::categoryDetails($cat);

        return array(
            'title' => $details['title'],
            'url' => $details['url']
        );
    }

    private static function getCurrentUrl() {
        return "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }
}
