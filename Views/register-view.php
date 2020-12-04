
<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Welcome new user!</h3>
</div>  

<div class="container border p-4 col-md-4 form loginCard" style="margin-top:0px;">
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontRegister" method=POST>
      <div class="form-group">
        <label for="userName">Username</label>
        <input type="userName" maxlength="20" name="userName" id="userName" class="form-control" required>
      </div>
      <div class="form-group">
            <label for="password">Password</label>
            <input type="password" maxlength="40" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" maxlength="40" name="email" id="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="birthDate">Birth Date</label>
        <input type="date" name="birthDate" id="birthDate" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="dni">DNI</label>
        <input type="number" name="dni" id="dni" class="form-control" required>
      </div>
      <div>
        <?php if(isset($error)) echo "<p style=\"color:red; text-align:center;\">".$error."</p><br>";?>
      </div>
      <div style="float: right; padding:10px;">
      <button type="submit" class="btn btn-secondary bg-danger text-black mt-3">Register</button>
      </div>
    </form>

      <div style="float: left; padding:10px;">
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="history.back(-1)"> Previous </button> 
      </div>
     

  </div>
</div>
