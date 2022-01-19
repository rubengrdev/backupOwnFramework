<div id="task">
<form action="/lists/li" method="post" id="lists-form" value="Option">
<select name="option" id="opForm" form="lists-form">
  <option disabled selected value>Option</option>
  <option value="INSERT">Add</option>
  <option value="DELETE">Delete</option>
</select>
<label>Lists</label>
<input type="radio" id="list-selector" name="liststasks" value="lists">
<label>Tasks</label>
<input type="radio" id="task-selector" name="liststasks" value="tasks">
<br><br>
<label>Nombre de la lista</label>
<input type="text" placeholder="nombre" name="listname">
<span class="insertTaskJS">
<label>Contenido de la tarea</label>
<input type="text" placeholder="nombre" name="taskname">
</span>
<input type="submit" value="OK" name="OK">
</form> 
</div>