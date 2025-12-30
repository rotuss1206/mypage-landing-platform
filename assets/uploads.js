jQuery(function ($) {

    const postId = $('#post_ID').val();
    const list = $('#mplp-assets-list');
    const deleteBtn = $('#mplp-delete-selected');
    const selectAllWrapper = $('#mplp-select-all-wrapper');
    const selectAll = $('#mplp-select-all');

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
            post_id: $('#post_ID').val()
        }, function (html) {
            list.html(html);

            const hasAssets = list.find('li').length > 0;

            // Показати або сховати Select All і Delete Selected
            selectAllWrapper.toggle(hasAssets);
            deleteBtn.toggle(hasAssets);

            // Зняти виділення, якщо нічого немає
            if (!hasAssets) {
                selectAll.prop('checked', false);
            }
        });
    }

    list.on('click', '.mplp-delete', function () {
        if (!confirm('Delete this image?')) return;

        $.post(ajaxurl, {
            action: 'mplp_delete_asset',
            attachment_id: $(this).data('id')
        }, refreshAssets);
    });

    // Копіювання в буфер обміну
    list.on('click', '.mplp-copy-url', function () {
        const input = this;
        input.select();
        document.execCommand('copy');

        const msg = $('<span class="mplp-copy-msg" style="margin-left:10px;color:green;">Copied!</span>');
        $(input).after(msg);
        setTimeout(() => msg.remove(), 1500);
    });

    selectAll.on('change', function () {
        $('.mplp-select-asset').prop('checked', $(this).prop('checked'));
    });

    // Масове видалення
    deleteBtn.on('click', function () {
        const selected = $('.mplp-select-asset:checked');

        if (!selected.length) return alert('Select at least one image');
        if (!confirm('Delete selected images?')) return;

        selected.each(function () {
            const id = $(this).data('id');
            $.post(ajaxurl, {
                action: 'mplp_delete_asset',
                attachment_id: id
            }, refreshAssets);
        });
    });


    refreshAssets();

});
