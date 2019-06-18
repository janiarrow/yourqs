<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
<!--	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
/*
    body {
      display: flex;
      align-items: center;
      min-height: 24em;
      justify-content: center;
    }
*/
  </style>
</head>
<body>

<div class="container">

  <form>
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="input3">First name</label>
        <input type="text" class="form-control" id="input2" placeholder="First name" value="Mark" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="input2">Last name</label>
        <input type="text" class="form-control" id="input3" placeholder="Last name" value="Otto" required>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit form</button>
  </form>


</div>


<script src="../dist/bootstrap-validate.js"></script>
<script>
  // Basic Example
  bootstrapValidate(['#input2', '#input3'], 'required:Please enter input');
</script>
</body>
</html>
