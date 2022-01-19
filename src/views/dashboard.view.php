<!-- Antes de entrar a la vista usamos el comprobador-->
<?php checkLogin()?>
<?php require('partials/head.php'); ?>
<?php require('partials/menu.php'); ?>
<!-- Requereimos el bloque del perfil -->
<?php require('partials/profile.php'); ?>


<div id="main">
  <?php if(getSession("role") != 3){ ?>
  <?php require('partials/generateliststasks.php');?>
  <?php require('partials/lists.php'); ?>
  <?php require ('partials/subjects.php');?>
  <script src="/public/tasks.js"></script>
  <?php }else{  ?>
    <div id="administration">
    <form id="adminstrationform">
      <input class="adminformbuttons" type="button" value="users">
      <input class="adminformbuttons" type="button" value="students">
      <input class="adminformbuttons" type="button" value="teachers">
      <input class="adminformbuttons" type="button" value="subject admin">
      <input class="adminformbuttons" type="button" value="matriculation">
    </form>
    <span class="adminspawn"></span>
    <?php require('partials/adminusers.php');?>
    <?php require('partials/adminstudents.php');?>
    <?php require('partials/adminteachers.php');?>
    <?php require('partials/adminsubjects.php');?>
    <?php require('partials/adminmatriculation.php');?>
    </div>
    <script src="/public/addteacher.js"></script>
    <script src="/public/selectedUpdateDelete.js"></script>
    <script src="/public/adminbuttons.js"></script>
  <?php } ?>
</div>
<?php require('partials/footer.php'); ?>

