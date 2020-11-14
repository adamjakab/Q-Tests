/**
 * Test
 **/

queueViewModel.pageReady(function(data) {
    console.log("QIT-VM");
});

window.addEventListener('load', function () {
    console.log("WIN");
});

(function($) {
    console.log("ANON");
    $(document).ready(function() {
        console.log("JQ READY");
    });
})(jQuery);

