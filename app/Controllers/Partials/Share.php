<?php
namespace App\Controllers\Partials;

trait Share
{
    public static function displayShare()
    {
        if (
            is_single() ||
            (get_current_blog_id() === 4 && is_front_page())
        ) {
            return true;
        }

        return false;
    }

    public static function shareScript()
    {
        $key = get_field('getsocial_key', 'options');
        $script = '<script>(function() { var po = document.createElement("script");
        po.type = "text/javascript";
        po.async = true;
        po.src = "https://api.at.getsocial.io/get/v1/' . $key . '/gs_async.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(po, s); })();</script>';

        return $script;
    }
}
