<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$code = $module;
?>

<div id="<?php echo $module ?>_tabs" style="height:95%">
    <ul style="-moz-border-radius-bottomleft: 0; -moz-border-radius-bottomright: 0;width:100%;padding:0 0 0 0;margin:0 0 0 0">
        <li id="<?php echo $module ?>_list_li"><a id="<?php echo $module ?>_list_a" href="#<?php echo $module ?>_list_tab"><?php echo _List ?></a></li>
        <li id="<?php echo $module ?>_edit_li"><a id="<?php echo $module ?>_edit_a" href="#<?php echo $module ?>_edit_tab"><?php echo Edit ?></a></li>
        <li id="<?php echo $module ?>_add_li"><a id="<?php echo $module ?>_add_a" href="#<?php echo $module ?>_add_tab"><?php echo Add ?></a></li>
    </ul>
    <div id="<?php echo $module ?>_list_tab"></div>
    <div id="<?php echo $module ?>_edit_tab"></div>
    <div id="<?php echo $module ?>_add_tab"></div>
</div>


<script type="text/javascript">

    $('#<?php echo $module ?>_list_a').click(function() {
        $('#<?php echo $code ?>_btn_close').show();
<?php if ($privilege != 4) { ?>
            $('#<?php echo $code ?>_btn_new').show();
<?php } ?>
        $('#<?php echo $code ?>_btn_edit').hide();
        $('#<?php echo $code ?>_btn_addsave').hide();
        $('#<?php echo $code ?>_btn_addcancel').hide();
        $('#<?php echo $code ?>_btn_editsave').hide();
        $('#<?php echo $code ?>_btn_editdelete').hide();
        $('#<?php echo $code ?>_btn_editcancel').hide();
        $('#<?php echo $code ?>_btn_clear').hide();

    });

    $('#<?php echo $module ?>_add_a').click(function() {
        $('#<?php echo $code ?>_btn_clear').show();
        $('#<?php echo $code ?>_btn_new').hide();
        $('#<?php echo $code ?>_btn_edit').hide();
        $('#<?php echo $code ?>_btn_close').hide();
        $('#<?php echo $module ?>_add_li').show();
        $('#<?php echo $code ?>_btn_addsave').show();
        $('#<?php echo $code ?>_btn_addcancel').show();
        $('#<?php echo $module ?>_edit_li').hide();
        $('#<?php echo $code ?>_btn_editsave').hide();
        $('#<?php echo $code ?>_btn_editdelete').hide();

    });

    $('#<?php echo $module ?>_edit_a').click(function() {
        $('#<?php echo $code ?>_btn_clear').show();
        $('#<?php echo $code ?>_btn_new').hide();
        $('#<?php echo $code ?>_btn_edit').hide();
        $('#<?php echo $code ?>_btn_close').hide();
        $('#<?php echo $module ?>_edit_li').show();
        $('#<?php echo $module ?>_add_li').hide();
        $('#<?php echo $code ?>_btn_editsave').show();
        $('#<?php echo $code ?>_btn_editdelete').show();
        $('#<?php echo $code ?>_btn_editcancel').show();
    })

    function Delete_collection(cid) {
        var u = 'contents/collections/_cmd.php?type=3&id=' + cid;
        $.ajax({
            type: 'POST',
            url: u,
            // timeout: 2000,    
            success: function(data) {
                ShowMessage(data);
                $('#<?php echo $module ?>_list_tab').html(geturl('contents/collections/_list.php'));
                // refresh_selectoption();   

                //window.setTimeout(update, 10000);   
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ShowMessage('Timeout contacting server..');
                //  window.setTimeout(update, 60000);    
            }});


    }
    ;

    $('#<?php echo $module ?>_tabs').tabs({event: "click", fx: {opacity: 'toggle'}});


<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_edit', '<?php echo Edit ?>', '<?php echo $code ?>editForm', 'edit');

<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_new', '<?php echo Add ?>', '<?php echo $code ?>newForm', 'add');


<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');

<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_addsave', '<?php echo Save ?>', '<?php echo $code ?>addsave', 'save');
<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_addcancel', '<?php echo Cancel ?>', '<?php echo $code ?>addcancel', 'cancel');

<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_editsave', '<?php echo Save ?>', '<?php echo $code ?>editsave', 'save');
<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_editdelete', '<?php echo Delete ?>', '<?php echo $code ?>editdelete', 'delete');
<?php echo $code ?>Dialog.addButton('<?php echo $code ?>_btn_editcancel', '<?php echo Cancel ?>', '<?php echo $code ?>editcancel', 'cancel');

<?php echo $module ?>Dialog.setOption('title', '<?php echo Collections ?>');

    $(function() {

        $('#<?php echo $module ?>_add_li').hide();
        $('#<?php echo $module ?>_edit_li').hide();
<?php if ($privilege == 4) { ?>
            $('#<?php echo $code ?>_btn_new').hide();
<?php } ?>
        $('#<?php echo $code ?>_btn_edit').hide();
        $('#<?php echo $code ?>_btn_addsave').hide();
        $('#<?php echo $code ?>_btn_editsave').hide();
        $('#<?php echo $code ?>_btn_editdelete').hide();
        $('#<?php echo $code ?>_btn_clear').hide();
        $('#<?php echo $code ?>_btn_addcancel').hide();
        $('#<?php echo $code ?>_btn_editcancel').hide();

    });

    $('#<?php echo $module ?>_list_tab').html(geturl('contents/collections/_list.php'));
    $('#<?php echo $module ?>_add_tab').html(geturl('contents/collections/_form.php?type=1'));
    $('#<?php echo $module ?>_edit_tab').html(geturl('contents/collections/_form.php?type=2'));

    function <?php echo $code ?>editdelete() {
        $('#<?php echo $code ?>_edit_li').hide();
        $('#<?php echo $code ?>_list_a').click();
        $('#<?php echo $code ?>_tabs').tabs("option", "active", 0);
        Delete_collection($('#<?php echo $module_edit ?>id').val());

    }
    ;

    function <?php echo $code ?>editsave() {
        $('#<?php echo $module_edit ?>form').submit();
        $('#<?php echo $code ?>_edit_li').hide();
        $('#<?php echo $code ?>_list_a').click();
        $('#<?php echo $code ?>_tabs').tabs("option", "active", 0);

    }
    ;

    function <?php echo $code ?>addsave() {
        $('#<?php echo $module_add ?>form').submit();

    }
    ;


    function <?php echo $code ?>editForm() {
        $('#<?php echo $code ?>_edit_a').click();

    }
    ;

    function <?php echo $code ?>newForm() {
        $('#<?php echo $code ?>_add_a').click();

    }
    ;

    function <?php echo $code ?>Close() {
<?php echo $module ?>Dialog.Close();

   }
   ;


   function <?php echo $code ?>addcancel() {
       $("#<?php echo $code ?>_list_a").click();
       $('#<?php echo $code ?>_add_li').hide();

   }
   ;

   function <?php echo $code ?>editcancel() {
       $("#<?php echo $code ?>_list_a").click();
       $('#<?php echo $code ?>_edit_li').hide();


   }
   ;


</script>