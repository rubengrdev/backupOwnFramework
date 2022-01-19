<?php require('partials/head.php'); ?>

<div id="login-box">
        <form action="/register/reg" method="post">
            <input type="text" placeholder="username"  id="username" name="username"><br>
            <input type="text" placeholder="mail"  id="username" name="mail"><br>
            <input type="password" placeholder="password" name="password"><br>
            <input type="number" placeholder="course" name="course"><br>
            <input type="submit">
        </form>
</div>

<?php require('partials/footer.php'); ?>