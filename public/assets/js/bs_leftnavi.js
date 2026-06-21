$(document).ready(function () {
    var nav = function () {
        $('.gw-nav > li > a').click(function () {
            var gw_nav = $('.gw-nav');
            gw_nav.find('li').removeClass('active');
            $('.gw-nav > li > ul > li').removeClass('active');

            var checkElement = $(this).parent();
            checkElement.addClass('active');
            gw_nav.find('li').find('ul:visible').slideUp(220);
            gw_nav.find('.gw-submenu-toggle').attr('aria-expanded', 'false');
        });

        $('.gw-submenu-toggle').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            var toggle = $(this);
            var checkElement = toggle.closest('li.subm');
            var submenu = checkElement.children('.gw-submenu');
            var isOpen = submenu.is(':visible');
            var gw_nav = $('.gw-nav');

            gw_nav.find('li.subm').not(checkElement).removeClass('active arrow-up').addClass('arrow-down')
                .children('.gw-submenu:visible').slideUp(220);
            gw_nav.find('.gw-submenu-toggle').not(toggle).attr('aria-expanded', 'false');

            checkElement.toggleClass('active arrow-up', !isOpen).toggleClass('arrow-down', isOpen);
            toggle.attr('aria-expanded', String(!isOpen));
            submenu.stop(true, true)[isOpen ? 'slideUp' : 'slideDown'](220);
        });
        $('.gw-nav > li > ul > li > a').click(function () {
            $(this).parent().parent().parent().removeClass('active');
            $('.gw-nav > li > ul > li').removeClass('active');
            $(this).parent().addClass('active')
        });
    };
    nav();
});
