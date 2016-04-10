<?php

/*
  Lepton Project <http://www.lepton-cms.org/>
  Copyright (C) 2010, Lepton Project

*/

// prevent this file from being accessed directly
if ( !defined('WB_PATH'))
{
    die(header('Location: index.php'));
}
?>
<script src="<?php echo WB_URL ?>/modules/nicEdit/nicEdit/nicEdit.js" type="text/javascript"></script>
<?php

function reverse_htmlentities($mixed)
{
    $mixed = str_replace(array( '&gt;', '&lt;', '&quot;', '&amp;' ), array( '>', '<', '"', '&' ), $mixed);
    return $mixed;
}

function show_wysiwyg_editor($name, $id, $content, $width = '100%', $height = '350px')
{
    $config = "fullPanel :true, iconsPath : '".WB_URL."/modules/nicEdit/nicEdit/nicEditorIcons.gif'";
        echo '<script type="text/javascript">'
        .'bkLib.onDomLoaded(function(){'
        .'nicEditors.allTextAreas({'.$config.'}) });'
        .'</script>'
        .'<textarea name="'.$name.'" id="'.$id.'" style="width: '.$width.'; height: '.$height.';">'.$content.'</textarea>';
}
                        
?>