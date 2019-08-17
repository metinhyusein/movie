<?php
require_once 'header.php';

$genre = isset($_POST['genre']) ? trim($_POST['genre']) : '';
$errors = [];

if (isset($_POST['submit'])) {
  
  if ($genre) {
    $sql = "SELECT
        `name`
        FROM `".TABLE_GENRES."`
        WHERE `name` = '".mysqli_real_escape_string($conn, $genre)."'
    ";
    $result = (mysqli_query($conn, $sql));
    if (mysqli_num_rows($result)) {
    $errors[] = 'Genre exist in database';
    }

  }else {
    $errors[] = 'Please enter genre name';
  }

  if (!count($errors)) {
    $sql = "INSERT INTO `".TABLE_GENRES."`(
                        `name`,
                        `added`,
                        `modified`
                      )VALUES(
                        '".mysqli_real_escape_string($conn, $genre)."',
                        NOW(),
                        NOW()
                      )
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
            Genres list
            <button><a href="genres_list.php">Genre list</a></button>
          </div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" name="genre" placeholder="Genre" style="width: 25%">
                </div>
              </div>
              
              <button type="submit" name="submit"  class="btn btn-primary btn-block" style="width: 25%">Add</button>

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