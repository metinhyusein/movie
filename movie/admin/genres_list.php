<?php
require_once 'header.php';



$sql = "SELECT
          `id`,
          `name`,
          `added`,
          `modified`
          FROM `".TABLE_GENRES."`
          WHERE 1
";
$result = mysqli_query($conn, $sql);
        

if ($count = mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_assoc($result)) {
            $genres[] = $row;
        }
  $count = count($genres);
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
            <button><a href="genres_add.php">Add genre</a></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <form action="" method="get">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Added</th>
                      <th>Modified</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Added</th>
                      <th>Modified</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php for ($i=0; $i < $count; $i++):?>
                      <tr>
                        <td><?=$genres[$i]['id']?></td>
                        <td><?=$genres[$i]['name']?></td>
                        <td><?=$genres[$i]['added']?></td>
                        <td><?=$genres[$i]['modified']?></td>
                        <td>
                          <a href="genres_edit.php?id=<?php echo $genres[$i]['id']; ?>">Edit</a>
                          <a href="genres_delete.php?id=<?php echo $genres[$i]['id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                      </tr>
                    <?php endfor?>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
      <!-- /.container-fluid -->


<?php
require_once 'footer.php';
?>