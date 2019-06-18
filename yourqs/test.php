<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="test1.js"></script>

<h2>Example 2:</h2>
<div class="container">
  <h2>Registration</h2>
  <form action="" name="registration">

    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" placeholder="John"/>

    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" placeholder="Doe"/>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="john@doe.com"/>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"/>

    <button type="submit">Register</button>

  </form>
</div>

<script>
$('form[id="second_form"]').validate({
  rules: {
    fname: 'required',
    lname: 'required',
    user_email: {
      required: true,
      email: true,
    },
    psword: {
      required: true,
      minlength: 8,
    }
  },
  messages: {
    fname: 'This field is required',
    lname: 'This field is required',
    user_email: 'Enter a valid email',
    psword: {
      minlength: 'Password must be at least 8 characters long'
    }
  },
  submitHandler: function(form) {
    form.submit();
  }
});
</script>