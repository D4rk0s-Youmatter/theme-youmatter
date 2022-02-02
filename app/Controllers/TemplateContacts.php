<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateContacts extends Controller
{
    use Partials\Hero;

    protected $acf = ['contact_form'];

    public function __construct()
    {
        add_action('wp_enqueue_scripts', function () {
            if (function_exists('wpcf7_enqueue_scripts')) {
                wpcf7_enqueue_scripts();
            }
        }, 100);
    }
    public function teamDetails()
    {
        $team = get_field('team');

        if (!$team) {
            return null;
        }

        $team['people'] = array_map(function ($person_id) {
            $data = get_userdata($person_id);
            switch_to_blog(4);
                $avatar = get_field('profile_image', 'user_' . $person_id);
            restore_current_blog();

            return array(
              'name' => $data->display_name,
              'description' => $data->description,
              'image' => $avatar
            );
        }, $team['people']);

        return $team;
    }

    public static function isTemplate()
    {
        return basename(get_page_template()) == 'template-contacts.blade.php';
    }
}
