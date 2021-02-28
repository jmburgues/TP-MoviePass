<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">
<br>
<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Welcome back!</h3>
</div>  

 
<div class="container border p-4 col-md-4 form loginCard" >
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontLogin" method=POST>
      <div class="form-group">
        <strong><label for="userName">Username</label></strong>
        <input type="text" maxlength="20" name="userName" placeholder="Username" id="userName" class="form-control" required>
      </div>
      <div class="form-group mt-5">
      <strong><label for="password">Password</label></strong>
        <input type="password" maxlength="40" name="password" placeholder="********" id="password" class="form-control mb-5" required>
      </div>
      <div>
        <?php if(isset($error)) echo "<p style=\"color:red; text-align:center;\">".$error."</p><br>";?>
      </div>
      <button type="submit" class="btn btn-secondary bg-danger col-md-3 " value="back" onclick="history.back(-1)"> Previous </button> 
      <button type="submit" class="btn btn-primary bg-danger col-md-3 float-right">Login</button>
    </form>
  </div>
</div>
