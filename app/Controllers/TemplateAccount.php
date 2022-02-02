<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateAccount extends Controller
{
    public function __construct()
    {
        add_action('wp_ajax_update_profile', [$this, 'updateProfileAjax']);
        add_action('wp_ajax_nopriv_update_profile', [$this, 'updateProfileAjax']);

        add_action('wp_ajax_change_pass', [$this, 'changePassAjax']);
        add_action('wp_ajax_nopriv_change_pass', [$this, 'changePassAjax']);
    }

    public function user()
    {
        global $user_ID;

        $firstName = get_user_meta( $user_ID, 'first_name', true);
        $lastName = get_user_meta( $user_ID, 'last_name', true);
        $description = get_user_meta($user_ID, 'description', true);
        $acceptance = get_user_meta($user_ID, 'acceptance', true);

        $userData = array(
            'ID'          => $user_ID,
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'description' => $description,
            'acceptance' => $acceptance,
        );

        return $userData;
    }

    public static function updateProfileAjax()
    {
        check_ajax_referer('update_profile_nonce', 'security');

        $userID = esc_attr( wp_unslash($_POST['user_id']));
        $userFirstName = esc_attr( wp_unslash($_POST['first_name_input']));
        $userLastName = esc_attr( wp_unslash($_POST['last_name_input']));
        $userDescription = wp_unslash($_POST['description_input']);
        $acceptance = esc_attr( wp_unslash($_POST['acceptance']));

        $userData = array(
            'ID'          => $userID,
            'first_name'  => $userFirstName,
            'last_name'   => $userLastName,
            'description' => $userDescription,
        );
        $updateUser = wp_update_user( $userData );
        $updateAcceptance = update_user_meta( $userID, 'acceptance', $acceptance );

        if ( $updateUser > 0 )
        {
            wp_send_json_success(pll__('You profile was updated.', 'youmatter'));
        }
        else
        {
            wp_send_json_error( pll__('There was an error please try later on.', 'youmatter') );
        }
        wp_die();

        
    }

    public static function changePassAjax()
    {
        check_ajax_referer('change_pass_nonce', 'security');

        $userID = esc_attr( wp_unslash($_POST['user_id']));
        $password = $_POST['password_input'];

        $updatePass = wp_set_password( $password, $userID );

        if ( $updatePass )
        {
            wp_send_json_success(pll__('You password was updated.', 'youmatter'));
        }
        else
        {
            wp_send_json_error( pll__('There was an error please try later on.', 'youmatter') );
        }
        wp_die();
    }

}
