<?php
/* SVN FILE: $Id: manage.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Manage Auth Item page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Administrar un Elemento de la Autorización</h2>
<p>Esta página es donde puede administrar todos los aspectos de un elemento de la autorización.</p>
<p>A la izquierda hay un formulario que se puede utilizar para actualizar el elemento. Haga los cambios necesarios y haga clic en "Actualizar".</p>
<p class="note"><b>Nota:</b> Cambiar el nombre de las funciones por defecto y RBAM no es recomendable.<br/>Por defecto, el nombre de estos funciones es de sólo lectura. Si desea cambiar el nombre de una de estas funciones, haga doble clic en el nombre para que sea editable.</p>
<p>A la derecha se puede ver y administrar las relaciones - los padres y los niños - del artículo. Hay tres áreas de la relación:</p>
<ul>
<li>Los padres - elementos a los que el elemento actual es un niño</li>
<li>Los niños - los elementos que son hijos del elemento actual</li>
<li>Sin relación - los elementos que no están relacionados con el tema actual, es decir, no un ascendiente o descendiente del elemento actual</li>
</ul>
<p>Cada área se muestran sus los elementos en pestañas según el tipo, lo que significa que no todos los tipos puede ser mostrado a los padres y / o niños, ya que depende del tipo del elemento actual, por ejemplo, si el elemento actual es una función, sólo otros Las funciones pueden ser sus padres.</p>
<p>El contenido de cada ficha se puede paginar, ordenar y filtrar por orden alfabético.</p>
<p>La siguiente información se muestra para cada elemento de la autorización:</p>
<ul>
<li>Nombre - nombre del elemento. Utilice esta opción para "arrastrar y soltar" y gestionar las relaciones</li>
<li>Descripción - una breve descripción del elemento</li>
<li>De reglas de negocio - una marca de verificación se muestra si elemento tiene una regla de negocio; asomar a ver el regla</li>
<li>Datos - una marca de verificación se muestra si elemento tiene datos para pasar a la regla de negocio; asomar para ver los datos</li>
<li>Padres contar - el número de elementos a los que elemento es un niño. Haz clic aquí para ver los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios del elemento tiene. Haga clic para ver los elementos secundarios, y de nuevo para ocultarlos</li>
<li>Acciones - botón para administrar el elemento <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authitemManage.png','Administrar elemento')?></li>
</ul>
<h3>Administración de Relaciones</h3>
<p>Administrar las relaciones es simplemente un caso de arrastrar y colocar elementos o de la zona no vinculados en o fuera de las áreas de los padres o los niños. El manejador de arrastre de un elemento es el nombre que tendrá un fondo naranja, mientras que se arrastra. Áreas en las que elemento se puede quitar a su vez, amarillo y después en verde cuando un elemento se encuentra en la zona.</p>
<p>Las áreas de relación son blancos de la gota - no las etiquetas - por lo que no importa la pestaña que está activa en el área de colocación.</p>
<h4>Agregar una Relación</h4>
<p>Para agregar un elemento como un niño o el padre del elemento actual, arrastre un elemento no relacionado (hacer clic y arrastrar sobre el nombre) a los padres o los niños de la zona de la pantalla, la relación es creada inmediatamente y las relaciones y áreas de permiso de actualizarse en consecuencia.</p>
<h4>Eliminar una Relación</h4>
<p>Para eliminar una relación, arrastre un elemento de las áreas de los padres o los niños no vinculados a la zona, la relación se elimina inmediatamente y actualizada de las relaciones y áreas de permiso.</p>
<p class="note"><b>Nota:</b> Al agregar o quitar las relaciones, los recuentos de los elementos sin relación puede cambiar los tipos de los elementos distintos de los del elemento agregado / eliminado como un niño o padre, y su tipo de cuenta puede cambiar por más de uno. Esto se debe a las relaciones (descendientes y ancestros) del elemento se tienen en cuenta.<br/>
Por ejemplo, si agrega T de tareas como un hijo de función F, función F hereda todos los permisos de T de tareas y sus descendientes, descendientes, es decir T de tareas se convierten en los descendientes de función F el sentido de que ahora están relacionados con él y lo quita de la lista de los elementos relacionados.</p>
<h3>Asignaciones</h3>
<p>Esto muestra a los usuarios que tienen permiso para el elemento actual y las asignaciones de funciones por el cual se les concede permiso.</p>
<p>La siguiente información se muestra para cada usuario:asignación de funciones:
<ul>
<li>Usuario - el nombre del usuario con permiso para el elemento actual. Haciendo clic en el botón "Ver" <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Mostrar funciones de usuario')?> (sólo está disponible si usted tiene el permiso Auth Assignments Manager)mostrará a los funciones asignadas al usuario</li>
<li>Función - el nombre de la función por la que se concede permiso al usuario para el elemento actual.  Haciendo clic en el botón "Ver" <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Mostrar a los usuarios función')?> (sólo está disponible si usted tiene el permiso Auth Assignments Manager) mostrará a los usuarios con el rol asignado</li>
<li>Descripción - una breve descripción de la función</li>
<li>Padres contar - el número de elementos a los que este papel es un niño. Haz clic aquí para ver los elementos de los padres, y de nuevo para ocultarlos</li>
<li>Contar para niños - el número de elementos secundarios el papel tiene. Haga clic para ver los elementos secundarios, y de nuevo para ocultarlos</li>
<li>Función Acciones - botón pa Administrar el función</li>
<li>De reglas de negocio - la regla de negocio (si los hay) aplicable a la asignación</li>
<li>Los datos - los datos (si los hay) que se pasa a la regla de negocio</li>
<li>Assignment Actions (only available if you are assigned the Auth Assignments Manager role) – buttons to update the business rule and/or data for the assignment <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?>, and revoke <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?> the assignment</li>
</ul>
<h3>Iconos</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Administrar elemento')?></td><td>Administrar un elemento</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Funciones asignadas al usuario')?></td><td>Funciones asignadas al usuario</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Usuarios con función asignado')?></td><td>Usuarios con función asignado</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Modificar la asignación')?></td><td>Modificar la asignación</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Revocar asignación')?></td><td>Revocar asignación</td></tr>
</table>
