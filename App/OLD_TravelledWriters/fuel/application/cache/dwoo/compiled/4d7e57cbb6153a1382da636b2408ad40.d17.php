<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><!--__FUEL_MARKER__7--><?php $this->scope["project"]=fuel_model('projects', array('find'=>'one', 'where'=>array('featured'=>'yes'), 'order'=>'RAND()'))?>


<?php if (( (isset($this->scope["project"]) ? $this->scope["project"] : null) )) {
?>
<div id="block_showcase">
	<h3><?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["project"], false);?></h3>
	<img src="<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'image_path',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["project"], false);?>" />
</div>
<?php 
}
 /* end template body */
return $this->buffer . ob_get_clean();
?>