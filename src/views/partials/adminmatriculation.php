
    <div class="adminmatriculation">
    <form action="/admin/adm" method="post" id="formData">

    <div class="organize">
    
   
    <input type="text" name="useremail" placeholder="mail">
    <br>
    <select name="option" id="userDataSelector2">
        <option disabled selected value>Field</option>
        <option value="1">Firts course (1)</option>
        <option value="2">Second course (2)</option>
    </select>

    <input type="submit" value="execute" class="buttonsubmit">
    </div>
    <table id="admintable">
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Course</th>
              </tr>
              <?php foreach(getSession("matriculation") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['uname']."</td><td>".$user['email']."</td><td>".$user['course']."</td>";?>
              </tr>
              <?php }?>
            </table>
            
        </form>


    </div>