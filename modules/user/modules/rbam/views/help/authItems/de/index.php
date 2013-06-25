<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Auth Item overview page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Genehmigung Elemente</h2>
<p>Diese Seite zeigt alle von der Genehmigung Elemente auf der RBAC-System Tabbed nach der Art der Sache. Elemente können ausgelagert, sortiert, gefiltert und alphabetisch sortiert.</p>
<p>Die folgenden Informationen sind für jeden Item unter der Genehmigung für:</p>
<ul>
<li>Namen - Der Namen das Item</li>
<li>Beschreibung - Eine kurze Beschreibung das Item</li>
<li>Business Rule - Die Business-Regel (falls vorhanden), gilt für das Item</li>
<li>Daten - Die Daten (sofern vorhanden), die der Business Rule übergeben wird</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Aktionen - Aktionen, die auf das Item ausgeführt werden können - Verwalten und Löschen</li>
</ul>
<p>Sie können auch neue Elemente.</p>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Verwalten Element')?></td><td>Verwalten Sie ein Item</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemDelete.png','Delete item')?></td><td>Löschen eines Item (Standard und RBAM Rollen können nicht gelöscht werden)</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemAdd.png','Create item')?></td><td>Erstellen Rolle/Aufgabe/Betrieb (abhängig von der aktiven Tab)</td></tr>
</table>
