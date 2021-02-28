<!-- background -->
<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/userStyle.css">
<br>
<div class="text-center mt-5 ">    
<h3 class="text-white">Welcome new user!</h3>
</div>  

<div class="container border p-4 col-md-4 form loginCard">
  <div class="abs-center">
    <form action="<?php echo FRONT_ROOT;?>User/frontRegister" method=POST>
      <div class="form-group">
      <strong> <label for="userName">Username</label> </strong>
        <input type="userName" maxlength="20" name="userName" placeholder="Username" id="userName" class="form-control" required>
      </div>
      <div class="form-group">
      <strong> <label for="password">Password</label> </strong>
            <input type="password" maxlength="40" name="password" id="password" placeholder="********" class="form-control" required>
      </div>
      <div class="form-group">
      <strong><label for="email">Email</label></strong>
        <input type="email" maxlength="40" name="email" id="email" placeholder="your-email@example.com" class="form-control" required>
      </div>
      <div class="form-group">
      <strong><label for="birthDate">Birth Date</label></strong>
        <input type="date" name="birthDate" id="birthDate" class="form-control" required>
      </div>
      <div class="form-group">
      <strong><label for="dni">ID</label></strong>
        <input type="number" min=1000000 max=99999999 name="dni" id="dni" placeholder="National Identification Number" class="form-control" required>
      </div>
      <div>
        <?php if(isset($error)) echo "<p style=\"color:red; text-align:center;\">".$error."</p><br>";?>
      </div>

      <button type="submit" class="btn btn-secondary bg-danger float-right col-md-3 mt-3">Register</button>
    
    </form>


        <button type="submit" class="btn btn-secondary bg-danger col-md-3 mt-3" value="back" onclick="history.back(-1)"> Previous </button> 

     

  </div>
</div>
