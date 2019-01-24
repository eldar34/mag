/*price range*/


 $('#sl2').slider();





	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

	function getCart(){
		$.ajax({
                url: 'cart/show',
                type: 'GET',
                success: function(res){
                    if(!res) alert('Ошибка!');
                    //console.log(res);
                    showCart(res);
                },
                error: function(){
                   alert('ERROR');   
                }
            });
		return false;
	}

	function showCart(cart){
		$('#cart .modal-body').html(cart);
		$('#cart').modal();
	}

	$('#cart .modal-body').on('click', '.del-item', function(){
		var id = $(this).data('id');
		 $.ajax({
                url: 'cart/del-item',
                data: {id: id},
                type: 'GET',
                success: function(res){
                    if(!res) alert('Ошибка!');
                    //console.log(res);
                    showCart(res);
                },
                error: function(){
                   alert('ERROR');   
                }
            });

	});

	function clearCart(){

		 $.ajax({
                url: 'cart/clear',
                type: 'GET',
                success: function(res){
                    if(!res) alert('Ошибка!');
                    //console.log(res);
                    showCart(res);
                },
                error: function(){
                   alert('ERROR');   
                }
            });

	}

	$('.add-to-cart').on('click', function(e){
            e.preventDefault();
            
            var id = $(this).data('id');

            var IdForColor = "c" + id;
            var color = $("#" + IdForColor + " option:selected").text();

            var IdForSize = "s" + id;
            var size = $("#" + IdForSize + " option:selected").text();

            //console.log(color);
            //console.log(size);

            if(color != "Select Color" && size != "Select Size")
            {
                $.ajax({
                    url: 'cart/add',
                    data: {id: id, color: color, size: size},
                    type: 'GET',
                    success: function(res){
                        if(!res) alert('Ошибка!');
                        //console.log(res);
                        showCart(res);
                    },
                    error: function(){
                        alert('ERROR');
                    }
                });
            }else{
                console.log('Hello');
            }
            

            
        });


		
/*scroll to top*/

$(document).ready(function(){
	$(function () {

        jQuery('.catalog').dcAccordion({
            speed: 350
        });

		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});


