<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateDefinitions extends Controller
{
    use Partials\Hero;

    protected $acf = ['contact_form'];

    static public $alphabet = [];

    private static function getDefinitions()
    {
        $args = array(
            'post_type' => 'definition',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $query = new \WP_Query($args);

        return $query->posts;
    }

    private static function getFirstLetter($post)
    {
        array_push(self::$alphabet, substr( sanitize_title($post->post_title),0,1) );
    }

    private static function getContent()
    {
        foreach ( self::$definitions as $definition)
        {
            $firstLetter = self::getFirstLetter($definition);

            if ( !is_array( self::$definitions[$firstLetter] )){
                self::$definitions[$firstLetter] = [];
            }

            array_push( self::$definitions[$firstLetter], $definition->post_title);
        }
    }

    public static function getDefinitionsHeader()
    {
        $definitions = self::getDefinitions();
        array_map( 'self::getFirstLetter', $definitions);

        return array_unique(self::$alphabet);
    }

    public static function getDefinitionsContent()
    {
        $definitions = self::getDefinitions();
        $content = [];

        foreach ( $definitions as $definition)
        {
            $firstLetter = substr( sanitize_title($definition->post_title),0,1);
            
            if ( !isset( $content[$firstLetter] )){
                $content[$firstLetter] = [];
            }
            array_push( 
                $content[$firstLetter], array
                (
                    'title' => $definition->post_title,
                    'link' => get_permalink($definition->ID),
                )
            );

        }

        return $content;
    }

}
