function importElementor(content, settings) {
    $e = window.$e;
    for (
        var log = $e.internal("document/history/start-log", {
            type: "add",
            title: "Add Envato Elements Content",
          }),
          r = 0;
        r < content.length;
        r++
      )
    $e.run('document/elements/create', {
        container: elementor.getPreviewContainer(),
        model: content[r]
    })
    $e.internal("document/history/end-log", { id: log });

    $e.run('document/elements/settings', {
      container: elementor.settings.page.getEditedView().getContainer(),
      settings: settings,
      options: {
        external: true
      }
    });

    jQuery('body').trigger('kitten:closed');
}

export default importElementor;