<div id="profile">
    
    <p>Name: <?= getSession("uname")?></p>
    <p>Email: <?= getSession("mail")?> </p>
    <p>Id: <?=getSession("id")?></p>
    <p>Role: <?php if(getSession("role") == 1){echo"Student";}elseif(getSession("role") == 2){echo"teacher";}elseif(getSession("role" == 3)){echo "admin";}else{echo"error404";}?></p>
    <br>

    <a href="/pages/logout/"><div class="logout_button">
        <p class="textLogout">Logout</p>
    </div></a>
</div>