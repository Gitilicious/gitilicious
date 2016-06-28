/**
 * Floating header
 */
(function($) {
    'use strict';

    var isFloating = false;

    function enableFloating() {
        if (isFloating) return;

        isFloating = true;

        var $floatingHeader = $('.subheader').clone(true);

        $floatingHeader.addClass('floating');

        $('.subheader').parent().prepend($floatingHeader);
    }

    function disableFloating() {
        if (!isFloating) return;

        isFloating = false;

        $('.subheader.floating').remove();
    }

    $(window).on('scroll', function() {
        //noinspection JSValidateTypes
        var navbarHeight   = $('.navbar').outerHeight();
        //noinspection JSValidateTypes
        var scrollPosition = $(window).scrollTop();

        if (scrollPosition > navbarHeight) {
            enableFloating();
        } else {
            disableFloating();
        }
    });
}(jQuery));

/**
 * Preflight installation check
 */
(function($) {

}(jQuery));
