<?php
require_once 'header.php';

$id = $_GET['id'];
$errors = [];

$sql = "SELECT
          `id`,
          `name`,
          `added`,
          `modified`
          FROM `".TABLE_GENRES."`
          WHERE `id` = '" . mysqli_real_escape_string($conn, $id) . "'
";

$result = mysqli_query($conn, $sql);
$genre = mysqli_fetch_assoc($result);

$newGenre = isset($_POST['genre']) ? trim($_POST['genre']) : '';

if (isset($_POST['submit'])) {
  
  if ($newGenre) {
    $sql = "SELECT
        `name`
        FROM `".TABLE_GENRES."`
        WHERE `name` = '".mysqli_real_escape_string($conn, $newGenre)."'
    ";

    $result = (mysqli_query($conn, $sql));
    if (mysqli_num_rows($result)) {
    $errors[] = 'Genre exist in database';
    }

  }else {
    $errors[] = 'Please enter genre name';
  }

  if (!count($errors)) {
    $sql = "UPDATE `".TABLE_GENRES."`
            SET 
            `name` = '".mysqli_real_escape_string($conn, $newGenre)."',
            `modified` = NOW()
            WHERE `id` = '".mysqli_real_escape_string($conn, $id)."'
    ";
    
    if (mysqli_query($conn, $sql)) {
      echo 'Successfully added';
    }else {
      $errors[] = 'Somethin gone wrong';
    }
  }

}



?>

<div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Edit genre
            <button><a href="genres_list.php">Genres list</a></button>
            <button><a href="genres_add.php">Add genre</a></button>
          </div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" name="genre" value="<?=$genre['name']?>" style="width: 25%">
                </div>
              </div>
              
              <button type="submit" name="submit"  class="btn btn-primary btn-block" style="width: 25%">Update</button>

              <div class="alert alert-danger" style="width: 25%">
                <ul>
                  <?php if(isset($errors) && count($errors)):?>
                    <?php for ($i=0; $i < count($errors); $i++):?>
                      <li><?=$errors[$i]?></li>
                    <?php endfor?>
                  <?php endif?>
                </ul>
              </div>

            </form>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
      <!-- /.container-fluid -->


<?php
require_once 'footer.php';
?>