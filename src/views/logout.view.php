<?php require('partials/head.php'); ?>
<!-- En esta página no quiero que aparezca el navegador-->
   <br>
   <p>¿Seguro que quieres cerrar sessión?</p>
    <div id="login-box">
    
        <form action="/logout/des" method="post">
            <input type="submit" value="SI" name="validator" class="logoutbutton">
            <input type="submit" value="NO" name="validator" class="logoutbutton">
        </form>
    </div>
<?php require('partials/footer.php'); ?>