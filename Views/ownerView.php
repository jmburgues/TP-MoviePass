<?php
    require_once('nav.php');
    require_once('header.php');
    
?>
<!--Estilo de la página-->
<style type="text/css">
    body {
        background-color: white; 
        background-image: none; 
    }
    .list-group{
    max-height: 300px;
    max-width: 800px;
    margin-bottom: 10px;

    overflow-y:auto;

    }
</style>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<div class="panel panel-primary" id="result_panel">
    <div class="panel-heading"><h3 class="panel-title">User List</h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
       
        <?php foreach ($users as $user){
            if($user->getRole() != 'owner'){ ?>

            <li class="list-group-item"><strong><?php echo $user->getUserName();?></strong>
                <div class="btn-group" role="group" aria-label="Basic example">
                        <form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>User/changeRole/<?php echo $user->getUserName(); ?>" method=GET>
                            <button type="submit" value="<?php echo $user->getUserName();?> class="btn btn-secondary" data-toggle="modal" data-target="exampleModal"><?php if($user->getRole() == 'user') echo "Make Admin"; else echo "Remove Admin";?> </button>
                        </form>
                </div> 
                
                
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
            </div>
        <?php } 
            } ?>
           
        </ul>
    </div>
</div>