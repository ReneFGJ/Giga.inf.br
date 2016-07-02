<!-- Button trigger modal -->
<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novo_item">
	Incluir novo item
</button>

<?php echo form_open(base_url('index.php/main/proposta_editar/' . $id_pp.'/'.checkpost_link($id_pp))); ?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="novo_item">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="pad5">
			<div class="modal-header">
				<h4 class="modal-title" id="gridSystemModalLabel">Novo produto</h4>
			</div>
			<div class="modal-body" id="proposta_item">
				<?php echo $dados_item_form; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Close
				</button>
				<input type="submit" class="btn btn-primary" value="adicionar >>>">
			</div>

		</div>

	</div>
</div>
</form>
