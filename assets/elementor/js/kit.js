(function ($) {
	var addKitTemplate = $('#tmpl-elementor-add-section')
	var updatedKitTemplate = addKitTemplate.text().replace(
            '<div class="elementor-add-section-drag-title',
            '<div class="elementor-add-section-area-button elementor-add-kitten-button" title="Kitten Kit"> <i class="fa fa-folder"></i> </div><div class="elementor-add-section-drag-title'
          )
	addKitTemplate.text(updatedKitTemplate)

  elementor.on('preview:loaded', function () {
    let $kittenJS = $('#kitten-elementor-kit-js');
    let $kittenModal = $('<div id="kittenEditorModal"></div>')
    $kittenModal.insertAfter($kittenJS);

		/**
		 * Open Elekit modal on editor */
     $(elementor.$previewContents[0].body).on('click', '.elementor-add-kitten-button', function () {
       showModal()
     })

     /**
      * Dismiss / Close modal on editor */
     $('body').on('click', '.kitten-modal-close a.close, .kitten-editor-backdrop', function (e) {
        e.preventDefault()
        hideModal()
     })

     /**
      * Prevent close on click inside modal */
     $('body').on('click', '.kitten-editor-modal', function (e) {
       e.stopPropagation()
     })

     /**
      * Prevent close on click inside modal */
     $('body').on('kitten:closed', function (e) {
       hideModal()
     })
  })

  function showModal() {
    jQuery('body').trigger('kitten:loaded');
    jQuery('.kitten-editor-backdrop').css({
        visibility: 'visible',
        opacity: 1,
    })
    setTimeout(() => {
        jQuery('.kitten-editor-modal').css({
            visibility: 'visible',
            opacity: 1,
            transform: 'scale(1)'
        })
    }, 50);
  }

  function hideModal() {
    jQuery('.kitten-editor-modal').css({
      visibility: 'hidden',
      opacity: 0,
      transform: 'scale(.8)'
    })
    setTimeout(() => {
       jQuery('.kitten-editor-backdrop').css({
           visibility: 'hidden',
           opacity: 0,
       })
    }, 50);
  }
  
})(jQuery)