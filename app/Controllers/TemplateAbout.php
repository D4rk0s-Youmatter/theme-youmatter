<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateAbout extends Controller
{
    use Partials\Hero;

    protected $acf = true;

    public function team()
    {
        $team = [];
        foreach($this->data['members'] as $member)
        {
            array_push($team, self::author($member));
        }

        return($team);
    }

    private function author($uID)
    {
        $recent_author = get_user_by( 'ID', $uID );
        $author =  array(
            'name' => $recent_author->display_name,
            'link' => get_author_posts_url($uID),
            'avatar' => get_avatar($uID),
            'fonction' => get_field('fonction', $recent_author),
            'linkedin' => strlen(get_user_meta($uID)['linkedin'][0]) > 0 ? get_user_meta($uID)['linkedin'][0] : '',
            'twitter' => strlen(get_user_meta($uID)['twitter'][0]) > 0 ? '//twitter.com/@'.get_user_meta($uID)['twitter'][0] : '',
        );
        return $author;
    }
}
