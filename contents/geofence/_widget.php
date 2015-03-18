<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
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
        $('#<?php echo $module ?>_btn_close').show();
<?php if ($privilege != 4) { ?>
            $('#<?php echo $module ?>_btn_new').show();
<?php } ?>
        $('#<?php echo $module ?>_btn_edit').hide();
        $('#<?php echo $module ?>_btn_addsave').hide();
        $('#<?php echo $module ?>_btn_reset').hide();
        $('#<?php echo $module ?>_btn_addcancel').hide();
        $('#<?php echo $module ?>_btn_editsave').hide();
        $('#<?php echo $module ?>_btn_editdelete').hide();
        $('#<?php echo $module ?>_btn_editcancel').hide();
        $('#<?php echo $module ?>_btn_clear').hide();

    });

    $('#<?php echo $module ?>_add_a').click(function() {
        $('#<?php echo $module ?>_btn_clear').show();
        $('#<?php echo $module ?>_btn_new').hide();
        $('#<?php echo $module ?>_btn_edit').hide();
        $('#<?php echo $module ?>_btn_close').hide();
        $('#<?php echo $module ?>_add_li').show();
        $('#<?php echo $module ?>_btn_reset').show();
        $('#<?php echo $module ?>_btn_addsave').show();
        $('#<?php echo $module ?>_btn_addcancel').show();
        $('#<?php echo $module ?>_edit_li').hide();
        $('#<?php echo $module ?>_btn_editsave').hide();
        $('#<?php echo $module ?>_btn_editdelete').hide();

    });

    $('#<?php echo $module ?>_edit_a').click(function() {
        $('#<?php echo $module ?>_btn_clear').show();
        $('#<?php echo $module ?>_btn_new').hide();
        $('#<?php echo $module ?>_btn_edit').hide();
        $('#<?php echo $module ?>_btn_close').hide();
        $('#<?php echo $module ?>_edit_li').show();
        $('#<?php echo $module ?>_add_li').hide();
        $('#<?php echo $module ?>_btn_editsave').show();
        $('#<?php echo $module ?>_btn_editdelete').show();
        $('#<?php echo $module ?>_btn_editcancel').show();
    });

    $('#<?php echo $module ?>_tabs').tabs({event: "click", fx: {opacity: 'toggle'}});


<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_edit', '<?php echo Edit ?>', '<?php echo $module ?>editForm', 'edit');

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_new', '<?php echo Add ?>', '<?php echo $module ?>newForm', 'add');

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');


<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_reset', '<?php echo Reset ?>', '<?php echo $module ?>Reset', 'reset');

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_addsave', '<?php echo Save ?>', '<?php echo $module ?>addsave', 'save');

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_addcancel', '<?php echo Cancel ?>', '<?php echo $module ?>addcancel', 'cancel');

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_editsave', '<?php echo Save ?>', '<?php echo $module ?>editsave', 'save');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_editdelete', '<?php echo Delete ?>', '<?php echo $module ?>editdelete', 'delete');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>_btn_editcancel', ' <?php echo Cancel ?>', '<?php echo $module ?>editcancel', 'cancel');


    $(function() {
        $('#<?php echo $module ?>_add_li').hide();
        $('#<?php echo $module ?>_edit_li').hide();
<?php if ($privilege == 4) { ?>
            $('#<?php echo $module ?>_btn_new').hide();
<?php } ?>
        $('#<?php echo $module ?>_btn_edit').hide();
        $('#<?php echo $module ?>_btn_addsave').hide();
        $('#<?php echo $module ?>_btn_editsave').hide();
        $('#<?php echo $module ?>_btn_editdelete').hide();
        $('#<?php echo $module ?>_btn_reset').hide();
        $('#<?php echo $module ?>_btn_addcancel').hide();
        $('#<?php echo $module ?>_btn_editcancel').hide();
<?php echo $module ?>Dialog.setOption('title', '<?php echo Geofences ?>');

                  });

                  $('#<?php echo $module ?>_list_tab').load('contents/<?php echo $loc ?>/_list.php');
                  $('#<?php echo $module ?>_add_tab').load('contents/<?php echo $loc ?>/_form.php?type=1');
                  $('#<?php echo $module ?>_edit_tab').load('contents/<?php echo $loc ?>/_form.php?type=2');

                  function <?php echo $module ?>editdelete() {
                      $('#<?php echo $module ?>_edit_li').hide();
                      $('#<?php echo $module ?>_list_a').click();
                      $('#<?php echo $module ?>_tabs').tabs("option", "active", 0);
                      del_geofence($('#<?php echo $module ?>_list option:selected').val());
                      DrawingGeoFence.reset();
                      DrawingGeoFence.draw();
                  }
                  ;

                  function <?php echo $module ?>editsave() {
                      $('#<?php echo $module_edit ?>form').submit();
                      $('#<?php echo $module ?>_edit_li').hide();
                      $('#<?php echo $module ?>_list_a').click();
                      $('#<?php echo $module ?>_tabs').tabs("option", "active", 0);
                      DrawingGeoFence.reset();
                  }
                  ;

                  function <?php echo $module ?>addsave() {
                      $('#<?php echo $module_add ?>form').submit();
                      DrawingGeoFence.reset();
                      DrawingGeoFence.draw();
                  }
                  ;


                  function <?php echo $module ?>editForm() {
                      $('#<?php echo $module ?>_edit_a').click();
                      DrawingGeoFence.reset();
                      DrawingGeoFence.draw();
                      get_geofence_data();
                  }
                  ;

                  function <?php echo $module ?>newForm() {
                      $('#<?php echo $module ?>_add_a').click();
                      DrawingGeoFence.reset();
                      DrawingGeoFence.draw();
                  }
                  ;

                  function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();
               DrawingGeoFence.reset();
           }
           ;


           function <?php echo $module ?>addcancel() {
               $("#<?php echo $module ?>_list_a").click();
               $('#<?php echo $module ?>_add_li').hide();
<?php echo $module ?>Reset();
              DrawingGeoFence.reset();
          }
          ;
          function <?php echo $module ?>Reset() {
              $("#<?php echo $module_add ?>form")[0].reset();
              DrawingGeoFence.reset();
              DrawingGeoFence.draw();
          }
          ;

          function <?php echo $module ?>editcancel() {
              $("#<?php echo $module ?>_list_a").click();
              $('#<?php echo $module ?>_edit_li').hide();
              DrawingGeoFence.reset();
          }
          ;


</script>