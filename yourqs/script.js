$(function() {
	
	$("form[name='proform']").validate({
	
	    rules: {
			
	      street: "required",
	      suburb: "required",
			city: "required",
		comment: "required",
		  
		  
		  sitesign: "required",
		  ppe: "required",
		  hns: "required",
		  firstaid: "required"
			
			
			 },
		 messages: {
		  street: "Please enter your street",
		  suburb: "Please enter your suburb",
		  city: "Please provide a city",
		  comment: "Please enter comment"
		},
			
		// Make sure the form is submitted to the destination defined
		// in the "action" attribute of the form when valid
		submitHandler: function(form) {
		  form.submit();
		 }
  });
});
			
//			sfcomment: {
//	        required: true,
//	       required: true
//	      },
//			
//			
//			builder: {
//	        required: true,
//	       digits: true
//	      },
//			
//			bhour: {
//	        required: true,
//	       digits: true
//	      },
//			supervision: {
//	        required: true,
//	       digits: true
//	      },
//			shour: {
//	        required: true,
//	       digits: true
//	      },
//			adminisration: {
//	        required: true,
//	       digits: true
//	      },
//			ahour: {
//	        required: true,
//	       digits: true
//	      },
//			travel: {
//	        required: true,
//	       digits: true
//	      },
//			trate: {
//	        required: true,
//	       digits: true
//	      },
//			
//			  toilet: "required",
//			
//			recovery: {
//	        required: true,
//	       digits: true
//	      },
//			
//	    },
//			highlight: function(element) {
//				$(element).closest('.control-group').removeClass('success').addClass('error');
//			},
//			success: function(element) {
//				element
//				.text('OK!').addClass('valid')
//				.closest('.control-group').removeClass('error').addClass('success');
//			}
//	  });
//
//}); // end document.ready