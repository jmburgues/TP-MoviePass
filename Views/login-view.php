<!--Estilo de la página-->
<style type="text/css">
            body {
                background-color: white; 
                    
            }
            </style>


 
<div class="container border p-4 col-md-4 form" style="background-color:#FFFFFF; margin-top:6%;">
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
