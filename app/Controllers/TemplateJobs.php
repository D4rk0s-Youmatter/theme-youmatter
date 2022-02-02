<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateJobs extends Controller
{
    use Partials\Hero;

    protected $acf = true;

    public static function getJobs()
    {
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $query = new \WP_Query($args);
    

        return array_map(function ($job) {
            return array(
                'title' => $job->post_title,
                'link' => get_permalink($job->ID),
                'location' => get_field('location', $job->ID),

            );
        }, $query->posts);;
    }
}
