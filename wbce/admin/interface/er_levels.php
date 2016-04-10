<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * Way Better Content Editing.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// no direct file access
if(count(get_included_files())==1) header("Location: ../index.php",TRUE,301);

$ER_LEVELS = array(
    ''  => isset($TEXT['SYSTEM_DEFAULT']) ? $TEXT['SYSTEM_DEFAULT'] : 'System Default',
    '0' => 'E_NONE',
    '6143' => 'E_ALL',
    '6135' => 'E_ALL^E_NOTICE', // standard: E_ALL without E_NOTICE
    '8191' => 'E_ALL&E_STRICT', // for programmers
    '-1'   => 'E_EVERYTHING'
);
