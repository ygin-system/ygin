<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Users page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Benutzer</h2>
<p>Diese Seite zeigt alle Benutzer im System, die Rollen zugewiesen werden können. Benutzer können ausgelagert, sortiert, gefiltert und alphabetisch sortiert.</p>
<p>Die folgenden Informationen sind für jeden Benutzer unter:</p>
<ul>
<li>Namen - den Namen des Benutzer.</li>
<li>Rollen zählen - die Anzahl der Rollen derzeit die dem Benutzer zugeordnet</li>
<li>Aktionen – Tasten, um die zugewiesenen Rollen<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Zugewiesenen Rollen der Benutzer')?> und die Rollen dem Benutzer zuweisen<?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentAdd.png','Assign roles to the user')?></li>
</ul>

