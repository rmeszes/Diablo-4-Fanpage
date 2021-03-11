$(function () {
    if ( $(window).scrollTop() > 10 ) {
        $('.navbar').addClass('active');
    }
    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > 10 ) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });
});
$(function() {
    $(".navbar-toggler").click(function() {
      $(".navbar-toggler").toggleClass('rotate-90');
    });
  });