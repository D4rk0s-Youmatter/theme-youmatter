<?php
namespace App\Controllers;
use Sober\Controller\Controller;

class Single extends Controller
{
    use Partials\Hero;
    use Partials\Related;
    use Partials\RelatedDefinitions;
    use Partials\Sponsored;
    use Partials\Comments;

    protected $acf = true;


    public function __construct()
    {
        add_action('wp_ajax_organisations_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_organisations_articles', [$this, 'articlesListAjax']);
        add_shortcode( 'mwm-aal-display', array($this, 'addIndexShortcode'));
        add_shortcode( 'sponsored', array($this, 'sponsored'));
    }

    public function sponsored_articles()
    {
        return self::sponsoredArticles();
    }

    public static function sponsored()
    {
        $sponsored_articles = self::sponsoredArticles();
        $response = '';
        if(!empty($sponsored_articles)):
            $response .= '<section class="sponsored embed">';
            $response .= '<h5 class="sponsored__title">' . pll__('Sponsored articles', 'youmatter'). '</h5>';
            $response .= '<div class="sponsored__items">';
            for($i = 0; $i < 2; $i++):
                $article = $sponsored_articles[$i];
                $response .= '<a href="' . $article['url'] .'" class="card card--simple">';
                $response .= '<div class="card__figure">';
                $response .= '<img src="' . $article['image'] .'" alt="' . $article['title'] . '">';
                $response .= '</div>';
                $response .= '<div class="card__content">';
                $response .= '<h3 class="card__title">' . $article['title'] . '</h3>';
                $response .= '<h4 class="card__author">' . pll__('by', 'youmatter') . ' ' . $article['org'] . '</h4>';
                $response .= '</div>';
                $response .= '</a>';
            endfor;
            $response .= '</div>';
            $response .= '</section>';
        endif;
        return $response;
    }

    private static function articlesPageStatic()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    private function relatedExcludedCategory()
    {
        return App::options()['excluded_category'];
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

    public static function articlesListAjax()
    {
        check_ajax_referer('organisations_nonce', 'security');

        $paged = self::articlesPageStatic();
        $lang = sanitize_text_field($_POST['lang']);
        $authors = sanitize_text_field($_POST['authors']);

        $args = array(
            'posts_per_page' => 6,
            'paged' => $paged,
            'lang' => $lang,
            'author__in' => explode(',',$authors),
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

    public function articleCategory()
    {
        $cat = self::getFirstCategory();

        if (!isset($cat)) {
            $cat_details = \Category::categoryDetails(get_category($cat));
            $cat_details['title'] = sprintf(pll__('See %s category'), $cat_details['title']);

            return array(
                $cat_details
            );
        }

        return null;
    }

    public function author()
    {
        global $post;

        $author_id = $post->post_author;
        $field_id = 'user_' . $author_id;
        $field_sufix = pll_current_language() === 'en' ? '_' . pll_current_language() : '';
        switch_to_blog(4);
        $avatar = get_field('profile_image', $field_id);
        restore_current_blog();

        $author =  array(
            'name' => get_the_author(),
            'description' => get_field('description' . $field_sufix, $field_id),
            'job' => get_field('fonction' . $field_sufix, $field_id),
            'image' => $avatar,
            'link' => get_author_posts_url($author_id),
            'organisation' => '',
            'org_link' => ''
        );

        switch_to_blog(4);

        $args = array(
            'post_type' => 'organisations',
            'posts_per_page' => -1,
            'post_status' => 'published'
        );

        $query = new \WP_Query($args);

        if(!empty($query->posts)){
            foreach($query->posts as $org){
                $orgUsers = get_field('users', $org->ID);

                if(!empty($orgUsers)){
                    foreach($orgUsers as $u){
                        if (isset($u['user']['ID']) &&  $u['user']['ID'] == $author_id){
                            $author['organisation'] = $org->post_title;
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

    public function date()
    {
        global $post;
        $months = [
            'fr' => [
                'janvier','février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
            ],
            'en' => [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ]
        ];
        $suffix = ['st', 'nd', 'rd'];
        $language = pll_current_language();

        switch($language){
            case 'fr':
                $d = "Publié le " . get_the_date('j') . ' ' . $months[$language][get_the_date('n')-1] . ' ' . get_the_date('Y');
                break;
            case 'en':
                $ordinal = array_key_exists((get_the_date('j')-1), $suffix) ? $suffix[(get_the_date('j')-1)] : 'th';
                $d = "Published at " . get_the_date('Y') . ', ' .$months[$language][get_the_date('n')-1] . ' ' . get_the_date('j') .'<sup>' . $ordinal . '</sup>';
                break;
        };

        return $d;
    }

    public static function getCategories()
    {
        $cats = wp_get_post_categories(get_the_ID(), array(
            'parent' => 0,
            'count' => 1,
            'exclude' => [1, 1836]
        ));

        //wp_die(print_r($cats));

        $subcats = wp_get_post_categories(get_the_ID(), array(
            'childless' => true,
            'count' => 1,
            'exclude' => [1, 1836]
        ));

        return array(
            'cats' => $cats,
            'subcats' => $subcats,
        );
    }

    public static function getFirstCategory($aloneMode = true)
    {
        if ($aloneMode) {
            $yoast_primary_cat_id = get_post_meta(get_the_ID(), "_yoast_wpseo_primary_category", true);

            if (isset($yoast_primary_cat_id)) {
                return get_category($yoast_primary_cat_id);
            }
        }
        $items = self::getCategories();
        $cats = $items['cats'];
        $subcats = $items['subcats'];

        if (!empty($cats)) {
            return $cats[0];
        }

        if (!empty($subcats)) {
            $subcat = get_category($subcats[0]);

            return $subcat->parent;
        }

        return null;
    }

    public function organizationTab()
    {
        return get_query_var('tab');
    }

    public function organizationCommitment()
    {
        return get_query_var('commitment');
    }

    public function organisationSector()
    {
        if (get_post_type() === 'organisations'){

            global $post;

            if( taxonomy_exists('sector')){
                return wp_get_post_terms( $post->ID, 'sector')[0]->name;
            }
        }
    }

    public static function getCommitments()
    {
        global $post;
        $lang = pll_current_language();

        $commits = [];

        if( strlen(get_field('business_model_&_business_impact')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "modele-economique-impact" : "business-model-impact",
                "title" => $lang === "fr" ? "Modèle économique et Impact économique" : "Business model & business impact",
                "content" => get_field('business_model_&_business_impact')
            );
        }

        if( strlen(get_field('environmental_strategy')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "strategie-environnementale" : "environmental-strategy",
                "title" => $lang === "fr" ? "Stratégie environnementale" : "Environmental strategy ",
                "content" => get_field('environmental_strategy')
            );
        }

        if( strlen(get_field('social_impact')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "impact-social" : "social-impact",
                "title" => $lang === "fr" ? "Impact social" : "Social impact",
                "content" => get_field('social_impact')
            );
        }

        if( strlen(get_field('corporate_governance')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "gouvernance" : "corporate-governance",
                "title" => $lang === "fr" ? "Gouvernance d'entreprise" : "Corporate governance",
                "content" => get_field('corporate_governance')
            );
        }

        if( strlen(get_field('communication_and_marketing')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "communication-marketing" : "communication-marketing",
                "title" => $lang === "fr" ? "Communication et marketing" : "Communication and marketing",
                "content" => get_field('communication_and_marketing')
            );
        }

        if( strlen(get_field('hr_&_working_conditions')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "rh-conditions-travail" : "hr-working-conditions ",
                "title" => $lang === "fr" ? "RH & Conditions de travail" : "HR & Working conditions",
                "content" => get_field('hr_&_working_conditions')
            );
        }

        if( strlen(get_field('r&d')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "rd-recherche-developpement" : "rd-research-development",
                "title" => $lang === "fr" ? "Recherche et développement" : "Research and development",
                "content" => get_field('r&d')
            );
        }

        if( strlen(get_field('logistics_and_infrastructure')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "logistique-infrastructure" : "logistics-infrastructure",
                "title" => $lang === "fr" ? "Logistique et infrastructure" : "Logistics and infrastucture",
                "content" => get_field('logistics_and_infrastructure')
            );
        }

        if( strlen(get_field('corporate_social_responsibility')) > 0){
            $commits[] = array(
                "nav" => $lang === "fr" ? "est" : "strategie-rse/csr-strategy",
                "title" => $lang === "fr" ? "Stratégie RSE" : "CSR strategy",
                "content" => get_field('corporate_social_responsibility')
            );
        }

        return $commits;
    }

    public function organisationUsers()
    {
        global $post;
        $u = [];

        $users = get_field('users', $post->ID);
        //wp_die(print_r($users));

        if( !empty($users)){
            foreach($users as $user){
                if( isset($user['user']['ID']) && count_user_posts($user['user']['ID']) > 0){
                    $u[] = array(
                        'image' => $user['user']['user_avatar'],
                        'link' => get_author_posts_url($user['user']['ID']),
                        'name' => get_the_author_meta('display_name', $user['user']['ID']),
                        'description' => get_the_author_meta('user_description', $user['user']['ID']),
                        'role' => get_the_author_meta('fonction', $user['user']['ID']),
                        'linkedin' => get_the_author_meta('linkedin', $user['user']['ID']) ? get_the_author_meta('linkedin', $user['user']['ID']) : get_the_author_meta('user_linkedin', $user['user']['ID']),
                        'twitter' => get_the_author_meta('twitter', $user['user']['ID']),
                    );
                }
            }
        }

        return $u;
    }

    public function authors()
    {
        global $post;
        $users = get_field('users', $post->ID);
        $u = [];
        if(!empty($users)){
            foreach($users as $user){
                $u[] = $user['user']['ID'];
            }
        }

        return implode(',',$u);
    }

    public function news()
    {
        global $post;
        $users = get_field('users', $post->ID);
        $u = [];
        if(!empty($users)){
            foreach($users as $user){
                $u[] = $user['user']['ID'];
            }
        }

        if( count($u) > 0){


            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'post_status' => 'publish',
                'author__in' => $u
            );
            $query = new \WP_Query($args);
            return $query;
        } else {
            return FALSE;
        }
    }

    public function faqs()
    {
        return get_field('faqs');
    }

    public function faqCategories()
    {
        global $post;
        $lang = pll_current_language();
        $faqs = get_field('faqs');
        $cats = [];

        $translations =[];
        $translations[0] = $lang === "fr" ? "Modèle économique et Impact économique" : "Business model & business impact";
        $translations[1] = $lang === "fr" ? "Stratégie environnementale" : "Environmental strategy ";
        $translations[2] = $lang === "fr" ? "Impact social" : "Social impact";
        $translations[3] = $lang === "fr" ? "Gouvernance d'entreprise" : "Corporate governance";
        $translations[4] = $lang === "fr" ? "Communication et marketing" : "Communication and marketing";
        $translations[5] = $lang === "fr" ? "Recherche et développement" : "Research and development";
        $translations[6] = $lang === "fr" ? "Logistique et infrastructure" : "Logistics and infrastucture";
        $translations[7] = $lang === "fr" ? "Stratégie RSE" : "CSR strategy";
        $translations[8] = $lang === "fr" ? "RH & Conditions de travail" : "HR & Working conditions";

        if(!empty($faqs)){
            foreach($faqs as $faq){
                if(!empty($faq['category'])){
                    $cats = array_merge($cats,$faq['category']);
                }
            }
        }

        $response = [];
        if(!empty($cats)){
            foreach(array_unique($cats) as $cat){
                $response[$cat] = $translations[$cat];
            }
        }

        return($response);
    }

    public function tabs()
    {
        $lang = pll_current_language();
        $tabs = [];

        if($lang === 'fr'){
            $tabs = array(
                array(
                    'url' => 'a-propos',
                    'title' => 'À propos',
                    'class' => '',
                ),
                array(
                    'url' => 'engagements',
                    'title' => 'Engagements',
                    'class' => '',
                ),
                array(
                    'url' => 'contributeurs',
                    'title' => 'Contributeurs',
                    'class' => '',
                ),
                array(
                    'url' => 'actualites',
                    'title' => 'Actualités',
                    'class' => '',
                ),
                array(
                    'url' => 'reponses',
                    'title' => 'Réponses',
                    'class' => '',
                ),
            );
            if(count(self::getCommitments())=== 0){
                $tabs[1]['class'] = 'hidden';
            }
            if(!self::faqs()){
                $tabs[4]['class'] = 'hidden';
            }
        } else {
            $tabs = array(
                array(
                    'url' => 'about',
                    'title' => 'About',
                    'class' => '',
                ),
                array(
                    'url' => 'commitments',
                    'title' => 'Commitments',
                    'class' => '',
                ),
                array(
                    'url' => 'contributors',
                    'title' => 'Contributors',
                    'class' => '',
                ),
                array(
                    'url' => 'news',
                    'title' => 'News',
                    'class' => '',
                ),
                array(
                    'url' => 'answers',
                    'title' => 'Answers',
                    'class' => '',
                ),
            );
            if(count(self::getCommitments())=== 0){
                $tabs[1]['class'] = 'hidden';
            }
            if(!self::faqs()){
                $tabs[4]['class'] = 'hidden';
            }
        }
        return $tabs;
    }

    public static function headingsIndex()
    {
        global $post;

        $content = $post->post_content;
        $pattern='#<h([1-6])(?: [^>]+)?>(.+?)</h[1-6]>#is';
        preg_match_all($pattern,$content, $matches, PREG_SET_ORDER);
        $links = $matches;

        $index = '';
        $level = 0;
        if (!empty($links)){
            $index .= '<ul>';
            $level = $links[0][1];
            foreach($links as $link){

                if($link[1] != $level){
                    $index .= '<ul>';
                }
                $index .= '<li>' . strip_tags($link[2]) . '</li>';
                if($link[1] != $level){
                    $index .= '</ul>';
                }
                $level = $link[1];
            }
            $index .= '</ul>';
        }
        return $index;
    }

    function addIndexShortcode ( ) {
        global $post;

        $content = $post->post_content;
        $pattern='#<h([1-6])(?: [^>]+)?>(.+?)</h[1-6]>#is';
        preg_match_all($pattern,$content, $matches, PREG_SET_ORDER);
        $links = $matches;
        $index = '<div class="et-box" data-control="scroll"><div class="et-box-content">';
        $level = 0;
        if (!empty($links)){
            $index .= '<ul>';
            $level = $links[0][1];
            $k = 0;
            foreach($links as $link){

                $replacement = ' id="anchor_'. $k . '"';
                $newHeader = substr_replace($link[0], $replacement, 3, 0);
                $content = str_replace($link[0], $newHeader, $content);

                if($link[1] != $level){
                    $index .= '<ul>';
                }
                $index .= '<li><a href="#anchor_'.$k.'">' . strip_tags($link[2]) . '</a></li>';
                if($link[1] != $level){
                    $index .= '</ul>';
                }
                $level = $link[1];
                $k++;
            }
            $index .= '</ul>';
        }
        $index .= '</div></div>';

        $post->post_content = $content;

        return $index;
    }

}
