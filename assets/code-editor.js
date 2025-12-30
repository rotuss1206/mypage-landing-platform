jQuery(document).ready(function ($) {

    const editors = [
        'mplp_only_html',
        'mplp_head_html',
        'mplp_body_html',
        'mplp_head_js',
        'mplp_footer_js',
    ];

    const heights = {
        mplp_head_html: 250,
        mplp_body_html: 600,
        mplp_only_html: 600,
        mplp_head_js: 250,
        mplp_footer_js: 250
    };

    const cmInstances = {};

    // Initialize only on visible textareas (active tab)
    editors.forEach(function(name) {
        const textarea = document.querySelector(`textarea[name="${name}"]`);
        if (!textarea) return;

        // Initializing and saving an instance
        cmInstances[name] = wp.codeEditor.initialize(textarea, {
            type: name.includes('js') ? 'application/javascript' : 'text/html'
        });

        if (heights[name]) {
            cmInstances[name].codemirror.setSize(null, heights[name]);
        }
    });

    // Tabs
    const tabs = document.querySelectorAll('.mplp-tab');
    const contents = document.querySelectorAll('.mplp-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            const currentTab = document.getElementById('tab-' + tab.dataset.tab);
            currentTab.classList.add('active');

            // Refresh CodeMirror of all textarea in visible tab
            currentTab.querySelectorAll('textarea').forEach(function(textarea) {
                const name = textarea.getAttribute('name');
                if (cmInstances[name]) {
                    cmInstances[name].codemirror.refresh();
                }
            });
        });
    });

    function updateTabs(mode) {
        if (mode === 'only_html') {
            $('#tab-only_html').addClass('active');
            $('#tab-html_js').removeClass('active');
        } else {
            $('#tab-only_html').removeClass('active');
            $('#tab-html_js').addClass('active');
        }

        // refresh CodeMirror у видимому табі
        $('.mplp-tab-content.active textarea').each(function () {
            const cm = this.nextSibling?.CodeMirror;
            if (cm) cm.refresh();
        });
    }

    const radios = $('input[name="mplp_render_mode"]');

    updateTabs(radios.filter(':checked').val());

    radios.on('change', function () {

      console.log(this.value)
        updateTabs(this.value);
    });

});
