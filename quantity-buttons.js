jQuery(document).ready(function($) {
    function handleQuantityChange() {
        $('.quantity').on('click', '.plus, .minus', function() {
            var qty = $(this).closest('.quantity').find('.qty');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));

            if ($(this).hasClass('plus')) {
                if (max && val >= max) {
                    qty.val(max);
                } else {
                    qty.val(val + step);
                }
            } else {
                if (min && val <= min) {
                    qty.val(min);
                } else if (val > 1) {
                    qty.val(val - step);
                }
            }
            qty.trigger('change');
        });
    }

    handleQuantityChange();

    $(document).ajaxComplete(function() {
        handleQuantityChange();
    });
});
