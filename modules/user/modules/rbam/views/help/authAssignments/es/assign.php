<?php
/* SVN FILE: $Id: assign.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Assign roles to user page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Asignar funciones para el usuario</h2>
<p>Esta página se utiliza para asignar funciones a un usuario. Funciones disponibles, es decir, funciones que no están asignadas y no son hijos de los funciones asignados al usuario, se muestran, sino que se puede paginados, ordenados, y se filtró por orden alfabético.</p>
<p class="note"><b>Nota:</b> Funciones por defecto no figuran ya que no se pueden asignar a los usuarios.</p>
<p>La siguiente información se muestra para cada función:</p>
<ul>
<li>Nombre - el nombre de la función</li>
<li>Descripción - una breve descripción de la función</li>
<li>De reglas de negocio - la regla de negocio (en su caso) aplicables a la función</li>
<li>Los datos - los datos (si los hay) que se pasa a la regla de negocio</li>
<li>Padres contar - el número de elementos a los que este papel es un niño. Haz clic aquí para ver los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios el papel tiene. Haga clic para ver los elementos secundarios, y de nuevo para ocultarlos</li>
<li>Casilla de verificación - haga clic en la casilla de verificación para asignar la función para el usuario actual</li>
</ul>
<p>Sobre la asignación de un función (haciendo clic en su casilla de verificación) una forma emergente se muestra en la regla de negocio y datos para la asignación se introducen en caso necesario. Haga clic en "Asignar"para completar la tarea, o "Cancelar "para cancelar el mismo. La lista de funciones no asignadas se actualiza cuando se le asigna un función.</p>
<p class="note"><b>Nota:</b> Otras funciones que el función asignado será removido de la lista si son hijos de la función asignada.</p>
