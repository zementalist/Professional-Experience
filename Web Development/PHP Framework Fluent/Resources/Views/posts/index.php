<?php
    $posts = $this->posts;

    foreach ($posts as $post) {
?>
    
    <h2>
        <a href="#"><?php echo $post->title ?></a>
    </h2>
    <p class="lead">
        by <a href="index.php"><?php echo $post->author; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post->created_at ?></p>
    <hr>
    <img class="img-responsive" src="<?php echo $post->image; ?>" alt="">
    <hr>
    <p><?php echo $post->content; ?></p>
    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

<?php } ?>
    <hr>

                