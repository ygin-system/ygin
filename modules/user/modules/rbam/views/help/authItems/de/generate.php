<?php
/* SVN FILE: $Id: generate.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* Generate Auth Item page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Generieren Genehmigung Data</h2>
<p>Auf dieser Seite können Sie die Berechtigung Daten zu generieren - Genehmigung Begriffe und Hierarchie - basierend auf den Modulen, Controller und Aktionen in der Anwendung, die Sie auswählen.</p>
<p>Die Module, Controller und Aktionen in der Anwendung werden in einer Baumstruktur auf der linken Seite gezeigt, klicken Sie auf den Knoten neben der Checkboxen links nach Ein-und Ausblenden der Knoten.</p>
<p>Checken Sie die gewünschten Artikel zu generieren Berechtigungsdaten für. Alle untergeordneten Knoten eines ausgewählten Knotens werden ebenfalls ausgewählt.</p>
<p>Erstellt Genehmigung Begriffe sind benannt nach ihrem "Weg", z. B. die Blog-Modul mit dem Post-Controller, die die Aktion erstellen wird in einer Rolle namens "Blog", eine Aufgabe mit dem Namen "Blog:Post" Ergebnis ist, und eine Operation namens "Blog:Post:Erstellen". RBAM schafft auch das entsprechende Kind-Beziehungen, mit dem obigen Beispiel die "Blog:Post:Erstellen": Aufgabe, die wiederum ein Kind der "Blog" Rolle wird den Betrieb wird ein Kind der "Blog:Post" werden.</p>
<p>Sie können einen Suffix, das den Namen der Genehmigung Begriffe angehängt wird. Dies ist für den Einsatz in "beendet"-Anwendungen zu nennen confilcts vermeiden. z.B. Wenn Sie erzeugen Begriffe sind für das Backend können Sie das Suffix "Zurück" verwenden, dies wird in die Elemente aus dem obigen Beispiel dazu führen, dass benannt: "Blog:Post:Erstellen!Zurück", "Blog:Post!Zurück", und "Blog!Zurück" bzw. (ein Suffix wird verwendet, um die Sortierung nach Namen wirksam zu sein).</p>
<p>Bestehende Genehmigungen Elemente werden auf der rechten Seite angezeigt, um zu entscheiden, ob und welche neue Begriffe brauchen generieren.</p>
<p>Klicken Sie auf "Erstellen", um die Genehmigung zu erzeugen.</p>
<p class="note"><b>Hinweis:</b> RBAM überschreibt bestehende Ermächtigung Begriffe.</p>
<p>Wenn RBAM die Berechtigungsdaten eine Zusammenfassung der neuen Begriffe angezeigt erzeugt hat, sind Sie dann auf die Genehmigung Begriffe Übersicht entnommen.</p>
