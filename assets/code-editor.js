jQuery(function ($) {
  if (!wp.codeEditor) return;

  const settingsHTML = {
    codemirror: {
      mode: 'htmlmixed',
      lineNumbers: true,
      lineWrapping: true,
      autoRefresh: true,
      foldGutter: true,
      gutters: [
        "CodeMirror-linenumbers",
        "CodeMirror-foldgutter"
      ]
    }
  };

  const settingsJS = {
    codemirror: {
      mode: 'javascript',
      lineNumbers: true,
      lineWrapping: true,
      autoRefresh: true
    }
  };

  $('textarea[name="mplp_head_html"], textarea[name="mplp_body_html"]').each(function () {
    wp.codeEditor.initialize(this, settingsHTML);
  });

  $('textarea[name="mplp_head_js"], textarea[name="mplp_footer_js"]').each(function () {
    wp.codeEditor.initialize(this, settingsJS);
  });
});
