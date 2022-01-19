<div class="subjects-list">
    <?php if(getSession("role")==1){ ?>
          <p>Course: <?= getSession("course");?></p>
          <br>
          <p><?php print(teachersInfo(getSession("prepared"))); ?></p>
    <?php }else if(getSession("role") == 2){ ?>
        <h3>Welcome Teacher</h3>
        <br>
        <p>Teacher ID: <?= getSession("teacherId");?></p>
        <p>Own Subjects:  <?=teachersSubject(getSession("subjectsName"));?></p>
        <br>
        <table>
            <tr>
                <th>UserName</th>
                <th>Email</th>
            </tr>
            <?php foreach(getSession("students") as $std){ ?>
            <tr>
                <?php echo"<td>".$std['uname']."</td><td>".$std['email']."</td>";?>
            </tr>
            <?php }?>
        </table>
     <?php }else{?>
        <p>Error 404</p>
     <?php }?>  
  </div>