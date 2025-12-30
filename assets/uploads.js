jQuery(function ($) {

    const postId = $('#post_ID').val();
    const list = $('#mplp-assets-list');

    let frame;

    $('#mplp-add-image').on('click', function (e) {
        e.preventDefault();

        if (typeof wp === 'undefined' || !wp.media) {
            console.error('WP Media not loaded');
            return;
        }

        if (frame) {
            frame.open();
            return;
        }

        wp.media.model.settings.post.id = postId;

        frame = wp.media({
            title: 'Add image',
            button: { text: 'Use image' },
            multiple: true,
            library: { type: 'image' } // тільки картинки
        });

        frame.uploader.options.uploader.params = {
            mplp_post_id: postId
        };

        frame.on('select', function () {
            const attachments = frame.state().get('selection').toJSON();

            attachments.forEach(att => {
                saveAsset(att.id);
            });
        });

        frame.open();
    });

    function saveAsset(attachmentId) {
        $.post(ajaxurl, {
            action: 'mplp_add_asset',
            post_id: postId,
            attachment_id: attachmentId
        }, refreshAssets);
    }

    function refreshAssets() {
        $.get(ajaxurl, {
            action: 'mplp_get_assets',
            post_id: postId
        }, function (html) {
            list.html(html);
        });
    }

    list.on('click', '.mplp-delete', function () {
        if (!confirm('Delete this image?')) return;

        $.post(ajaxurl, {
            action: 'mplp_delete_asset',
            attachment_id: $(this).data('id')
        }, refreshAssets);
    });

    refreshAssets();

});
