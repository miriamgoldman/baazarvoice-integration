( function ( $ ) {
    let bv_environment = "/static";
    if( bvSettings.bv_environment == 'staging' ) {
        bv_environment = "/bvstaging" + bv_environment;
    }
    let bvapiUrl = window.location.protocol + "//display.ugc.bazaarvoice.com" + bv_environment + "/" + bvSettings.bv_site + "/en_US/bvapi.js";

    let BaazarVoiceDOM = function () {
        return {
            dom_changes: function () {
                $('.bv-write-review').html('Write a Review');
                console.log( $('.bv-write-review') );
                let verified_badge = $('.bv-trustmarkIcon');
                verified_badge.remove();
                $('.bv-action-bar').prepend(verified_badge);
                $('.bv-header').append('<div class="divider"></div>');
                // move the title of the review above the stars.
                let reviews = $('.bv-content-container');
                reviews.each(function(i){
                    let review = $(this);
                    let review_title = review.find('.bv-content-title-container');
                    let review_meta = review.find('.bv-content-header-meta');
                    review_title.remove();
                    review_title.insertBefore(review_meta);
                });
            }
        }
    };

    
    
    window.loadBazaarvoiceApi = function(callback) {
        if (window.$BV) {
            callback();
        } else {
            $.ajax({
                url: bvapiUrl,
                cache: true,
                dataType: "script",
                success: function() {
                    $($BV.docReady);
                    callback();
                }
            });
        }

 
    };

    let product_id = $('article').data('product-sku');
    get_reviews_api(product_id);
    
    function get_reviews_api(product_id) {
      loadBazaarvoiceApi(function() {
        $BV.configure('global', { productId : product_id });
         $BV.ui("rr", "show_reviews", { productId: product_id });
         setTimeout(function(){
            let change_dom = new BaazarVoiceDOM();
            change_dom.dom_changes();
         },800);
     });

     
     
        
    }

    $('.btn--variation').click(function(){
        let bazaarvoice_id = $(this).data('bvid');
        get_reviews_api( bazaarvoice_id );
    });




}) ( jQuery );