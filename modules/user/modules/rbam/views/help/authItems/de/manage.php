<?php
/* SVN FILE: $Id: manage.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Manage Auth Item page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Verwalten einer Genehmigung Element</h2>
<p>Diese Seite finden Sie alle Aspekte einer Genehmigung Element zu verwalten.</p>
<p>Auf der linken Seite ist eine Form, mit der das Element aktualisiert werden können. Nehmen Sie die gewünschten Änderungen vor und klicken Sie auf "Änderung".</p>
<p class="note"><b>Hinweis:</b> Umbenennung der Standard und RBAM Rollen wird nicht empfohlen. <br/> Standardmäßig ist der Name dieser Rollen ist schreibgeschützt. Wenn Sie auf den Namen einer dieser Rollen ändern wollen Doppelklick auf den Namen, um es editierbar.</p>
<p>Auf der rechten Seite anzeigen und verwalten können die Beziehungen - Eltern und Kinder - von dem Artikel. Es gibt drei Bereiche Beziehung:</p>
<ul>
<li>Eltern - Elemente, auf die das aktuelle Element ist ein Kind</li>
<li>Kinder - Elemente, die Kinder das aktuelle Element sind</li>
<li>Unabhängige - Elemente, die nicht auf das aktuelle Elemente verbunden sind, dh nicht ein Vorfahre oder Abkömmling das aktuelle Element</li>
</ul>
<p>Jeder Bereich werden das Element in ein je nach Typ, das heißt, dass nicht alle Typen für Eltern und/oder Kindern kann gezeigt werden, wie es auf den Typ das aktuelle Element abhängt, zum Beispiel, wenn das aktuelle Element ist eine Rolle, nur andere Rollen können seine Eltern sein.</p>
<p>Der Inhalt der einzelnen Registerkarten können ausgelagert, sortiert, gefiltert und alphabetisch.</p>
<p>Die folgenden Informationen werden für jede Genehmigung ausgewiesen:</p>
<ul>
<li>Namen - Der Namen das Element. Verwenden Sie diese auf "Drag and Drop" und Verwalten von Beziehungen</li>
<li>Beschreibung - Eine kurze Beschreibung das Element</li>
<li>Business Rule - ein Häkchen wird angezeigt, wenn das Element hat eine Geschäftsregel, schweben, um die Regel zu sehen</li>
<li>Daten - ein Häkchen wird angezeigt, wenn das Element hat Daten zu den Business Rule geliefert werden; schweben, um die Daten zu sehen</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Aktionen – Taste, um das Element zu verwalten <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authitemManage.png','Verwalten Element')?></li>
</ul>
<h3>Verwalten von Beziehungen</h3>
<p>Geschäftsführer Beziehungen ist einfach ein Fall von Drag & Drop Elemente oder aus dem Bereich Unabhängige Betreten oder Verlassen der Eltern oder Kinder Bereichen. Die Drag eines Elements Griff ist der Name, die einen orangefarbenen Hintergrund haben, werden während gezogen. Bereiche, in denen das Element gelöscht wird gelb, dann grün, wenn ein Element in der Gegend ist, kann sein.</p>
<p>Die Beziehung Bereiche Droptargets - nicht ein - so spielt es keine Rolle, welche Registerkarte aktiv ist in der Dropdown-Bereich.</p>
<h4>Hinzufügen einer festen Beziehung</h4>
<p>So fügen Sie ein Element wie ein Kind oder ein Elternteil des aktuellen Elements, ziehen Sie einen unabhängigen Element (klicken und ziehen auf den Namen) an die Eltern oder Kinder des Bildschirms, die Beziehung sofort und schuf die Beziehungen und die Erlaubnis Bereiche entsprechend aktualisiert.</p>
<h4>Entfernen einer festen Beziehung</h4>
<p>So entfernen Sie eine Beziehung, ziehen Sie ein Element aus der Eltern oder Kinder Bereichen der Unabhängige Gebiet, das Verhältnis wird sofort entfernt und die Beziehungen und die Erlaubnis Bereichen aktualisiert.</p>
<p class="note"><b>Hinweis:</b> Beim Hinzufügen oder Entfernen von Beziehungen, zählt der unabhängigen Elemente können für Arten von Gegenständen, ausgenommen der Sache hat Änderungen / entfernt als Kind / Eltern und ihrer Art zählen können durch mehr als eine Änderung. Dies liegt daran, Beziehungen (Nachkommen und Vorfahren) des Elements berücksichtigt werden.<br/>
Zum Beispiel, wenn Sie Task-T als Kind Rolle R hinzufügen, erbt Rolle R alle Berechtigungen von Task T und seine Nachkommen, dh Task T's Nachkommen werden Nachkommen der Rolle R bedeutet, dass sie jetzt damit zusammenhängenden und so aus der entfernt werden Liste der unabhängigen Elemente.</p>
<h3>Zuweisungen</h3>
<p>Dies zeigt die Benutzer, die Berechtigung für die aktuelle Element und die Rollenzuweisungen, durch die sie die Erlaubnis erteilt werden.</p>
<p>Die folgenden Informationen sind für jeden Benutzer:Rolle zuweisung unter:
<ul>
<li>User - der Name der Benutzer mit der Berechtigung für das aktuelle Element. Ein Klick auf die Taste "Blick" <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Show user roles')?> (nur verfügbar, wenn Sie Auth Zuweisungen Manager Erlaubnis) zeigt die zugewiesenen Rollen der Benutzer</li>
<li>Rolle - der Name der Rolle, die dem Benutzer die Berechtigung erteilt wird für das aktuelle Element.  Ein Klick auf die Taste "Blick" <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Show role users')?> (nur verfügbar, wenn Sie Auth Zuweisungen Manager Erlaubnis) zeigt die Benutzer mit der Rolle zugewiesen</li>
<li>Beschreibung - Eine kurze Beschreibung der Rolle</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Rolle Aktion - eine Taste, um die Rolle zu verwalten</li>
<li>Business Rule - das Business Rule (falls vorhanden) für den Benutzer:Rolle zuweisung</li>
<li>Daten - die Daten (sofern vorhanden) in das Business Rule</li>
<li>Zuordnung Aktionen (nur verfügbar, wenn Sie die Auth Zuordnungen Manager Rolle zugewiesen) - Tasten zur Aktualisierung der Business Rule und/oder Daten für die Zuordnung <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Bearbeiten Zuordnung')?>, und widerrufen <?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Widerrufen Zuordnung')?> die Zuordnung</li>
</ul>
<h3>Icons</h3>
<table>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemManage.png','Verwalten Element')?></td><td>Verwalten Sie ein Element</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/userView.png','Zugewiesenen Rollen der Benutzer')?></td><td>Zugewiesenen Rollen der Benutzer</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/authItemView.png','Benutzer mit Rolle zugewiesen')?></td><td>Benutzer mit Rolle zugewiesen</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentUpdate.png','Bearbeiten Zuordnung')?></td><td>Bearbeiten Zuordnung</td></tr>
<tr><td><?php echo CHtml::image($this->getmodule()->baseScriptUrl.'/images/assignmentRevoke.png','Widerrufen Zuordnung')?></td><td>Widerrufen Zuordnung</td></tr>
</table>
