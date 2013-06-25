<?php
/* SVN FILE: $Id: index.php 9 2010-12-17 13:21:39Z Chris $*/
/**
* RBAM home page help partial view.
* de version
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
?>
<h2>Role Based Access Manager</h2>
<p>Die Role Based Access Manager (RBAM) bietet insgesamt Verwaltung Ihrer Role Based Access Control (RBAC) System.<p>
<p>Von hier aus können Sie entweder die Genehmigung verwalten Items und / oder Rollenzuweisungen für die Benutzer, je nachdem, was Sie Berechtigungen haben.</p>
<h2>Role Based Access Control</h2>
<p>Role Based Access Control (RBAC) ist eine Methode der Gewährung Benutzern die Berechtigung, etwas über die Rolle (n) sie zugeordnet sind Basis tun. Berechtigungen sind eigentlich die Rollen gewährt, entweder direkt oder durch Vererbung, die dann an die entsprechenden Benutzer zugeordnet sind. Typischerweise wird die Berechtigungen für eine bestimmte Rolle selten an den Benutzer Zuweisungen an die Rolle im Vergleich zu ändern. Eine Rolle kann für viele Nutzer zugeordnet werden und ein Benutzer kann mehrere Rollen (Anmerkung: Es ist oft einfacher, ein System, wo ein Benutzer eine Rolle, die Berechtigungen für andere Rollen erhält durch Vererbung zugeordnet ist verwalten) haben.
</p>
<h3>Genehmigung Items</h3>
<p>Genehmigung Items sind die Bausteine des RBAC-Systeme, sie erlaube, etwas zu tun, entweder direkt oder durch Vererbung der Berechtigungen Kind Genehmigung Items.</p>
<p>Eine Genehmigung Item ist eindeutig durch seinen Namen definiert.</p>
<p>This RBAC system has three levels of Authorisation Items: <em><?php echo CHtml::link('Roles', '#help-roles'); ?></em> at the top level, then <em><?php echo CHtml::link('Tasks', '#help-tasks'); ?></em>, and <em><?php echo CHtml::link('Operations', '#help-operations'); ?></em> at the lowest level.</p>
<p>Eine Genehmigung Hierarchie ist mit Hilfe der Genehmigung Items. Eine Genehmigung Artikel können Kind Genehmigung Artikel der gleichen oder niedrigeren Niveau und erbt die Berechtigungen ihrer Kinder. Eine Genehmigung kann Artikel haben viele Kinder und eine Genehmigung Posten kann das Kind von vielen anderen Genehmigung Items werden (technisch, macht dies die Zulassung Hierarchie eine partielle Ordnung Graph, ist es möglich, flache Hierarchien und Baum mit Hilfe von RBAC erstellen).</p>
<p>Die Zulassung Hierarchie gewährt Berechtigungen im Hinblick auf eine Anwendung der Struktur durch die Definition der Rollen, die Menschen tun, die Aufgaben in den Rollen durchgeführt, und die Operationen nötig, um die Aufgaben zu erfüllen (Anmerkung: RBAC können Rollen und Aufgaben nur, oder einfach nur Rollen, so dass es eine gute Lösung, auch wenn Ihre Anwendung recht einfach Zulassungsanforderungen). Dies ermöglicht eine flexible und dennoch leistungsfähiges Berechtigungssystem erstellt werden; RBAM macht es einfach erstellen und verwalten Sie Ihr System.</p>
<h4 id="help-roles">Roles</h4>
<p>Rollen sind die Top-Level-Items und Genehmigung sind, die Benutzer zugeordnet (Aufgaben und Tätigkeiten sind nicht). Rollen können Berufsbezeichnungen gleichgesetzt werden. Mit einem Blog Applikation als Beispiel, könnte möglichen Rollen "Editor" (kann genehmigen, löschen usw. Alle Beiträge), "Assistant Editor" (kann Beiträge genehmigen bis zu einer bestimmten Größe - etwas gekünstelt, aber du wirst sehen, warum später), und "Autor" (können Beiträge bearbeiten und eigene).</p>
<p> Rollen können auch andere Rollen, Aufgaben und Aktivitäten für Kinder.</p>
<h5>Default Rollen</h5>
<p>Das RBAC-System lässt sich "Standard-Rollen". Diese Rollen sind nicht explizit Benutzern zugeordnet, sondern der RBAC-System prüft sie automatisch für alle Benutzer. RBAM definiert zwei Standard-Rollen: "Guest" - die Standard-Rolle für alle Anwender, die nicht angemeldet sind, und "Authorised" - die Standard-Rolle für alle Benutzer, die eingeloggt sind (RBAM kann so konfiguriert werden unterschiedliche Bezeichnungen verwendet werden).</p>
<p>RBAM hat auch einige Rollen, die sie definiert für den eigenen Gebrauch (wieder RBAM kann so konfiguriert werden unterschiedliche Bezeichnungen verwendet werden): "RBAC Manager" - verwaltet Auth Items und Rollenzuweisungen, "Auth Assignments Manager" - verwaltet von Rollenzuweisungen und "Auth Items Manager "- verwaltet Auth Items. (Die Auth Assignments Manager und Auth Items Manager Rollen sind Kinder der RBAC Manager Rolle, die die Berechtigungen sowohl erbt.)</p>
<h4 id="help-tasks">Aufgaben</h4>
<p>Aufgaben sind die Mid-Tier von der Ermächtigung Hierarchie, sie sind, was die Menschen in einer Rolle zu tun. Beispiel Aufgaben in unserem Blog Anwendung könnte "Posts verwalten" - ein Kind der "Editor" Rolle, und "Write Beiträge" - ein Kind der Autor Rolle.</p>
<p>Aufgaben können auch andere Aufgaben und Tätigkeiten, wie die Kinder.</p>
<h4 id="help-operations">Operations</h4>
<p>Operationen sind die unterste Ebene in der Zulassung Hierarchie, sie sind die Maßnahmen zur Durchführung einer Aufgabe. Operations in der Blog-Beispiel wäre "Create Post" und "Bearbeiten Eigene Post" (dies erfordert eine B<em><?php echo CHtml::link('Business Rule', '#help-business-rules'); ?>)</em>) als Kinder des "Write Beiträge" Aufgabe "freischalten Post" - Kind der "Manage Beiträge" Aufgabe und das " Assistant Editor "Rolle und" Post bearbeiten "und" Löschen Post "- Kinder der" Manage Beiträge "Aufgabe.</p>
<p>Operationen können nur andere Operationen als Kinder.</p>
<h3 id="help-business-rules">Business Rules</h3>
<p>Eine Genehmigung  Item kann eine <em>business rule</em>. Ein business rule ist ein Stück PHP-Code ausgeführt wird, wenn die Überprüfung von Zugriffsberechtigungen für das item ist, es muss <code>true</code> um Erlaubnis erteilen zurück, die "Guest" und "Authorised" Rollen Einsatz von Geschäftsregeln prüft, ob die Benutzer angemeldet ist.</p>
<p>Die Geschäftsregeln können auf zwei Variablen beziehen: <em>$params</em> und <em>$data</em>. <em>$params</em> kommt von der Anwendung und wird verwendet, um in den Parametern von der Business Rule erforderlich weitergeben.</p>
<p> Im Blog Beispiel wollen wir sicherstellen, dass Benutzer nur Beiträge editieren sie geschaffen hat und dass sie nicht so einmal ein Post genehmigt tun. Dazu verwenden wir eine Business Rule, der vergeht, die Post in die <em>$params</em> Variable ist, so etwas wie:</p>
<pre>return Yii::app()->user-&gt;id==$params["post"]-&gt;authorID && !$params["post"]-&gt;approved;</pre>
<p>Früher haben wir definiert den "Assistant Editor" Rolle; Benutzer mit der Rolle kann genehmigen Beiträge bis zu einer bestimmten Länge. Um dies zu überprüfen nutzen wir sowohl die <em>$params</em> und <em>$data</em> Variablen in einem Business-Rule für den Assistant Editor Rolle nach dem Vorbild der:</p>
<pre>return strlen($params["post"]-&gt;content)&lt;=$data;</pre>
<h3 id="help-data">Data</h3>
<p>Eine Genehmigung Item können zusätzliche Daten, die in der Business Rule mit dem <em>$data</em> Variable bezeichnet wird. Im obigen Beispiel <em>$data</em> ist die maximale Länge der Post den Assistant Editor Rolle kann genehmigen und so ist ein Integer-Wert.</p>
<h3>Genehmigung Zuweisungen</h3>
<p>Genehmigung Zuordnungen zuweisen Rollen zu Benutzern. Die Zuordnung kann eine Business Rule und Daten, um die Berechtigungen der Rolle gewährt für einen bestimmten Benutzer anpassen.</p>