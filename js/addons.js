$(document).ready(function () {
    jQuery(document).ready(function () {
        $('input[name="extra[]"]').on('input', function () {
            updateSum();
        });

        // Update sum if user click input
        $("input").click(function(){
            updateSum();
        });

        // Calculates the total in addons
        $(".add").click(function () {
            var $button = $(this);
            // Find input field next to incremental buttons
            var $input = $button.closest('.parentDiv').find('.extraValue');
            var inputValue = parseInt($input.val(), 10);

            // Increment input value
            if ($button.val() == "plus") {
                if ($input.val() < 20) {
                    inputValue++;
                }
            }
            // Decrement input value
            else {
                if (inputValue > 0) {
                    inputValue--;
                }
            }
            $input.val(inputValue);
            updateSum();
        });

        // Update current sum
        function updateSum() {
            var sum = 0;
            var id = 0;
            // Get prices for each extra product
            $('input[name="extra[]"]').each(function (index, element) {
                id = parseInt($(element).attr("id"), 10);
                sum += ($(element).val() * id);
            });

            // Get price for current dinner
            var inputBag = $('input[name="currentBagAmount"]');
            id = parseInt($(inputBag).attr("id"),10);
            sum += ($(inputBag).val()*id);

            $('#extraProductPrice').text(sum);
            // Update input field
            $('#extraProductPriceInput').val(sum);
        }
        updateSum();

    });
});



