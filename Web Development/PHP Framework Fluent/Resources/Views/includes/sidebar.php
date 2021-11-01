<?php

?>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                    <?php
                        $categories_chunks = array_chunk($this->categories, 4);
                        foreach($categories_chunks as $categories) {
                        ?>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                        <?php
                            foreach($categories as $category) {
                        ?>
                                <li><a href='#'><?php echo $category->name; ?></a>
                                </li>
                        <?php
                            }
                        ?>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- /.col-lg-6 -->
                        
                            
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>