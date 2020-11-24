<div class="container mt-5 mb-5">   
    <div class="card card-body m-1 ">
        <h4>Manage user's administrative role:</h4>
<table class="panelOwner">
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
                <?php }else{?>
                <td> <strong><?php echo $user->getUserName();?></strong>  </td>
            <?php
                            }
                                        }
             ?>
            
        </table></div>
    </div>
</div>