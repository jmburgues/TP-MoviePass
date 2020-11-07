<div class="text-center mt-5 mb-3">
    <h3 class="text-white">Login:</h3>
    <button type="submit" class="btn btn-secondary bg-danger text-black mt-3" value="back" onclick="window.location.href='<?php echo FRONT_ROOT?>index.php'"> Go Back </button> 
</div>  

 
<div class="container border p-4 col-md-4 form loginCard" >
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontLogin" method=POST>
      <div class="form-group">
        <label for="userName">User</label>
        <input type="text" name="userName" id="userName" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <div>
        <?php if(isset($error)) echo $error;?>
      </div>
      <button type="submit" class="btn btn-primary bg-danger text-dark mt-3 col-md-3">Login</button>
    </form>
  </div>
</div>
