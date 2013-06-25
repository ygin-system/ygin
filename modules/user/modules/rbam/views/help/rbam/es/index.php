<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM home page help partial view.
* es version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Based Access Manager</h2>
<p>El Role Based Access Manager (RBAM) proporciona una gestión total de su Role Based Access Control (RBAC) del sistema.</p>
<p>Desde aquí se puede manejar bien elementos de la autorización y / o asignaciones de funciones para los usuarios, dependiendo de qué permisos tienen.</p>
<h2>Role Based Access Control</h2>
<p>Role Based Access Control (RBAC) es un método de otorgar a los usuarios permiso para hacer algo basado en el función (s) que están asignados. Los permisos son efectivamente concedidas a los roles, ya sea directamente o por herencia, que se asignan a los usuarios adecuados. Normalmente, los permisos para una determinada función rara vez cambian en comparación con las asignaciones de usuario a la función. Un rol puede ser asignado a muchos usuarios y un usuario puede tener muchas funciones (nota: es más fácil de gestionar un sistema en el que se le asigna un usuario de una función que obtiene los permisos de otras funciones a través de la herencia).</p>
<h3>Autorización de elementos</h3>
<p>Elementos de la autorización son los componentes básicos de los sistemas RBAC, que conceden permiso para hacer algo, ya sea directamente o por heredar los permisos de los elementos de autorización niño.
Un artículo de la autorización se define únicamente por su nombre.</p>
<p>Este sistema RBAC tiene tres niveles de la autorización de elementos: <em><?php echo CHtml::link('Funciones', '#help-roles'); ?></em> en el nivel superior, a continuación <em><?php echo CHtml::link('Tareas', '#help-tasks'); ?></em>, y <em><?php echo CHtml::link('Operaciones', '#help-operations'); ?></em> en el nivel más bajo.</p>
<p>Una jerarquía se basa la autorización de usar los elementos de la autorización. Un artículo de la autorización puede tener elementos secundarios de la autorización del mismo nivel o inferior y hereda los permisos de sus hijos. Un artículo de la autorización puede tener muchos hijos y un elemento de una autorización puede ser hijo de muchos otros elementos de la autorización (técnicamente, esto hace que la jerarquía de la autorización de un gráfico de orden parcial, es posible crear jerarquías planas y el árbol con RBAC).</p>
<p>La jerarquía de la autorización concede permisos en términos de estructura de una aplicación mediante la definición de las funciones que realizan las personas, las tareas realizadas en los funciónes, y las operaciones necesarias para realizar las tareas (Nota: RBAC puede utilizar las funciones y tareas sólo, o roles solo, haciendo es una buena solución, incluso si la aplicación tiene requisitos de autorización bastante simple). Esto permite que un sistema de autorización flexible y potente que se cree; RBAM hace que sea fácil crear y administrar el sistema.</p>
<h4 id="help-roles">Funciones</h4>
<p>Los roles son elementos de nivel superior de la autorización y se les asigna a los usuarios (tareas y operaciones que no lo son). Las funciones pueden ser equiparados a los títulos de trabajo. Mediante una aplicación de blog como un ejemplo, las posibles funciones podría ser "Editor" (puede aprobar, borrar, etc todos los puestos), el "Asistente de Editor" (puede aprobar los mensajes hasta un cierto tamaño - un poco artificial, pero ya verás por qué más adelante), y "Autor" (puede crear y editar los mensajes propios).
Las funciones pueden tener otras funciones, tareas y operaciones de los niños.</p>
<h5>Funciones Predeterminadas</h5>
<p>El sistema RBAC puede tener "funciones predeterminadas". Estas funciones no están expresamente asignados a los usuarios, en lugar del sistema RBAC los controles de forma automática para todos los usuarios. RBAM define dos funciones por defecto: "Guest" - el función por defecto para todos los usuarios que no se ha identificado, y "Authorised" - el función por defecto para todos los usuarios que se registran en un (RBAM puede ser configurado para utilizar nombres diferentes).</p>
<p>RBAM también tiene algunas funciones que se definen para su propio uso (de nuevo, RBAM puede ser configurado para utilizar nombres diferentes): "RBAC Manager" - maneja elementos Auth y asignaciones de funciones, "Auth Assignments Manager" - administra las asignaciones de funciones, y "Auth Items Manager"- maneja elementos de autenticación. (El Administrador de autenticación de misiones y funciones de Administrador de elementos de autenticación son hijos de la función RBAC Manager, que hereda los permisos de ambos.)</p>
<h4 id="help-tasks">Tareas</h4>
<p>Las tareas son a mediados de los niveles de la jerarquía de la autorización, sino que son lo que la gente hace en un función. Ejemplo de tareas en nuestra aplicación de blog podría ser "Administrar entradas" - un niño de la "Editor" función, y "Escribir mensajes" - un niño de la función de Autor.</p>
<p>Las tareas pueden tener otras tareas y operaciones de los niños.</p>
<h4 id="help-operations">Operaciones</h4>
<p>Las operaciones son el nivel más bajo en la jerarquía de la autorización, son las acciones para llevar a cabo una tarea. Las operaciones en el blog ejemplo podría ser "Crear Mensaje" y "Modificar propio de Correos" (esto requiere a)) como hijos de la "Escribir mensajes" tarea "Aprobar Correos" - hijo de la "Administración de sus" tareas y el Asistente " Editor de "función, y" Editar comentario "y" Eliminar mensaje "- los niños de la" Gestión de Mensajes "tarea.</p>
<p>Operaciones sólo pueden tener otras operaciones como los niños.</p>
<h3 id="help-business-rules">Reglas de negocio</h3>
<p>Un artículo de la autorización puede tener una regla de negocio. Una regla de negocio es una pieza de código PHP que se ejecuta cuando la comprobación de acceso para el elemento, sino que debe devolver true para conceder el permiso, el "Invitado" y "autorizado" funciónes utilizar las reglas de negocio para comprobar si el usuario está conectado pulg</p>
<p>La regla de negocio se puede referir a dos variables: <em>$params</em> y <em>$data</em>. <em>$params</em> proviene de la aplicación y se utiliza para pasar en los parámetros exigidos por la regla de negocio.</p>
<p>En el ejemplo del blog, queremos asegurarnos de que sólo los usuarios pueden editar los mensajes que crearon y que no pueden hacerlo una vez que un mensaje es aprobado. Para ello usamos una regla de negocio que se pasa del puesto en la variable <em>$params</em>; algo así como:</p>
<pre>return Yii::app()->user-&gt;id==$params["post"]-&gt;authorID && !$params["post"]-&gt;approved;</pre>
<p>Anteriormente se ha definido el "Asistente de Editor de" función, los usuarios con el función que pueden aprobar los mensajes hasta una longitud determinada. Para comprobar esto, el uso tanto de la <em>$params</em> y <em>$data</em> variables en una regla de negocio para el función de asistente del editor en la línea de:</p>
<pre>return strlen($params["post"]-&gt;content)&lt;=$data;</pre>
<h3 id="help-data">Datos</h3>
<p>Un artículo de la autorización puede tener información adicional que se hace referencia en la regla de negocio mediante la variable <em>$data</em>. En el ejemplo anterior <em>$data</em> es la longitud máxima del mensaje la función Asistente de Editor puede aprobar y lo que es un valor entero.</p>
<h3>Autorización de Asignaciones</h3>
<p>Asignaciones de la autorización de asignar funciones a los usuarios. La asignación puede tener una regla de negocio y los datos para personalizar los permisos concedidos por el función de un usuario en particular.</p>