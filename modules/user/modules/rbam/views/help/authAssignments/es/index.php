<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Usuario</h2>
<p>Esta página muestra todos los usuarios en el sistema que se pueden asignar roles. Los usuarios pueden ser paginados, ordenados,y se filtró por orden alfabético.</p>
<p>La siguiente información se muestra para cada usuario:</p>
<ul>
<li>Nombre - el nombre del usuario</li>
<li>Funciones contar - el número de funciones actualmente asignadas al usuario</li>
<li>Acciones - para ver los funciones asignados <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Funciones asignadas al usuario')?> y asignar funciones<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Asignar funciones para el usuario')?> para el usuario</li>
</ul>

