<?php
/* SVN FILE: $Id: generate.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Generate Auth Item page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Generar datos de la autorización</h2>
<p>Esta página le permite generar datos de autorización - Accesorios de autorización y jerarquía - basada en los módulos, controladores y acciones de la aplicación que selecciona.</p>
<p>Los módulos, controladores y acciones en su aplicación se muestran en un árbol a la izquierda, haga clic en los nodos a la izquierda de las casillas de verificación para expandir o contraer el nodo.</p>
<p>Compruebe los elementos que desea generar datos de autorización para. Todos los nodos secundarios de un nodo seleccionado también se seleccionan.</p>
<p>Elementos de creación de autorización se nombran de acuerdo a su "trayectoria", por ejemplo, el módulo de blog que contiene el controlador de mensaje que tiene la creación de Acción se traducirá en un función llamado "Blog", una tarea denominada "Blog:Mensaje", y una operación denominada "Blog:Mensaje:Crear". RBAM también crea las relaciones adecuado para niños, utilizando el ejemplo anterior el "Blog:Mensaje:Crear" operación será un hijo del "Blog:Mensaje" la tarea, que a su vez será un hijo del "Blog" función.</p>
<p>Puede introducir un sufijo que se añade al nombre de los elementos de autorización. Esto es para uso en "composición" de aplicaciones para evitar confilcts nombre. por ejemplo si va a generar elementos para el backend puede utilizar el sufijo "Volver", lo que dará lugar a los elementos del ejemplo anterior de ser nombrado,:, y "Blog:Mensaje:Crear!Volver", "Blog:Mensaje!Volver", y "Blog!Volver", respectivamente (un sufijo que se utiliza para permitir la clasificación por su nombre para ser eficaz).</p>
<p>Elementos existentes de autorización se muestran a la derecha para ayudarle a decidir que, en su caso, los elementos nuevos deben generar.</p>
<p>Haga clic en "Generar" para generar los datos de autorización.</p>
<p class="note"><b>Nota:</b> RBAM will not overwrite existing authorisation items.</p>
<p>Cuando RBAM ha generado los datos de la autorización de un resumen de los elementos nuevos se ha hecho, que luego son llevados a la vista la autorización elementos.</p>
