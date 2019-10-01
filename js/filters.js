jQuery(document).ready(function( $ ) {

  console.log('assets/js/filters.js');
  if ( $('#search_keywords').length) {
    console.log('success');
    $("<select />").appendTo(".search-field-wrapper");

    // Create default option "Go to..."
    $("<option />", {
       "selected": "selected",
       "value"   : "",
       "text"    : "Projektsuche nach"
    }).appendTo(".search-field-wrapper select");
    // Populate dropdown with menu items
    $("#menu-search-menu a").each(function() {
     var el = $(this);
     if ( el.closest(".sub-menu").length > 0 ) {
       $('<option />', {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo(".search-field-wrapper select").addClass('level-1');
     }
     else {
       $("<optgroup />", {
           // "value"   : el.attr("href"),
           "label"    : el.text(),
           // "disabled": true
       }).appendTo(".search-field-wrapper select").addClass('level-0');
     }

     $('.search-field-wrapper select').on('change', function () {
         var url = $(this).val(); // get selected value
         if (url) { // require a URL
             window.location = url; // redirect
         }
         return false;
     });

});
  }
  if ( $('.chosen-results').length) {
    console.log('success');
    $( "#search_categories_chosen" ).click(function() {
      $('.level-0').removeAttr( "data-option-array-index" ).removeClass('active-result');
      $('.level-0').unbind("click");
    });
  }
    if ( $('.custom_widget_front_page_listing_cards').length) {
        if ( $('.custom_widget_front_page_listing_cards .grid__item').length > 3) {

            $('.grid__item--widget').slice(0,3).addClass('active');

            $('.custom_widget_front_page_listing_cards .next').on('click', function() {

                $('.custom-grid .active').first().removeClass('active');
                $('.custom-grid .active').last().next().addClass('active');
                $('.grid__item--widget').first().appendTo('.custom-grid');

            });

            $('.custom_widget_front_page_listing_cards .prev').on('click', function() {

                $('.grid__item--widget').last().prependTo('.custom-grid');
                $('.custom-grid .active').last().removeClass('active');
                $('.custom-grid .active').first().prev().addClass('active');

            });
        } else if($('.custom_widget_front_page_listing_cards .grid__item').length) {
            $('.grid__item--widget').slice(0,3).addClass('active');
            $('.slider-button span').hide();
        } else {
            $('.related-projects').hide();
        }
    }
  if ( $('.search_jobs--frontpage').length ) {
      $('.search-field-wrapper input').focus(function() {
            $(this).attr('placeholder', 'Suchbegriff eingeben oder aus Liste wählen')
        }).blur(function() {
            $(this).attr('placeholder', 'Projektsuche')
        })
  }
});
