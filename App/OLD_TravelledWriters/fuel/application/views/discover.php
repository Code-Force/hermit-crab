<?php fuel_set_var('layout', '');

$this->load->view('_blocks/header');
$this->load->view('_blocks/filters');

//var_dump($stories);
?>




<div id="stories" class="variable-sizes clearfix">
    <?php
    echo $stories;
    ?>
</div> <!-- #container -->
<div id="search_errors" class="clearfix">
</div>
<div class="loading_loader"><img src="<?= base_url().'assets/images/load-stories.gif';?>" /> </div>



    <!-- AddThis Smart Layers BEGIN -->
    <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525b4a9c082fa427"></script>
    <script type="text/javascript">
        addthis.layers({
            'theme' : 'transparent',
            'share' : {
                'position' : 'left',
                'numPreferredServices' : 6
            }
        });
    </script>
    <!-- AddThis Smart Layers END -->
<?php
$this->load->view('_blocks/footer');
