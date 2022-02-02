<?php
namespace App\Controllers\Partials;
use App;

trait Card
{
    public static function title()
    {
        return subStringTitle($article->post_title);
    }

    public static function subStringTitle($title)
    {
        return wp_trim_words($title, 14);
    }

    public static function getReadingTime($content)
    {
        $noTags = strip_tags($content);
        $wordCount = count(explode(' ', $noTags));

        return ceil($wordCount/180);
    }

    public static function getAuthor($author)
    {
        return is_numeric($author) ? get_the_author_meta('display_name', $author) : $author;
    }

    public static function timeElapsedSstring($time, $full)
    {
        return \App::getTimeAgo($time);
    }

    public static function getCardImage($thumb, $options)
    {
        if (!$thumb) {
            $thumb = '<img src="' . $options['card_image'] . '" />';
        }

        return $thumb;
    }

    public static function displayCardCategoryTop($id, $layout)
    {
        return $layout === 'simple';
    }

    public static function displayCardDetails($id, $layout)
    {
        return (get_post_type($id) === 'post' || get_post_type($id) === 'newsroom') && ($layout === 'classique' || $layout === 'simple' || $layout === 'large');
    }

    public static function displayCardMeta($id, $layout)
    {
        return (get_post_type($id) === 'post' || get_post_type($id) === 'definition' || get_post_type($id) === 'newsroom') && ($layout === 'classique' || $layout === 'large');
    }

    public static function displayCardMore($id, $layout)
    {
        return $layout === 'minimal';
    }

    public static function getCardDetails($article, $layout, $excerpt)
    {
        $details = array(
            'id' => $article->ID,
            'title' => get_the_title($article->ID),
            'image' => get_the_post_thumbnail($article->ID),
            'layout' => $layout,
            'url' => get_permalink($article->ID),
            'excerpt' => null,
            'content' => null,
            'time' => null,
            'author' => null,
            'likes' => null,
            'cats' => null
        );

        if ( get_post_type($article->ID) === 'post'  ) {
            $cats = array_map(
                function ($cat) {
                    return $cat->name;
                },
                wp_get_object_terms(
                    $article->ID,
                    'category',
                    ['childless' => true]
                )
            );

            $details = array(
                'id' => $article->ID,
                'title' => \App::subStringTitle(get_the_title($article->ID)),
                'excerpt' => $excerpt ? get_the_excerpt($article->ID) : null,
                'content' => get_post_field('post_content', $article->ID),
                'time' => get_the_time("U", $article->ID),
                'author' => get_post_field('post_author', $article->ID),
                'likes' => \App::getLikes($article->ID),
                'image' => self::getCardImage(
                    get_the_post_thumbnail($article->ID),
                    \App::options()
                ),
                'cats' => count($cats) > 0 ? $cats[0] : '',
                'layout' => $layout,
                'url' => get_permalink($article->ID)
            );
        }

        if ( get_post_type($article->ID) === 'definition' ) {
            $details = array(
                'id' => $article->ID,
                'title' => \App::subStringTitle(get_the_title($article->ID)),
                'excerpt' => $excerpt ? get_the_excerpt($article->ID) : null,
                'content' => get_post_field('post_content', $article->ID),
                'time' => get_post_field('post_date', $article->ID),
                'author' => get_post_field('post_author', $article->ID),
                'likes' => \App::getLikes($article->ID),
                'image' => self::getCardImage(
                    get_the_post_thumbnail($article->ID),
                    \App::options()
                ),
                'cats' => null,
                'layout' => $layout,
                'url' => get_permalink($article->ID)
            );
        }

        if (get_post_type($article->ID) === 'newsroom') {
            $cats = array_map(
                function ($cat) {
                    return $cat->name;
                },
                wp_get_object_terms(
                    $article->ID,
                    'newsroom_tax',
                    ['childless' => true]
                )
            );

            $details = array(
                'id' => $article->ID,
                'title' => \App::subStringTitle(get_the_title($article->ID)),
                'excerpt' => $excerpt ? get_the_excerpt($article->ID) : null,
                'content' => get_post_field('post_content', $article->ID),
                'time' => get_post_field('post_date', $article->ID),
                'author' => get_field('source', $article->ID),
                'likes' => \App::getLikes($article->ID),
                'image' => self::getCardImage(
                    get_the_post_thumbnail($article->ID),
                    \App::options()
                ),
                'cats' => count($cats) > 0 ? implode(', ', $cats) : '',
                'layout' => $layout,
                'url' => get_permalink($article->ID),
            );
        }

        return $details;
    }
}
