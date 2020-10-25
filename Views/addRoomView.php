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
            </style>


<!--container--><div class="container mt-5" >   
<form  action="<?php echo FRONT_ROOT ?>Room/addRoom" method="POST">
            <?php foreach($rooms as $room){
        
                ?>
                
        <div class="container mb-5 mt-5">   
            <div class="card card-body ">
            <ul>
                <li>Cinema Name: <?php echo $room->getName() ?></li>
                <li>Cinema capacity: <?php echo $room->getCapacity() ?></li>
                <li>Cinema price: <?php echo $room->getPrice() ?></li>
            </ul>
            </div>
            </div>
            <?php
        }?>

        <input type="hidden" class="form-control" name="id" value=<?php echo $idCinema?> >
        <div class="form-group row ">
            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Capacity</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="capacity" placeholder="Capacity" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputDireccion" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" placeholder="Price" required>
            </div>
        </div>
        <button type="submit" name="button" class="btn btn-secondary bg-danger text-black col-2  float-right" >Send</button>
    </form>
<!--container--></div>
<br>


<br>
<br>
<br>
