@if (comments_open() && !post_password_required())
    <section id="comments" style="margin-bottom: 6em; padding-bottom:6em" class="comments" data-control="comments" data-post="{{ $post->ID }}">
        <h3 class="comments__title">{!! pll__('Comments', 'youmatter') !!}</h3>
        <div id="mautic_comment_form_container" class="comment_form_container <?php if(!isMauticUser()) echo 'paywall_blurred_content'; ?>">
            <?php
            comment_form([
                'fields' => [],
                'label_submit' => pll__('Send', 'youmatter'),
                'title_reply' => '',
                'comment_notes_before' => '',
                'comment_notes_after' => '',
                'class_form' => 'form form--comment',
                'class_submit' => 'form__submit',
                'logged_in_as' => '',
                'must_log_in' => '<p class="comments__info">' . pll__('You must be <a href="#" role="button" data-lightbox-open="login">logged in</a> to post a comment.') . '</p>',
                'comment_field' => '<label for="comment" class="screen-reader-text">' . pll__('Comment', 'noun') . '</label><textarea id="comment" name="comment" class="form__field" cols="45" rows="8" aria-required="true"></textarea>',
            ]);
            if (!isMauticUser() && function_exists(mautic_paywall_get_comment_form)) {
                mautic_paywall_get_comment_form();
            }
            ?>
        </div>
        <span class="comments__info js-info"></span>

        @if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments'))
            <p class="comments__info">
                {{ pll__('Comments are closed.', 'youmatter') }}
            </p>
        @endif

        @if ($comments_list)
            <div class="comments__wrap js-list">
                @include('partials.comments-list', ['comments' => $comments_list])
            </div>

            @if ($comments_total_pages > $comments_current_page)
                <button
                    class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
            @endif
        @endif
    </section>
@endif
