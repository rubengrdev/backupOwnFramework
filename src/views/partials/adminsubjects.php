
    <div class="subjectsadmin">
    <form action="/admin/adsa" method="post" id="formData">

    <div class="organize">
    <label>Add</label>
    <input type="radio" name="userselect" value="add" class="optionsubject">
    <label>Delete</label>
    <input type="radio" name="userselect" value="delete">
    <br>
    
    <input type="text" name="code" placeholder="code">
    <div class="addsubject">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="duration" placeholder="duration">
    <input type="text" name="course" placeholder="course">
    <input type="text" name="uf" placeholder="uf">
    <input type="text" name="teacher" placeholder="teacher">
    </div>

    <br>
    

    <input type="submit" value="execute" class="buttonsubmit">
    </div>
    <table id="admintable">
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Duration</th>
                <th>Course</th>
                <th>Uf</th>
                <th>Teacher</th>
              </tr>
              <?php foreach(getSession("subjects") as $user){ ?>
              <tr>
              <?php echo"<td>".$user['code']."</td><td>".$user['name']."</td>"."<td>".$user['duration']."</td>"."<td>".$user['course']."</td>"."<td>".$user['uf']."</td>"."<td>".$user['teacher']."</td>"; ?>
              </tr>
              <?php }?>
            </table>
            <br><br>

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
         
                       
        </form>
    </div>
 <script src="/public/adminsubjects.js"></script>