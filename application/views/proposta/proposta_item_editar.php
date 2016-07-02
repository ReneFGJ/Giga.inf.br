<!-- Large modal -->
<?php echo form_open(base_url('index.php/main/proposta_editar/' . $id_pp.'/'.checkpost_link($id_pp))); ?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="item_editar_<?php echo $id_pi;?>" id="item_editar_<?php echo $id_pi;?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="pad5">
			<div class="modal-header">
				<h4 class="modal-title" id="gridSystemModalLabel">Editar produto</h4>
			</div>
			<div class="modal-body" id="proposta_item">
				<?php echo $dados_item_form; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Close
				</button>
				<input type="submit" class="btn btn-primary" value="atualizar >>>">
			</div>

		</div>

	</div>
</div>
</form>
