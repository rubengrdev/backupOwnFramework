<?php require('partials/head.php'); ?>


    <div id="login-box">
        <form action="/login/log" method="post">
            <input type="text" placeholder="username"  id="username" name="username"><br>
            <input type="password" placeholder="password" name="password"><br>
            <input type="submit">
        </form>
    </div>
<?php require('partials/footer.php'); ?>
