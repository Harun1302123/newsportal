jQuery(document).ready(function ($) {

    $(".dropdown").hover(function(){
        let dropdownMenu = $(this).children(".dropdown-menu");
        if(dropdownMenu.is(":visible")){
            dropdownMenu.parent().toggleClass("open");
        }
    });
    $(".nfis-lang-btn").click(function() {
        $(this).toggleClass('toggle-left');

        let value = $(this).attr('data-myvalue');
        if (value.trim() === 'en') {
            setTimeout(function(){document.location.href = "/locale/bn";},100);
        } else {
            setTimeout(function(){document.location.href = "/locale/en";},100);
        }
        return;
    });

    $(".nav-tabs li.nav-item a.nav-link").click(function() {
        $(".nav-tabs li.nav-item a.nav-link").removeClass('active');
    });

    const pageTabMenuItem = $(".sdg-tab-menu .sdg-tab-navber a.sdg-tab-link");
    pageTabMenuItem.click(function() {
        pageTabMenuItem.removeClass('active');
    });

});

/**
 * Top Sidebar
 */
(function ($){
    "use strict";

    function sdgTopSearch(){
        var sdgSrcBtnIcon = $(".topBtnSrc");
        var sdgSrcContentainer = $("#searchOuter");
        var sdgSrcContentClose = $(".sdgSrcClose");

        sdgSrcBtnIcon.on('click', function () {
            sdgSrcContentainer.toggleClass('sdgSrcOpen');
            $('body').toggleClass('scrollOff');
            console.log('Clicked Src')
        });

        sdgSrcContentClose.on('click', function () {
            sdgSrcContentainer.toggleClass('sdgSrcOpen');
            $('body').toggleClass('scrollOff');
        });

        $(document).keyup(function (e) {
            if ( sdgSrcContentainer.hasClass('sdgSrcOpen') && e.keyCode === 27 ) {
                sdgSrcContentainer.removeClass('sdgSrcOpen');
                $('body').removeClass('scrollOff');
            }
        });
    }
    sdgTopSearch();

})(jQuery);


(function($) {
    $('a.smoothScroll').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
})(jQuery);


function loadOptions(parentId, parentValue, childId, actionUrl, placeholder) {
    if (parentValue !== '') {
        $("#" + parentId).after('<span class="loading_data">Loading...</span>');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: {
                condition_id: parentValue,
                _token : $('input[name="_token"]').val()
            },
            success: function (response) {
                var option = '<option value="">Select One</option>';
                if (placeholder) {
                    option = placeholder;
                }
                if (response.responseCode == 1) {
                    $.each(response.data, function (id, value) {
                        option += '<option value="' + id + '">' + value + '</option>';
                    });
                }
                $("#" + childId).html(option);
                $("#" + parentId).next().hide('slow');
            }
        });
    } else {
        alert('Please select one');
    }
}

$(".nav-tabs li.nav-item a.nav-link").click(function() {
    $(this).closest('.nav-tabs').find('a.nav-link').removeClass('active');
    // $(".nav-tabs li.nav-item a.nav-link").removeClass('active');
});
