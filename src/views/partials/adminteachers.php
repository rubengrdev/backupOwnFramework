
    <div class="teachersadmin">
    <form action="/admin/adt" method="post" id="formData">

    <div class="organize">
    <label>Add</label>
    <input type="radio" name="userselect" value="update" class="optionteacher">
    <label>Delete</label>
    <input type="radio" name="userselect" value="delete">
    <br>
    
    <input type="text" name="id" placeholder="id">
    <div class="addteacher">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="userid" placeholder="user id">
    <input type="text" name="desc" placeholder="description">
    </div>

    <br>
    

    <input type="submit" value="execute" class="buttonsubmit">
    </div>
    <table id="admintable">
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>User Id</th>
                <th>Description</th>
              </tr>
              <?php foreach(getSession("teachersextract") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['id']."</td><td>".$user['fullname']."</td>"."<td>".$user['iduser']."</td>"."<td>".$user['studies']."</td>"; ?>
              </tr>
              <?php }?>
            </table>
                <br><br>
            <table id="admintable">
              <tr>
                <th>Id</th>
                <th>Email</th>
              </tr>
              <?php foreach(getSession("useradmin") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['id']."</td><td>".$user['email']."</td>"; ?>
              </tr>
              <?php }?>
            </table>
            
        </form>
    </div>
