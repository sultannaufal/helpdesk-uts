require('./bootstrap');

// Подставлять имена загружаемых файлов
$('.custom-file-input').on('change', function () {
    $(this).parent()
        .find('.custom-file-label')
        .text(this.files[0].name);
});

const $useOldAttachmentCondition = $('#use-old-attachment-condition');

$useOldAttachmentCondition
    .find('input')
    .on('change', function ({ target: checkbox }) {
        if (checkbox.checked) {
            $useOldAttachmentCondition.attr('data-condition', 'true');
        } else {
            $useOldAttachmentCondition.attr('data-condition', 'false');
            $('#attachment').val(null);
        }
    });
