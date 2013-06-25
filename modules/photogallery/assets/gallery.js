//jquery code below is applicable for the photo stack only . Not for the single image zoom effect
$(document).ready(function() { 
$(".image_stack").delegate('img', 'mouseenter', function() {//when user hover mouse on image with div id=stackphotos 
		if ($(this).hasClass('stackphotos')) {//
		// the class stackphotos is not really defined in css , it is only assigned to each images in the photo stack to trigger the mouseover effect on  these photos only 
			
			var parent = $(this).parent().parent();
			parent.find('.photo1').addClass('rotate1').css("left","50px");//add class rotate1,rotate2,rotate3 to each image so that it rotates to the correct degree in the correct direction ( 15 degrees one to the left , one to the right ! )
			parent.find('.photo2').addClass('rotate2');
			parent.find('.photo3').addClass('rotate3').css("left","-50px");



		}
	})
	.delegate('img', 'mouseleave', function() {// when user removes cursor from the image stack
		$('.photo1').removeClass('rotate1');// remove the css class that was previously added to make it to its original position
		$('.photo2').removeClass('rotate2');
		$('.photo3').removeClass('rotate3');
		$('.photo1').css("left","");// remove the css property 'left' value from the dom
		$('.photo3').css("left","");
		
	});;
});
