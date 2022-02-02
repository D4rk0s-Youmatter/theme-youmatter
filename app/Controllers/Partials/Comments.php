<?php
namespace App\Controllers\Partials;

trait Comments
{
    public function __construct()
    {
        add_action('wp_ajax_comments_list', [$this, 'commentsListAjax']);
        add_action('wp_ajax_nopriv_comments_list', [$this, 'commentsListAjax']);
        add_action('wp_ajax_comments_reply', [$this, 'commentsReplyAjax']);
        add_action('wp_ajax_nopriv_comments_reply', [$this, 'commentsReplyAjax']);
    }

    public function commentsCurrentPage()
    {
        return self::getCurrentPage();
    }

    public function commentsList()
    {
        return self::getCommentsList(get_the_ID());
    }

    public function commentsTotalPages()
    {
        return get_comment_pages_count();
    }

    public static function commentsListAjax()
    {
        check_ajax_referer('comments_nonce', 'security');

        $post_id = isset($_POST['post']) && intval($_POST['post']) ? $_POST['post'] : null;

        if ($post_id) {
            $data = self::getCommentsList($post_id);
            $data_html = null;

            if ($data) {
                $data_html = \App\template(
                'partials.comments-list',
                array(
                  'comments' => $data
                )
              );
            }

            wp_send_json_success($data_html);
        } else {
            wp_send_json_error(pll__('An error occurred.'), 500);
        }

        wp_die();
    }

    public static function commentsReplyAjax()
    {
        check_ajax_referer('reply_nonce', 'security');

        $submission = wp_handle_comment_submission(wp_unslash($_POST));

        if (is_wp_error($submission)) {
            wp_send_json_error(pll__('An error occurred.'), 500);
        } else {
            wp_send_json_success(pll__('Your comment was submitted.'));
        }

        wp_die();
    }

    private static function getCommentsList($post_id)
    {
        global $post;

        $paged = self::getCurrentPage();
        $args = array(
            'post__in' => array($post_id),
            'paged' => $paged,
            'number' => self::getCommentsPerPage(),
            'parent' => 0,
            'status' => 'approve'
        );

        $data = new \WP_Comment_Query($args);

        if (empty($data->comments)) {
            return null;
        }

        return array_map(function ($comment) {
            return self::getCommentDetails($comment);
        }, $data->comments);
    }

    private static function getCommentChildren($comment_id, $depth)
    {
        global $post;

        $children = new \WP_Comment_Query(array(
            'parent' => $comment_id,
            'status' => 'approve'
        ));

        if (empty($children->comments)) {
            return null;
        }

        return array_map(function ($comment) use ($depth) {
            return self::getCommentDetails($comment, $depth);
        }, $children->comments);
    }

    private static function getCommentDetails($comment, $depth = 1)
    {
        $max_depth = get_option('thread_comments_depth');

        return array(
          'id' => $comment->comment_ID,
          'author' => $comment->comment_author ? $comment->comment_author : 'Anonymous',
          'date' => date(get_option('date_format'), strtotime($comment->comment_date)),
          'text' => $comment->comment_content,
          'children' => self::getCommentChildren($comment->comment_ID, $depth + 1),
          'can_reply' => $max_depth > $depth
        );
    }

    private static function getCurrentPage()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    private static function getCommentsPerPage()
    {
        return get_option('comments_per_page');
    }
}
