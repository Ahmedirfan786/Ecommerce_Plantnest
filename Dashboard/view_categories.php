<?php
include('header.php');
?>

            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row bg-light mx-0">
                    <div class="col-md-12 p-4 mb-3">
                        <h3 class="mb-3">View Categories</h3>

                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="colspna-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <!-- Category data fetch query -->
                                    <?php
                                    $query=$pdo->prepare('select * from categories');
                                    $query->execute();
                                    $data=$query->fetchAll(PDO::FETCH_ASSOC);
                                    if($data){
                                      foreach($data as $catdata){
                                    ?>
                                    <tr>
                                        <td><?php echo $catdata['category_id']?></td>
                                        <td><?php echo $catdata['name']?></td>
                                        <td class="text-center">
                                          <img src="img/categoryimages/<?php echo $catdata['image'] ?>" widtd="80px" height="80px" alt="">
                                        </td>
                                        <td>
                                          <a href="view_categorydata.php?category_id=<?php echo $catdata['category_id'] ?>" class="text-white">
                                              <button class="btn btn-primary">  
                                                View
                                              </button>
                                            </a>
                    
                                          <a href="edit_category.php?catid=<?php echo $catdata['category_id'] ?>" class="text-dark">
                                          <button class="btn btn-warning">
                                            Edit
                                          </button>
                                          </a>
                                            
                                            <!-- Applying condition if category status is enabled or disbled -->
                                            <?php
                                           if($catdata['status'] == 1){
                                             ?>
                                              <a href="Code.php?discat_id=<?php echo $catdata['category_id']?>" class="text-white">
                                                <button class="btn btn-danger">
                                              Disable
                                            </button>
                                            </a>
                                             <?php
                                            }
                                            else if($catdata['status'] == 0){
                                              ?>
                                              <a href="Code.php?enbcat_id=<?php echo $catdata['category_id']?>" class="text-white">
                                                <button class="btn btn-success">
                                                Enable
                                              </button>
                                              </a>
                                             <?php
                                           }
                                           ?>


                                        <a href="Code.php?delcatid=<?php echo $catdata['category_id'] ?>" class="text-white">
                                          <button class="btn btn-dark">
                                            Delete
                                          </button>
                                        </a>

                                        </td>
                                    </tr>
                                    <?php
                                    }
                                  }
                                  else {
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No Categories are there</td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                       
                    </div>
                </div>
            </div>
            <!-- Blank End -->


<?php
include('footer.php');
?>