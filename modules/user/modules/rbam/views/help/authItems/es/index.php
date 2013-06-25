<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Auth Item overview page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Autorización Elementos</h2>
<p>Esta página muestra todos elementos de la autorización en el sistema RBAC pestañas según el tipo de elemento. elementos pueden ser paginado, ordenados, y se filtró por orden alfabético.</p>
<p>La siguiente información se muestra para cada artículo de la autorización:</p>
<ul>
<li>Nombre - el nombre del elemento</li>
<li>Descripción - una breve descripción del elemento</li>
<li>De reglas de negocio - la regla de negocio (si los hay) que se aplica al elemento</li>
<li>Los datos - los datos (si los hay) que se pasa a la regla de negocio</li>
<li>Padres contar - el número de elementos los padres que el artículo se - haga clic para mostrar los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios que el artículo se - haga clic para mostrar los elementos de niño, y otra vez para ocultar</li>
<li>Acciones - acciones que se pueden realizar en el elemento - Administrar y Eliminar</li>
</ul>
<p>También puede crear nuevos elementos.</p>
<h3>Iconos</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar elemento')?></td><td>Administrar un elemento</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemDelete.png','Eliminar elemento')?></td><td>Funciones Eliminar un elemento (por defecto y RBAM no se pueden eliminar)</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemAdd.png','Crear elemento')?></td><td>Crear función/tarea/operación (dependiendo de la pestaña activa)</td></tr>
</table>
