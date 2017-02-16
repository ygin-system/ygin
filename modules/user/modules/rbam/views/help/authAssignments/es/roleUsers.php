<?php
/* SVN FILE: $Id: roleUsers.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users with a role assigned page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Usuarios con Función Asignado</h2>
<p>Esta página muestra los usuarios con una determinada función asignada, ya sea directamente o por herencia.</p>
<p>La siguiente información se muestra para cada usuario:</p>
<ul>
<li>Nombre - el nombre del usuario. El botón "Ver"<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Roles assigned to user')?> muestra las funciones asignados a un usuario</li>
<li>Función - el nombre de la función. El botón "Ver"<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Usuarios con función asignado')?> muestra a los usuarios con el funcion asignado</li>
<li>Descripción - una breve descripción de la función</li>
<li>Padres contar - el número de elementos a los que este papel es un niño. Haz clic aquí para ver los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios el papel tiene. Haga clic para ver los elementos secundarios, y de nuevo para ocultarlos</li>
<li>Función Acciones - botón para administrar el función<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar el función')?> (sólo está disponible si tiene permiso de Auth Items Manager)</li>
<li>De reglas de negocio - la regla de negocio (si los hay) aplicable a la asignación</li>
<li>Los datos - los datos (si los hay) que se pasa a la regla de negocio</li>
<li>Asignación de acciones - para actualizar la regla de negocio y/o datos para la asignación<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?>, y revocar la asignación<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?>.</li>
</ul>
<h3>Iconos</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar elemento')?></td><td>Administrar un elemento</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Funciones asignadas al usuario')?></td><td>Funciones asignadas al usuario</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Usuarios con función asignado')?></td><td>Usuarios con función asignado</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?></td><td>Modificar la asignación</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?></td><td>Revocar asignación</td></tr>
</table>