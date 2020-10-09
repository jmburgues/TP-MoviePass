<?php
require_once('header.php');
    require_once('nav.php');
?>
<!--Estilo de la página-->
<style type="text/css">
            body {
                background-color: white; 
                    
            }
            </style>


 
<div class="container border p-4 col-md-4 form" style="background-color:#FFFFFF; margin-top:6%;">
  <div class="abs-center">
    <form action="#" class="">
      <div class="form-group">
        <label for="userName">Email</label>
        <input type="text" name="userName" id="userName" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary bg-danger text-dark mt-3 col-md-3">Login</button>
    </form>
  </div>
</div>
