<?php
/* SVN FILE: $Id: userRoles.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Roles assigned to user page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Zugewiesenen Rollen Benutzer</h2>
<p>Diese Seite zeigt die zugewiesenen Rollen eines Benutzers. Rollen können ausgelagert, sortiert, gefiltert und alphabetisch sortiert.</p>
<p>Die folgenden Informationen werden für jede Rolle gezeigt:</p>
<ul>
<li>Role – the name of the role.  The “view” button<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeView.png','Benutzer mit Rolle zugewiesen')?> shows the users with the role assigned</li>
<li>Beschreibung - Eine kurze Beschreibung der Rolle</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Role Actions – button  to manage the role<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeManage.png','Manage the role')?> (only available if you have Auth Elemente Manager permission)</li>
<li>Business Rule - das Business Rule (falls vorhanden) für den Benutzer:Rolle zuweisung</li>
<li>Daten - die Daten (sofern vorhanden) in das Business Rule</li>
<li>Zuordnung Aktionen (nur verfügbar, wenn Sie die Auth Zuordnungen Manager Rolle zugewiesen) - Tasten zur Aktualisierung der Business Rule und/oder Daten für die Zuordnung <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Bearbeiten Zuordnung')?>, und widerrufen <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Widerrufen Zuordnung')?> die Zuordnung</li>. Die Fußzeile der Spalte Aktionen enthält die Taste, um zusätzliche Rollen für den aktuellen Benutzer zuweisen<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Rollen zuweisen, um den Benutzer')?>.</li>
</ul>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeManage.png','Verwalten Element')?></td><td>Verwalten Sie ein Element</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeView.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Rollen zuweisen, um den Benutzer')?></td><td>Rollen zuweisen, um den Benutzer</td></tr>
</table>