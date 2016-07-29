<?php
if (!isset($dd89)) {
	$dd89 = '';
	$dd89 = $this -> input -> post('dd89');
}
if (!isset($link_form)) {
	$link_form = '';
}
?>
<div id="form_search">
	<form method="post" action="<?php echo $link_form;?>">
		<BR>
		<table cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td colspan=2><?php echo $this->lang->line('fast_search');?></td>
			</tr>
			<tr>
				<td>
				<input type="text" name="dd89" id="dd89" class="form_search_in" value="<?php echo $dd89;?>" placeholder="<?php echo $this->lang->line('fast_search_place');?>">
				</td>
				<td>
				<input type="submit" name="acao" id="acao" class="btn btn-default" value="BUSCA">
				</td>
			</tr>
		</table>
		<BR>
	</form>
</div>

<br>
<br>
<br>
<br>
<br>
