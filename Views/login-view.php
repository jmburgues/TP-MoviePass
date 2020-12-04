<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Welcome back!</h3>
</div>  

 
<div class="container border p-4 col-md-4 form loginCard" style="margin-top:0px;">
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontLogin" method=POST>
      <div class="form-group">
        <label for="userName">User</label>
        <input type="text" maxlength="20" name="userName" id="userName" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" maxlength="40" name="password" id="password" class="form-control" required>
      </div>
      <div>
        <?php if(isset($error)) echo "<p style=\"color:red; text-align:center;\">".$error."</p><br>";?>
      </div>
      <div style="float: right; padding:10px;">
        <button type="submit" class="btn btn-primary bg-danger text-dark mt-3">Login</button>
      </div>
    </form>

    <div style="float: left; padding:10px;">
        <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="history.back(-1)"> Previous </button> 
    </div>
  </div>
</div>
