<?php
namespace App\Controllers\Partials;

trait Hero
{
    public function bgId()
    {

        if(is_home()) {
            return null;
        }

        if (is_category()) {
            return get_field('image', 'category_' . \Category::categoryId());
        }

        if ( basename( get_page_template() ) === 'template-about.blade.php' ){
            return get_field('cover_image');
        }

        if(get_post_type()==='organisations'){
            return get_field('association_banniere');
        }

        if (has_post_thumbnail() && !is_search()) {
            return get_post_thumbnail_id();
        }

        return null;
    }

    public function childCategories()
    {
        if (is_category() && !get_query_var('articles')) {
            $category_id = \Category::categoryId();
            $categories = get_categories([
                'number' => 3,
                'parent' => $category_id
            ]);

            return array_map(function ($item) {
                return array(
                    'id' => $item->term_id,
                    'name' => $item->name,
                    'url' => get_category_link($item->term_id)
                );
            }, $categories);
        }

        return null;
    }

    public function description()
    {
        if (is_page() && !\TemplateContacts::isTemplate()) {
            return get_the_excerpt();
        }

        if (is_category()) {
            $category = get_category(\Category::categoryId());
            $description = $category->description;
            $description_alt = get_field('description', 'category_' . \Category::categoryId());

            if (\Category::isArticlesPage() && $description_alt) {
                return $description_alt;
            }

            return $category->description;
        }

        return null;
    }

    public function icon()
    {
        if (is_category()) {
            $details = \Category::categoryDetails(get_queried_object());
            return $details['image'];
        }

        return null;
    }

    public function organisationLogo()
    {
        global $post;
        if(get_post_type()==='organisations'){
            if (has_post_thumbnail( $post->ID ) ){
                return $image = get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
            } else {
                return false;
            }
        }
    }

    public function meta()
    {
        if (is_single() && get_post_type(get_the_ID() == 'post')) {
            return get_the_category_list(', ', '', get_the_ID());
        }

        return null;
    }
    public function filteredcats()
    {
        if (is_single() && get_post_type(get_the_ID() == 'post')) {
            $terms = get_the_terms(get_the_ID(), 'category');
            $output = "";
            if ($terms) {
                foreach ($terms as $term) {
                    if (!str_contains($term->name, 'Actualité') && !str_contains($term->name, 'news')) { // the term ID you want to exclude
                        $outTerms[] = $term;
                        $output .= '<a href="'.get_term_link($term->term_id).'">'. $term->name .'</a> / ';
                    }
                }
                return $output;
            } else {
                return null;
            }
        }
        return null;
    }
    public function showSubscription()
    {
        /*
        if (is_archive() || get_post_type() ==='organisations') {
            return true;
        }
        */

        return false;
    }

    public function title()
    {
        if(get_field('hero_title')) {
            return get_field('hero_title');
        }

        return \App::title();
    }

    public function relatedDate()
    {
        global $post;
        $months = [
            'fr' => [
                'Janvier','Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            'en' => [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ]
        ];
        $suffix = ['st', 'nd', 'rd'];
        $language = pll_current_language();

        if($post && $post->post_type === 'definition') {
            switch($language){
                case 'fr':
                    $d = get_the_modified_date('j') . ' ' . $months[$language][(get_the_modified_date('n')-1)] . ' ' . get_the_modified_date('Y');
                    break;
                case 'en':
                    $ordinal = array_key_exists((get_the_modified_date('j')-1), $suffix) ? $suffix[(get_the_modified_date('j')-1)] : 'th';
                    $d = get_the_modified_date('j') .'<sup>' . $ordinal . '</sup>' . $months[$language][(get_the_modified_date('n')-1)] . ' ' . get_the_modified_date('Y');
                    break;
            };

            return $d;
        }

        return null;
    }

    public function videoID(){
        return get_field('video_id');
    }
}
