
    <div class="studentsadmin">
    <form action="/admin/ads" method="post" id="formData">

    <div class="organize">
    <label>Modify users role by email</label>
    <br>
    
    <input type="text" name="studentmail" placeholder="mail">

    <br>
    <select name="option" id="studentDataSelector">
        <option disabled selected value>Field</option>
        <option value="1">Student</option>
        <option value="2">Teacher</option>
    </select>

    <input type="submit" value="execute" class="buttonsubmit">
    </div>
    <table id="admintable">
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
              </tr>
              <?php foreach(getSession("useradmin") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['uname']."</td><td>".$user['email']."</td>"; if($user["role"]==1){echo  "<td>Student</td>";}elseif($user["role"] == 2){echo  "<td>Teacher</td>";};?>
              </tr>
              <?php }?>
            </table>
            
        </form>


    
    </div>