
    <div class="useradmin">
    <form action="/admin/adu" method="post" id="formData">

    <div class="organize">
    
    <label>Update</label>
    <input type="radio" name="userselect" value="update" class="selectOption2">
    <label>Delete</label>
    <input type="radio" name="userselect" value="delete" class="selectOption2">
    <br>
    <input type="text" name="getuserselect" placeholder="mail">
    <input type="text" name="getNewSelect" placeholder="newField" class="displayed">
    <br>
    <select name="option" id="userDataSelector">
        <option disabled selected value>Field</option>
        <option value="uname">Username</option>
        <option value="email">Email</option>
    </select>

    <input type="submit" value="execute" class="buttonsubmit">
    </div>
    <table id="admintable">
              <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
              <?php foreach(getSession("useradmin") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['id']."</td><td>".$user['uname']."</td><td>".$user['email']."</td>";?>
              <td class="icontd"><img class="iconadmin" src="/public/resources/icons/reload.png"></td>
              <td class="icontd"><img class="iconadmin" src="/public/resources/icons/bin.webp"></td>
              </tr>
              <?php }?>
            </table>
            
        </form>


    </div>