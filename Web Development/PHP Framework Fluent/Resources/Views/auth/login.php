

<h1>Login FOrm</h1>
<form action="login" method="post">
    <input type="text" name="email" id="">
    <input type="text" name="password" id="">
    <input type="submit" value="Submit">
</form>
<?php
foreach($errors as $error) {
    ?>
    <h2><?php echo $error ?></h2>

    <?php
}
?>