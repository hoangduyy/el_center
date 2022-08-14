$(document).ready(function () {
    OrderController.init();
});

var OrderController = {
    init: function () {
        $('select[name="status"]').select2({
            allowClear: true
        });
    },
};
