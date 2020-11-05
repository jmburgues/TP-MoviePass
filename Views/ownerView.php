<!--Estilo de la página-->
<style type="text/css">
    body {
        background-color: white; 
        background-image: none; 
    }
</style>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<div class="panel panel-primary" id="result_panel">
    <div class="panel-heading"><h3 class="panel-title">Manage user administrative role:</h3>
    </div>
    <div class="panel-body">      
        <table style="width: 50%">
           <tr>
                <th>USER</th>
                <th>ACTION</th>
            </tr>
            
            <?php foreach ($users as $user){
                if($user->getRole() != 'owner'){ ?>
            <tr>
                <td>
                    <strong><?php echo $user->getUserName();?></strong>
                </td>
            
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>User/changeRole/<?php echo $user->getUserName(); ?>" method=GET>
                        <button type="submit" value="<?php echo $user->getUserName();?>" class="btn btn-secondary"><?php if($user->getRole() == 'user') echo "Make Admin"; else echo "Remove Admin";?> </button>
                    </form>
                    </div> 
                </td>
            </tr>
                <?php } } ?>
            
        </table>
    </div>
</div>