<?php

namespace App\Controllers\Partials;

trait Messages
{
    public static function headerMessages()
    {
        if (have_rows('messages', 'option')) :
            $messages = array();
            while (have_rows('messages', 'option')) : the_row();
                $messages[] = wpautop(get_sub_field('message'));
            endwhile;
            return $messages;
        else:
            return false;
        endif;
    }
}
