jQuery(document).ready(function ($) {

  const editors = [
    'mplp_head_html',
    'mplp_body_html',
    'mplp_head_js',
    'mplp_footer_js'
  ];

  editors.forEach(function (name) {
    const textarea = document.querySelector(`textarea[name="${name}"]`);
    if (!textarea) return;

    wp.codeEditor.initialize(textarea, {
      type: name.includes('js') ? 'application/javascript' : 'text/html'
    });
  });

});