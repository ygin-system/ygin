<?php
/* SVN FILE: $Id: roleUsers.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users with a role assigned page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Benutzer mit Rolle Zugewiesen</h2>
<p>Diese Seite zeigt die Benutzer mit einer bestimmten Rolle zugeordnet, entweder direkt oder durch Vererbung.</p>
<p>Die folgenden Informationen sind für jeden Benutzer unter:</p>
<ul>
<li>Namen - den Namen des Benutzer. Der "Blick"-Taste<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Zugewiesenen Rollen der Benutzer')?> zeigt die zugewiesenen Rollen eines Benutzers</li>
<li>Rolle – den Namen des rolle. Der "Blick"-Taste<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeView.png','Benutzer mit Rolle zugewiesen')?> zeigt die Benutzer mit der Rolle zugewiesen</li>
<li>Beschreibung - Eine kurze Beschreibung der Rolle</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Rolle Aktionen – Taste, um die Rolle zu verwalten<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeManage.png','Verwalten Sie die Rolle')?> (nur verfügbar, wenn Sie Auth Elemente Manager Erlaubnis)</li>
<li>Business Rule - das Business Rule (falls vorhanden) für den Benutzer:Rolle zuweisung</li>
<li>Daten - die Daten (sofern vorhanden) in das Business Rule</li>
<li>Zuordnung Aktionen (nur verfügbar, wenn Sie die Auth Zuordnungen Manager Rolle zugewiesen) - Tasten zur Aktualisierung der Business Rule und/oder Daten für die Zuordnung <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Bearbeiten Zuordnung')?>, und widerrufen <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Widerrufen Zuordnung')?> die Zuordnung</li>
</ul>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeManage.png','Verwalten Element')?></td><td>Verwalten Sie ein Element</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Zugewiesenen Rollen der Benutzer')?></td><td>Zugewiesenen Rollen der Benutzer</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authElementeView.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
</table>