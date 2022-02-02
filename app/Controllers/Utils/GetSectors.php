<?php

namespace App\Controllers\Utils;

/*
/* Gets sectors terms of the transition site 
/*
*/

trait GetSectors
{
    public static function GetSectors()
    {
        switch_to_blog(4);
        $taxonomies = array('sector');
    
        $check_later = array();
        global $wp_taxonomies;
        foreach($taxonomies as $taxonomy){
            if (isset($wp_taxonomies[$taxonomy])){
                $check_later[$taxonomy] = false;
            } else {
                $wp_taxonomies[$taxonomy] = true;
                $check_later[$taxonomy] = true;
            }
        }
    
        $args       = array('hide_empty' => false);
        $terms      = get_terms($taxonomies, $args );
    
        echo '<pre>';
        print_r($terms);
        echo '</pre>';
    
    
        if (isset($check_later))
            foreach($check_later as $taxonomy => $unset)
                if ($unset == true)
                    unset($wp_taxonomies[$taxonomy]);
    
        restore_current_blog();   
    }
}
