jQuery(document).ready(function( $ ) {

  console.log('assets/js/scripts.js');
  if ( $('.caldera-form-page').length) {
    console.log('success');
    $('.caldera-grid').fadeIn(1500);
    $('.caldera-form-page').addClass('animated slideInRight');
    $( '.breadcrumb' ).before( '<div class="breadcrumb-text"></div>');
    var breadcrumb = $('.breadcrumb').clone();
    $('.breadcrumb-text').append( breadcrumb );
  }
});
