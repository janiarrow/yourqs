$(function() {
	  // Initialize form validation on the registration form.
	  // It has the name attribute "registration"
	  $("form[name='regform']").validate({
		// Specify validation rules
		rules: {
		  // The key name on the left side is the name attribute
		  // of an input field. Validation rules are defined
		  // on the right side
		  fname: "required",
		  lname: "required",
		  email: {
			required: true,
			// Specify that email should be validated
			// by the built-in "email" rule
			email: true
		  },
		contactnum: {
			required: true,
			number: true
		  },
		  pword: {
			required: true,
			minlength: 5
		  }
		},
		// Specify validation error messages
		messages: {
		  fname: "Please enter your firstname",
		  lname: "Please enter your lastname",
		  pword: {
			required: "Please provide a password",
			minlength: "Your password must be at least 5 characters long"
		  },
		  email: "Please enter a valid email address"
		},
		// Make sure the form is submitted to the destination defined
		// in the "action" attribute of the form when valid
		submitHandler: function(form) {
		  form.submit();
		}
	  });
	});