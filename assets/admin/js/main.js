(function ($) {
    $(function () {
        var url = 'https://kit.desgrammer.com/wp-json/kitten/v1/templates/';
        if ($('input[name=template_id]').length) {
            url += $('input[name=template_id]').val()
        } else {
            url += '?type=templates'
        }

        $('.account-menu a.logout').on('click', function (e) {
            e.preventDefault()

			if (confirm('Are you sure to logout?')) {
				$.ajax({
					url: kitten.ajaxUrl,
					method: 'post',
					data: {
						action: 'handle_logout_dg_account',
					}
				}).done(function (response) {
					if (response.success) {
						location.reload()
					}
				})
			}
        })

        loadTemplates(url)
    })

    function loadTemplates(url) {
        $.ajax({
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + kitten.token);
            },
        }).done(function (response) {
            let content = '';
            response.forEach(function (value) {
                content += `
                    <div class="content-single">
                        <div class="content-image">
                            <a ${(value.preview) ? 'target="_blank"' : ''} href="${(value.preview) ? value.preview : 'admin.php?page=kitten&template_id='+value.id}">
                                <img src="${value.thumbnail}" alt="">
                            </a>
                        </div>
                        <div class="content-text">
                            <div class="text">
                                <a href="${(value.preview) ? value.preview : 'admin.php?page=kitten&template_id='+value.id}">
                                    <h3>${value.name}</h3>
                                </a>
                                ${(value.template_count > 0) ? '<p>'+ value.template_count +' templates included</p>' : ''}
                            </div>
                            <div class="content-action">${(false) ? '<a href="#">Import as page</a>' : ''}</div>
                        </div>
                    </div>
                `
            })
            $('.kitten-content-wrapper').empty().append(content)
        })
    }
})(jQuery)