<link rel="stylesheet" href="<?php echo FRONT_ROOT ?>/Views/css/adminStyle.css">
<div class="container mt-5 mb-5">   
    <div class="card card-body m-5 ">
        <h4 style="display: block; margin-left: auto; margin-right: auto;">Manage user's administrative role:</h4>
    <div>
    <table style="margin-left: auto; margin-right: auto; border:1px solid black;" class="panelOwner">
        <tr style="background-color: orange;">
                <th style="text-align: center;">USER</th>
                <th style="text-align: center;">ACTION</th>
            </tr>
            <?php foreach ($users as $user){
                
                if($user->getRole() != 'owner'){ ?>
            <tr>
                <td style="text-align: center;">
                    <strong><?php echo $user->getUserName();?></strong>
                </td>
            
                <td style="text-align: center;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>User/changeRole/<?php echo $user->getUserName(); ?>" method=GET>
                        <button type="submit" value="<?php echo $user->getUserName();?>" class="btn btn-secondary"><?php if($user->getRole() == 'user') echo "Make Admin"; else echo "Remove Admin";?> </button>
                    </form>
                    </div> 
                </td>
            </tr>
                <?php    }
                                        }
             ?>
            
        </table>
        </div>
    </div>
</div>