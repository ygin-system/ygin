<?php
/* SVN FILE: $Id: userRoles.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Roles assigned to user page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Funciones Asignados a Usuarios</h2>
<p>Esta página muestra las funciones asignados a un usuario. Las funciones pueden ser paginados, ordenados, y se filtró por orden alfabético.</p>
<p>La siguiente información se muestra para cada función:</p>
<ul>
<li>Función - el nombre de la función. El botón "Ver"<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Usuarios con función asignado')?> muestra a los usuarios con el funcion asignado</li>
<li>Descripción - una breve descripción de la función</li>
<li>Padres contar - el número de elementos a los que este papel es un niño. Haz clic aquí para ver los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios el papel tiene. Haga clic para ver los elementos secundarios, y de nuevo para ocultarlos</li>
<li>Función Acciones - botón para Administrar el función<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar el función')?> (sólo está disponible si tiene permiso de Auth Items Manager)</li>
<li>De reglas de negocio - la regla de negocio (si los hay) aplicable a la asignación</li>
<li>Los datos - los datos (si los hay) que se pasa a la regla de negocio</li>
<li>Asignación de acciones - para actualizar la regla de negocio y / o datos para<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?>, y revocar<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?> la asignación. El pie de la columna Acciones contiene el botón para asignar funciones adicionales para el usuario actual<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Asignar funciones para el usuario')?>.</li>
</ul>
<h3>Iconos</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar elemento')?></td><td>Administrar un elemento</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Usuarios con función asignado')?></td><td>Usuarios con función asignado</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?></td><td>Modificar la asignación</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?></td><td>Revocar asignación</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Asignar funciones para el usuario')?></td><td>Asignar funciones para el usuario</td></tr>
</table>
