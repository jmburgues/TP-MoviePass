
<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Register:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  

<div class="container border p-4 col-md-4 form" style="background-color:#FFFFFF; margin-top:6%;">
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontRegister" method=POST>
    <div>
        <?php if(isset($error)) echo $error."<br>";?>
    </div>
    <div class="form-group">
        <label for="userName">Username</label>
        <input type="userName" name="userName" id="userName" class="form-control">
      </div>
      <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control">
      </div>
      <div class="form-group">
        <label for="birthDate">Birth Date</label>
        <input type="date" name="birthDate" id="birthDate" class="form-control">
      </div>
      <div class="form-group">
        <label for="dni">DNI</label>
        <input type="number" name="dni" id="dni" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary bg-danger text-dark mt-3 col-md-3">Register</button>
    </form>
  </div>
</div>
