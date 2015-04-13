$(document).ready(function () {
    var $confirmPopover = $('.delete-confirm-popover');

    $confirmPopover.popover({
        container: 'body',
        content:   '<a href="" class="btn btn-xs btn-primary popover-go">Да</a> <button class="btn btn-xs btn-default popover-cancel">Отмена</button>',
        html:      true,
        placement: 'left',
        template:  '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title">Вы уверены?</h3><div class="popover-content"></div></div>'
    }).on('shown.bs.popover', function (e) {
        var $popover = $('.popover'),
            $popoverGo = $popover.find('.popover-go'),
            $popoverCancel = $popover.find('.popover-cancel');

        $popoverGo.attr('href', $(e.target).attr('data-delete-url'));

        $popoverGo.click(function () {
            $confirmPopover.popover('hide');
        });

        $popoverCancel.click(function () {
            $confirmPopover.popover('hide');
        });
    });

    $confirmPopover.click(function () {
        var $current = $(this);

        $confirmPopover.each(function () {
            if ($(this).get(0) !== $current.get(0)) {
                $(this).popover('hide');
            }
        });
    });
});