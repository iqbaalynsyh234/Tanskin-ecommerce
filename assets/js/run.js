$(window).scroll(function(){
  if($(window).scrollTop() >= 150){
    $('.head-nav-top, .form-search-head').addClass('out');
  }
  if($(window).scrollTop() < 150){
    $('.head-nav-top, .form-search-head').removeClass('out'); 
  }
});

$(function(){
  $('.search-icon-nav').on('click', function(){
    $('.form-search-head').toggleClass('opened');
  });

  $('body').on('click', '.btn-nav-btn', function(){
  	$(this).toggleClass('show');
    $('#menu-nav-mob').toggleClass('active');
    $('body').toggleClass('overhide');
  });

  $('body').on('click', '.menu-one .drop-down', function(){
    $(this).toggleClass('active');
  });

});