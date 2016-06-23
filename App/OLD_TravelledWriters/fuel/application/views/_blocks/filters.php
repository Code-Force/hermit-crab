<div id="options" class="clearfix combo-filters">
    <div id="reset_filters">
        <div data-filter-value="" data-filter-group="reset" class="filter reset_filters"></div>
    </div>
    <div id="continent-options">
        <?php
        $continent_preselected = '';
        $tags_favourites = '';
        $tags_preselected = '';
        $continents_get = '';
        if (isset($_GET['continent'])) {
            $continents_get = $_GET['continent'];
            $continents = explode(':',$_GET['continent']);
            foreach ($continents as $continent){
                $continent_preselected .= 'continent:'.$continent.',';
            }
        }
        ?>
        <div data-filter-value="0" data-filter-group="continent" class="filter <?php if ($continents_get == '') { echo 'selected'; } ?> continents-all"></div>
        <div data-filter-value="6" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '6') !== false) { echo 'selected'; } ?> filter yellow">Oceania</div>
        <div data-filter-value="5" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '5') !== false) { echo 'selected'; } ?> filter red">Asia</div>
        <div data-filter-value="4" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '4') !== false) { echo 'selected'; } ?> filter orange">Africa</div>
        <div data-filter-value="3" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '3') !== false) { echo 'selected'; } ?> filter purple">Europe</div>
        <div data-filter-value="2" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '2') !== false) { echo 'selected'; } ?> filter green">South America</div>
        <div data-filter-value="1" data-filter-group="continent" class="a-continent <?php if (strpos($continents_get, '1') !== false) { echo 'selected'; } ?> filter blue">North America</div>
    </div>
    <?php if (isset($user) && !isset($user_viewed)) { ?>
        <div id="only_favourites">
            <?php
            if (isset($_GET['favourites'])) {
                $tags_favourites .= 'favourites:1,';
                ?>
                <div data-filter-value="1" data-filter-group="favourites" class="favourites selected filter" title="Show only my favourite users">Show Favourites</div>

            <?php
            } else {
                ?>
                <div data-filter-value="1" data-filter-group="favourites" class="favourites filter" title="Show only my favourite users">Show Favourites</div>

            <?php
            }
            ?>
        </div>
    <?php } ?>
    <?php
    if (isset($_GET['tag'])) {
        $tags_preselected = 'tag:'.$_GET['tag'].',';
        ?>
        <div id="tag-field">
            <input class="tag-filter-field" id="tag-filter-field" type="text" style="display: none" placeholder="Search with a tag..." />
        </div>
        <div id="tag-options">
            <div data-filter-value="<?= $_GET['tag']; ?>" data-filter-group="tag" class="filter tags-filtered selected" title="<?= str_replace('-', ' ', $_GET['tag']); ?>"><?= str_replace('-', ' ', $_GET['tag']); ?></div>
        </div>
    <?php
    } else {
        ?>
        <div id="tag-field">
            <input class="tag-filter-field" id="tag-filter-field" type="text" placeholder="Search with a tag..." />
        </div>
        <div id="tag-options">
        </div>
    <?php
    }
    ?>



</div>
<?php

$preselected = $continent_preselected.$tags_preselected.$tags_favourites;
if ($preselected != ''){
    $preselected = substr($preselected, 0, strlen($preselected) - 1);
}

?>

<input type="hidden" id="filters_selected" value="<?= $preselected; ?>" />
<script src="<?= base_url().'assets/js/masonry.pkgd.js'; ?>"></script>


<script>

    $(window).resize(function() {
        size_stories();
    });
    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'')
            ;
    }
    $(function(){
        var $dont_load_more = false;

        size_stories();
        $('#stories').masonry({
            columnWidth: 270,
            itemSelector: '.story'
        });
        $("#tag-filter-field").keyup(function (e) {
            if (e.keyCode == 13) {


                var $tag_slug = convertToSlug($.trim($("#tag-filter-field").val()));
                var $tag = $.trim($("#tag-filter-field").val()).toLowerCase().replace(/[^a-z0-9\s]/gi, '');
                if ($tag_slug != '') {
                    $is_fetching = true;
                    $('.loading_loader').show();
                    $('#stories').html('');
                    window.scrollTo(0, 0);
                    $('#tag-options').html('<div data-filter-value="' + $tag_slug + '" data-filter-group="tag" class="filter tags-filtered selected" title="'+ $tag + '">' + $tag + '</div>');

                    $("#tag-filter-field").val('');
                    $("#tag-filter-field").hide();
                    size_stories();
                    each_selected_filter();
                }

            }
        });
        size_stories();

        filters = {};
        var $is_fetching = false;
        var $reload_loader = false;
        function each_selected_filter(){
            $filters = '';
            $.each($('.selected'), function() {
                $filters = $filters + $(this).attr('data-filter-group') + ':' + $(this).attr('data-filter-value') + ',';

            });
            $('#filters_selected').val($filters.substr(0, $filters.length - 1));
            var $query_string = $('#filters_selected').val().split(',');
            var $continents = '';
            var $favourites = '';
            var $tags = '';
            var $push = '';
            jQuery.each($query_string, function(index, value) {
                var $this_filter =  value.split(':');
                if (($this_filter[0] == 'continent') && ($this_filter[1] > 0) && ($this_filter[1] < 7)) {
                    $continents = $continents + $this_filter[1] + ':';
                }
                if ($this_filter[0] == 'tag') {
                    $tags = $tags + $this_filter[1] + ':';
                }
                if ($this_filter[0] == 'favourites') {
                    $favourites = 'favourites=true';
                }

            });
            if ($tags != ''){
                $push = $push + 'tag='+($tags.substr(0, $tags.length - 1))+'&';
            }
            if ($continents != ''){
                $push = $push + 'continent='+($continents.substr(0, $continents.length - 1))+'&';
            }
            if ($favourites != ''){
                $push = $push + $favourites+'&';
            }
            $push = ($push.substr(0, $push.length - 1));


            <?php if (isset($user_viewed)) { ?>
                if ($push != '') {
                    window.history.replaceState('Discover', 'Discover', '/<?= $user_viewed['username'] ?>?'+$push);
                } else {
                    window.history.replaceState('Discover', 'Discover', '/<?= $user_viewed['username'] ?>');
                }
            <?php } else { ?>
                if ($push != '') {
                    window.history.replaceState('Discover', 'Discover', '/discover?'+$push);
                } else {
                    window.history.replaceState('Discover', 'Discover', '/discover');
                }
            <?php } ?>

            get_more_stories();

        }
        <?php if (isset($user_viewed)) { ?>
        var blogger_id = 'blogger_id=' + <?= $user_viewed['blogger_id'] ?>+'&';
        <?php } else { ?>
        var blogger_id = '';
        <?php } ?>
        function get_more_stories($added) {
            var $last_story = $(".story").last().attr('id');
            $.ajax({	//create an ajax request to load_page.php
                type: "POST",
                url: "getmorestories",
                data: blogger_id+'filters='+ encodeURIComponent($('#filters_selected').val())+'&last_story='+$last_story,	//with the page number as a parameter
                dataType: "html",	//expect html to be returned
                success: function(data){
                    $('.loading_loader').hide();

                    if (data == 'end_of_results') {
                        $('#search_errors').html('<div class="search_message"><img src="<?= base_url().'assets/images/icons/no-results.png';?>" /><br /><br />End of results for this filter.</div>');
                        $('#search_errors').show();
                        $dont_load_more = true;
                    } else if (data == 'favourites') {
                        $('#search_errors').html('<div class="search_message"><img src="<?= base_url().'assets/images/icons/no-favourites.png';?>" /><br /><br />You haven\'t followed anyone yet!<br /><br />Please try some new filters.</div>');
                        $('#search_errors').show();
                        $dont_load_more = true;

                    } else if (data !== '') {
                        if ($('#stories').html() == '') {
                            $('#stories').html(data);
                            size_stories();
                            $('#stories').masonry({
                                columnWidth: 270,
                                itemSelector: '.story'
                            });

                        } else {
                            var el = jQuery(data);
                            jQuery("#stories").append(el).masonry( 'appended', el, true );
                        }
                        $dont_load_more = false;


                    } else {
                        $('#search_errors').html('<div class="search_message"><img src="<?= base_url().'assets/images/icons/no-results.png';?>" /><br /><br />No results found.<br /><br />Please try some new filters.</div>');
                        $('#search_errors').show();
                        $dont_load_more = true;

                    }
                    addthis.toolbox(".addthis_toolbox");
                    $reload_loader = true;
                    $is_fetching = false;
                    return false;


                }
            });
        }
        $('.filter').on('click', function() {
            $('#search_errors').hide();
            $('#search_errors').html('');

            $dont_load_more = false;

            if(!$is_fetching) {

                /*$('#stories').fadeOut('fast', function() {
                 $('#stories').html($('#loading_holder').html());
                 $('#stories').fadeIn('fast');
                 });*/

                $is_fetching = true;

                //var $removable = $container.find( '.story' );
                $('.loading_loader').show();
                $('#stories').masonry('destroy');
                $('#stories').html('');
                window.scrollTo(0, 0);

                $this = $(this);
                if ($this.hasClass('reset_filters')) {
                    $('.a-continent').removeClass('selected');
                    $('.favourites').removeClass('selected');
                    $('.continents-all').addClass('selected');
                    $('#tag-options').html('');
                    $("#tag-filter-field").show();
                    size_stories();
                    each_selected_filter();
                    return false;
                }

                if ($this.hasClass('continents-all')) {

                    if ($this.hasClass('selected')) {
                    } else {
                        $('.a-continent').removeClass('selected');
                        $this.addClass('selected');
                        each_selected_filter();
                        return false;
                    }
                }
                if ($this.hasClass('tags-filtered')) {
                    $('#tag-options').html('');
                    $("#tag-filter-field").show();
                    size_stories();
                } else {
                    if ($this.hasClass('tags-filter')) {

                        $this_tag = $(this);
                        var $add_new_tag = true;
                        var $new_tag = '';
                        $('#tag-options div').each(function(){
                            if ($this_tag.attr('data-filter-value') == $(this).attr('data-filter-value')) {
                                $add_new_tag = false;
                            }
                        });

                        if ($add_new_tag == true) {
                            $("#tag-filter-field").val('');
                            $("#tag-filter-field").hide();
                            $('#tag-options').html('<div data-filter-value="'+ $this_tag.attr('data-filter-value') + '" data-filter-group="tag" class="filter tags-filtered selected" title="'+ $this_tag.html() + '">'+ $this_tag.html() + '</div>');
                        }
                        size_stories();

                    }
                }

                if ($this.hasClass('selected')) {


                    $this.removeClass('selected');
                    each_selected_filter();
                    return false;
                } else {
                    $this.addClass('selected');

                    if ($this.hasClass('a-continent')) {
                        $('.continents-all').removeClass('selected');
                    }
                    each_selected_filter();
                    return false;
                }
                return false;
            } else {
                e.preventDefault();
            }

        });

        $(window).scroll(function () {
            if (($(window).scrollTop() + $(window).height()) >= ($(document).height()-400)) {
                if (($is_fetching == false) && ($dont_load_more == false)) {
                    $is_fetching = true;
                    $('.loading_loader').show();
                    get_more_stories();
                    return false;
                }
            }
        });

    });
</script>