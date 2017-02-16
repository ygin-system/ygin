<?php
/* SVN FILE: $Id: assign.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Assign roles to user page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Rollen zuordnen Benutzer</h2>
<p>Diese Seite wird verwendet, um Rollen zu einem Benutzer zuordnen. Verfügbare Rollen, dh Rollen, die nicht zugeordnet werden und sind nicht Kinder des zugewiesenen Rollen des Benutzers, werden angezeigt, sie können ausgelagert, sortiert, gefiltert und alphabetisch.</p>
<p class="note"><b>Hinweis:</b> Default Rollen sind nicht aufgeführt, da sie nicht an Benutzer zugeordnet werden.</p>
<p>Die folgenden Informationen sind für jede Rolle gezeigt:</p>
<ul>
<li>Namen – den Namen des rolle.</li>
<li>Beschreibung - Eine kurze Beschreibung der Rolle</li>
<li>Business Rule - das Business Rule (falls vorhanden) für die Rolle</li>
<li>Daten - die Daten (sofern vorhanden) in das Business Rule</li>
<li>Eltern zählen – Die Anzahl der übergeordneten Elemente des Element hat - Hier klicken um die übergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Kind zählen – Die Anzahl der untergeordneten Elemente des Element hat - Hier klicken um die untergeordneten Elemente anzuzeigen, und wieder, sie zu verbergen</li>
<li>Checkbox - klicken Sie das Kontrollkästchen, um die Rolle für den aktuellen Benutzer zuweisen</li>
</ul>
<p>Auf eine Rolle zuweisen (Klicken auf das Kontrollkästchen) ein Pop-up-Formular angezeigt wird, wo die Geschäftsregel und Daten für die Zuordnung eingegeben werden, falls erforderlich. Klicken Sie auf "Zuweisen", um die Zuordnung oder "Abbrechen", um den Vorgang abzubrechen. Die Liste der nicht zugewiesenen Rollen wird aktualisiert, wenn eine Rolle zugewiesen wird.</p>
<p class="note"><b>Hinweis:</b> Anderen Rollen als der zugewiesenen Rolle wird von der Liste gestrichen werden, wenn sie Kinder der zugewiesenen Rolle sind.</p>
