<?php
    include "Views/includes/header.php";

    $post = $this->post;
    if($post) {
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

    <hr>
    <?php
    }
    else {
    ?>
    <h1>Post is not found</h1>
    <?php } ?>

<?php include "Views/includes/footer.php"; ?>