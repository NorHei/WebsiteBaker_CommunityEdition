<?php
/**
 *
 * @category        modules
 * @package         output_filter
 * @author          WebsiteBaker Project
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2011, Website Baker Org. e.V.
 * @link            http://www.websitebaker2.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.2.2 and higher
 * @version         $Id: DE.php 1475 2011-07-12 23:07:10Z Luisehahne $
 * @filesource      $HeadURL: svn://isteam.dynxs.de/wb_svn/wb280/tags/2.8.3/wb/modules/output_filter/languages/DE.php $
 * @lastmodified    $Date: 2011-07-13 01:07:10 +0200 (Mi, 13. Jul 2011) $
 *
 */

// Deutsche Modulbeschreibung
$module_description          = 'Dieses Modul erlaubt die Filterung von Inhalten vor der Anzeige im Frontend.';

// Ueberschriften und Textausgaben
$OPF['HEADING']             = 'Optionen: Ausgabefilterung';
$OPF['HOWTO']               = '&Uuml;ber nachfolgende Optionen kann die Ausgabefilterung konfiguriert werden.<p style="line-height:1.5em;"><strong>Tipp: </strong>Mailto Links k&ouml;nnen mit einer Javascript-Routine verschl&uuml;sselt werden. Um diese Option zu aktivieren, muss der PHP-Befehl <code style="background:#FFA;color:#900;">&lt;?php register_frontend_modfiles(\'js\');?&gt;</code> im &lt;head&gt; der index.php Ihres Templates eingebunden werden. Ohne diese &Auml;nderungen wird nur das @ Zeichen im mailto:-Teil ersetzt.</p>';
$OPF['WARNING']             = '';

// Text von Form Elementen
$OPF['BASIC_CONF']          = 'Grundeinstellungen';
$OPF['SYS_REL']             = 'Frontendausgabe mit relativen URLs';
$OPF['EMAIL_FILTER']        = 'Filtere E-Mail Adressen im Text';
$OPF['MAILTO_FILTER']       = 'Filtere E-Mail Adressen in mailto-Links';
$OPF['ENABLED']             = 'Aktiviert';
$OPF['DISABLED']            = 'Deaktiviert';

$OPF['REPLACEMENT_CONF']    = 'E-Mail-Ersetzungen';
$OPF['AT_REPLACEMENT']      = 'Ersetze "@" durch';
$OPF['DOT_REPLACEMENT']     = 'Ersetze "." durch';


$OPF['ALL_ON_OFF'] = 'Alle Filter aktivieren/deaktivieren';
$OPF['DROPLETS'] = 'Droplets-Filter';
$OPF['WBLINK'] = 'wblink-Filter';
$OPF['INSERT'] = 'CSS-, JS-, Meta-Insert-Filter';
$OPF['JS_MAILTO'] = 'Javascript für Mailto-Filter';
$OPF['SHORT_URL'] = 'Short Url Filter(kein /pages/, kein .php)';
$OPF['CSS_TO_HEAD'] = 'CSS in den Head transferieren';