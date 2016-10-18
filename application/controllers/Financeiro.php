<?php
class Financeiro extends CI_Controller {
	function __construct() {
		global $dd, $acao;
		parent::__construct();
		$this -> lang -> load("app", "portuguese");
		$this -> load -> helper('form_sisdoc');
		$this -> load -> helper('email');
		$this -> load -> model('users');

		date_default_timezone_set('America/Sao_Paulo');
	}

	function cab($data = array()) {
		$js = array();
		$css = array();
		array_push($js, 'form_sisdoc.js');
		array_push($js, 'jquery-ui.min.js');

		$data['js'] = $js;
		$data['css'] = $css;

		$data['title'] = ':: Giga Informática ::';
		$this -> load -> view('header/header', $data);

		if (!(isset($data['nocab']))) {
			$this -> load -> view('menus/menu_cab_top', $data);
		} else {
			$this -> load -> view('menus/no_cab_top', $data);
		}

		$this -> load -> model('users');
		$this -> users -> security();
	}

	function footer() {
		$this -> load -> view('header/footer', null);
	}

	function index() {
		$this -> cab();
		$this -> load -> view('home', null);
		$this -> footer();
	}

	function caixa() {
		$this -> load -> model('financeiros');
		$dia = date("Y-m-d");
		$this -> cab();
		$tela = $this -> financeiros -> caixa_dia($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function cpagar($dia = '') {
		$this -> load -> model('financeiros');

		/* Importar */
		//$this->load->model('imports');
		//$this->imports->cpagar();

		if (strlen($dia) == 0) {
			$dia = date("Ymd");
		}
		$this -> cab();
		$data['date'] = $dia;
		$data['calendario'] = $this -> financeiros -> calendario($dia, 1);
		$data['saldo'] = $this -> financeiros -> saldo_dia($dia, 1);
		$this -> load -> view('financeiro/navbar_cx', $data);
		$tela = $this -> financeiros -> contas_pagar($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber($dia = '') {
		$this -> load -> model('financeiros');

		/* Importar */
		$this -> load -> model('imports');
		//$this->imports->creceber();

		if (strlen($dia) == 0) {
			$dia = date("Ymd");
		}
		$this -> cab();
		$data['date'] = $dia;
		$data['calendario'] = $this -> financeiros -> calendario($dia, 2);
		$data['saldo'] = $this -> financeiros -> saldo_dia($dia, 2);
		$this -> load -> view('financeiro/navbar_cr_cx', $data);
		$tela = $this -> financeiros -> contas_receber($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber_quitar($id = 0, $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_quitar();
		$form = new form;
		$form -> id = $id;
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_receber);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_quitar($id = 0, $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_quitar();
		$form = new form;
		$form -> id = $id;
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_pagar);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$tabela = $this -> financeiros -> table_pagar;
		$parcelas = round(get("dd5"));
		
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_editar($id);
		$form = new form;
		$form -> id = $id;
		
		$vlr = get("dd11");
		$vlr = troca($vlr,'.','');
		$vlr = troca($vlr,',','.');
		$_POST['dd12'] = $vlr;

		$data['content'] = $form -> editar($cp, $tabela);		
		

		$data['title'] = '';
		$this -> load -> view('content', $data);
		
		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_edit_multi($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$tabela = $this -> financeiros -> table_pagar;
		$parcelas = round(get("dd5"));
		
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_editar_multi($id);
		$form = new form;
		$form -> id = $id;
		$vlr = get("dd11");
		$vlr = troca($vlr,'.','');
		$vlr = troca($vlr,',','.');
		$_POST['dd12'] = $vlr;

		if ($id==0)
			{
				$data['content'] = $form -> editar($cp, '');
			} else {
				$data['content'] = $form -> editar($cp, $tabela);		
			}
		

		$data['title'] = '';
		$this -> load -> view('content', $data);
		
		if ($form -> saved > 0) {
			$perio = get("dd6");
			$venc = brtos(get("dd1"));
			$cp[5][3] = False;
			
			if ($parcelas > 1)
				{
					$_POST['dd5'] = strzero(1, 2) . '/' . strzero($parcelas, 2);	
				} else {
					$_POST['dd5'] = 'ÚNICA';					
				}
			$form -> editar($cp, $tabela);
			
			if ($form->saved <> 1)
				{
					echo 'OPS';
					exit;
				}				

			for ($r = 2; $r <= $parcelas; $r++) {
				$_POST['dd5'] = strzero($r, 2) . '/' . strzero($parcelas, 2);
				$prox_venc = stod(dateadd($perio, ($r - 1), $venc));
				$wk = date("N", $prox_venc);
				while ($wk > 5) {
					$prox_venc = stod(dateadd('d', -1, date("Ymd", $prox_venc)));
					$wk = date("N", $prox_venc);
				}
				$prox_venc = date("Ymd", $prox_venc);
				$_POST['dd1'] = stodbr($prox_venc);
				$data['content'] = $form -> editar($cp, $tabela);
			}

			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_contabil_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_contabil_editar();
		$form = new form;
		$form -> id = $id;
		$_POST['dd10'] = get("dd9");
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_pagar);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function creceber_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$tabela = $this -> financeiros -> table_receber;
		$parcelas = round(get("dd5"));
		
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_editar($id);
		$form = new form;
		$form -> id = $id;
		
		$vlr = get("dd11");
		$vlr = troca($vlr,'.','');
		$vlr = troca($vlr,',','.');
		$_POST['dd12'] = $vlr;

		$data['content'] = $form -> editar($cp, $tabela);		

		$data['title'] = '';
		$this -> load -> view('content', $data);
		
		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function creceber_edit_multi($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$tabela = $this -> financeiros -> table_receber;
		$parcelas = round(get("dd5"));
		
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_editar_multi($id);
		$form = new form;
		$form -> id = $id;
		$vlr = get("dd11");
		$vlr = troca($vlr,'.','');
		$vlr = troca($vlr,',','.');
		$_POST['dd12'] = $vlr;

		$data['content'] = $form -> editar($cp, '');


		$data['title'] = '';
		$this -> load -> view('content', $data);
		
		if ($form -> saved > 0) {
			$perio = get("dd6");
			$venc = brtos(get("dd1"));
			$cp[5][3] = False;
			
			if ($parcelas > 1)
				{
					$_POST['dd5'] = strzero(1, 2) . '/' . strzero($parcelas, 2);	
				} else {
					$_POST['dd5'] = 'ÚNICA';					
				}
			$form -> editar($cp, $tabela);
			
			if ($form->saved <> 1)
				{
					echo 'OPS';
					exit;
				}				

			for ($r = 2; $r <= $parcelas; $r++) {
				$_POST['dd5'] = strzero($r, 2) . '/' . strzero($parcelas, 2);
				$prox_venc = stod(dateadd($perio, ($r - 1), $venc));
				$wk = date("N", $prox_venc);
				while ($wk > 5) {
					$prox_venc = stod(dateadd('d', -1, date("Ymd", $prox_venc)));
					$wk = date("N", $prox_venc);
				}
				$prox_venc = date("Ymd", $prox_venc);
				$_POST['dd1'] = stodbr($prox_venc);
				$data['content'] = $form -> editar($cp, $tabela);
			}

			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	/***************** FISCAL ***********************/
	function fiscal($id = 0) {
		$this -> cab();
		$this -> load -> model('invoices');
		$data['title'] = 'Recibos de locação';
		$data['content'] = $this -> invoices -> row();
		$this -> load -> view('content', $data);
		$this -> footer();
	}

	function fiscal_new($id = 0) {
		/* Load Model */
		$this -> load -> model('invoices');
		$this -> load -> model('clientes');

		/* Controller */
		$this -> cab();
		$data = array();

		$form = new form;

		$form -> fd = array('id_f', 'f_nome_fantasia', 'f_razao_social', 'f_estado');
		$form -> lb = array('id', msg('f_nome_fantasia'), msg('f_razao_social'), msg('f_estado'));
		$form -> mk = array('', 'L', 'L', 'L');
		$form -> pre_where = ' f_ativo = 1 ';

		$form -> tabela = $this -> clientes -> table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/main/clientes_edit');
		$form -> row_view = base_url('index.php/financeiro/financeiro_recibo_novo');
		$form -> row = base_url('index.php/financeiro/fiscal_new');

		$data['title'] = 'Emitir novo recibo - Selecione o cliente';
		$data['content'] = row($form, $id);

		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function financeiro_recibo_novo($id, $chk = '', $conf = '') {
		/* Model */
		$this -> load -> model('clientes');
		$this -> load -> model('invoices');
		$sit = array();
		$filial = get("dd1");
		$cliente = get("dd0");

		if ((strlen($cliente) > 0) and (strlen($filial) > 0)) {
			$sit = $this -> invoices -> abrir_recibo($cliente, $filial);
		}

		$this -> cab();
		$data = $this -> clientes -> le($id);
		$this -> load -> view('cliente/show', $data);

		$sql = "select * from _filiais where fi_ativo";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$sx .= 'Emissor:<br>';
		$sx .= '<form>';
		$sx .= '<input type="hidden" value="' . $id . '" name="dd0">';
		$sx .= '<select name="dd1" id="dd1" class="form-control">' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sx .= '<option value="' . $line['id_fi'] . '">' . $line['fi_razao_social'] . ' (' . number_format($line['fi_aliquota'], 2, ',', '.') . '%)</option>' . cr();
		}
		$sx .= '</select>' . cr();
		$sx .= '<br>';
		$sx .= '<br>';
		$sx .= '<input type="submit" value="Confirmar" class="btn btn-primary" name="acao">';
		$sx .= ' | ';
		$sx .= '<a href="' . base_url('index.php/main') . '" class="btn btn-default">';
		$sx .= 'Cancelar';
		$sx .= '</a>';

		if (count($sit) > 0) {
			switch ($sit[0]) {
				case '1' :
					$dt = $this -> invoices -> le_last_cliente($id);
					$id = $dt['nrs_id'];
					$link = base_url('index.php/financeiro/fiscal_ver/' . $id . '/' . checkpost_link($id));
					$link = base_url('index.php/financeiro/fiscal');
					redirect($link);
					break;
				case '0' :
					$sx .= '
					<br><br>
					<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  ' . $sit[1] . '
					</div>
					';
					break;
			}
		}

		$data['title'] = 'Confirmar abertura do recibo?';
		$data['content'] = $sx;
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function fiscal_ver_recibo($id = 0) {
		$id = 1;
		$this -> load -> model('invoices');
		$data = array();
		$data = $this -> invoices -> le($id);

		$this -> load -> view('financeiro/invoice_locacao', $data);
	}

	function fiscal_ver($id = 0) {
		$this -> cab();
		$this -> load -> model('invoices');
		$data = array();
		$data = $this -> invoices -> le($id);
		$data['title'] = '';
		$data['content'] = $this -> load -> view('fiscal/invoice_locacao', $data, true);
		$this -> load -> view('content', $data);
		$ed = false;

		switch ($data['iv_situacao']) {
			case '1' :
				$data['ac'] = '1';
				$data['itens'] = $this -> invoices -> total_itens($id);
				$ed = true;
				break;
			case '2' :
				$data['ac'] = '2';
				break;
			case '9' :
				$data['ac'] = '9';
				break;
		}

		$data['content'] = $this -> invoices -> ver_itens($data, $ed);
		$this -> load -> view('content', $data);

		$data['content'] = $this -> load -> view('fiscal/acao', $data, true);
		$this -> load -> view('content', $data);
	}

	function fiscal_cancelar($id = 0, $chk = '') {
		$this -> load -> model('invoices');
		$this -> invoices -> cancelar_edicao($id);
		redirect(base_url('index.php/financeiro/fiscal_ver/' . $id . '/' . $chk));
	}

	function fiscal_editar($id = 0, $chk = '') {
		$this -> load -> model('invoices');
		$this -> invoices -> ativar_edicao($id);
		redirect(base_url('index.php/financeiro/fiscal_ver/' . $id . '/' . $chk));
	}

	function fiscal_fechar($id = 0, $chk = '') {
		$this -> load -> model('invoices');
		$data = $this -> invoices -> le($id);
		$cliente = $data['iv_cliente'];
		$this -> invoices -> fechar_edicao($id, $cliente);

		redirect(base_url('index.php/financeiro/fiscal_ver/' . $id . '/' . $chk));
	}

	function fiscal_pdf($id = 0) {
		$this -> load -> helper('tcpdf');
		$this -> load -> model('invoices');
		$data = array();
		$data = $this -> invoices -> le($id);
		$data['title'] = '';
		$data['pdf'] = true;
		$data['content'] = $this -> load -> view('fiscal/invoice_locacao', $data, true);
		$data['content'] .= $this -> invoices -> ver_itens($data, false) . '<br><br>';
		$data['content_foot'] = $this -> load -> view('fiscal/rodape', $data, true);

		$this -> load -> view("pdf/landscape", $data);
	}

	function fiscal_edit($id = '', $chk = '', $lc) {
		$this -> load -> model('invoices');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> invoices -> cp($lc);
		$form = new form;
		$form -> id = $id;
		$_POST['dd10'] = get("dd9");
		$data['content'] = $form -> editar($cp, $this -> invoices -> table_item);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_search() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_pagar');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$S80', '', 'Nome do fornecedor', false, true));
		array_push($cp, array('$H', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', false, true));
		array_push($cp, array('$D8', '', 'Vencimento final', false, true));
		array_push($cp, array('$S20', '', 'Nº boleto', false, true));
		array_push($cp, array('$A', '', 'Valor', false, true));
		array_push($cp, array('$N20', '', 'Valor entre', false, true));
		array_push($cp, array('$N20', '', 'Valor até', false, true));
		array_push($cp, array('$A', '', 'Situação', false, true));
		array_push($cp, array('$R 1:Todos&2:Abertos&3:Vencidos&4:Pagos', '', 'Tipo', false, true));
		array_push($cp, array('$B', '', 'Pesquisar', false, true));
		$data['content'] = $form -> editar($cp, '');

		if (strlen(get("acao")) > 0) {
			$data['result'] = '1';
		} else {
			$data['result'] = '0';
		}
		$this -> load -> view('financeiro/search', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> busca(1);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function creceber_search() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_receber');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$S80', '', 'Nome do cliente', false, true));
		array_push($cp, array('$H', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', false, true));
		array_push($cp, array('$D8', '', 'Vencimento final', false, true));
		array_push($cp, array('$S20', '', 'Nº boleto/CTR/DOC', false, true));
		array_push($cp, array('$A', '', 'Valor', false, true));
		array_push($cp, array('$N20', '', 'Valor entre', false, true));
		array_push($cp, array('$N20', '', 'Valor até', false, true));
		array_push($cp, array('$A', '', 'Situação', false, true));
		array_push($cp, array('$R 1:Todos&2:Abertos&3:Vencidos&4:Pagos', '', 'Tipo', false, true));
		array_push($cp, array('$B', '', 'Pesquisar', false, true));
		$data['content'] = $form -> editar($cp, '');

		if (strlen(get("acao")) > 0) {
			$data['result'] = '1';
		} else {
			$data['result'] = '0';
		}
		$this -> load -> view('financeiro/search', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> busca(2);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function relatorio() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = '';
		$menu = array();
		$data['title_menu'] = 'Relatórios';
		array_push($menu, array('Contas a Receber', '__Clientes em aberto', 'ITE', '/financeiro/creceber_abertos'));
		array_push($menu, array('Contas a Receber', '__Resumo do contas a receber', 'ITE', '/financeiro/resumos_creceber'));

		array_push($menu, array('Contas a Pagar', '__Contas em aberto', 'ITE', '/financeiro/cpagar_abertos'));
		array_push($menu, array('Contas a Pagar', '__Resumo do contas a pagar', 'ITE', '/financeiro/resumos_cpagar'));

		array_push($menu, array('Relação', '__Recebido / Despesas', 'ITE', '/financeiro/relatorio_cpcr'));
		array_push($menu, array('Contabil', '__Razão', 'ITE', '/financeiro/contabil_razao'));

		$data['menu'] = $menu;
		$data['content'] = $this -> load -> view('header/main_menu', $data, true);

		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber_contabil_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_contabil_editar();
		$form = new form;
		$form -> id = $id;
		$_POST['dd10'] = get("dd9");
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_receber);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function creceber_abertos() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_receber_relatorio');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', False, true));
		array_push($cp, array('$D8', '', 'Vencimento final', True, true));
		array_push($cp, array('$O A:Abertos&P:pagos&T:Todos', '', 'Situação', True, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> financeiro_abertos(2);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function cpagar_abertos() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_pagar_relatorio');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', False, true));
		array_push($cp, array('$D8', '', 'Vencimento final', True, true));
		array_push($cp, array('$O A:Abertos&P:pagos&T:Todos', '', 'Situação', True, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> financeiro_abertos(1);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function resumos_cpagar() {

		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_pagar_relatorio');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano Inicial', true, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano Final', true, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> financeiro_relatorio(1);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function resumos_creceber() {

		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_receber_relatorio');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano Inicial', true, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano Final', true, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> financeiro_relatorio(2);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function relatorio_cpcr() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('relacao_cp_cr');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano de referência', true, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$ano = get("dd1");
			$sx = $this -> financeiros -> financeiro_comparacao($ano);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function contabil_razao() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('razao');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$[2000-' . date("Y") . ']', '', 'Ano de referência', true, true));
		array_push($cp, array('$[1-12]', '', 'Mês de referência', true, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$ano = get("dd1");
			$mes = get("dd2");
			$sx = $this -> financeiros -> razao_acompanhamento($ano, $mes);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function contabil_detalhado($ct, $date) {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('razao_detalhado');

		$ano = get("dd1");
		$mes = get("dd2");
		$sx = $this -> financeiros -> razao_detalhado_acompanhamento($ct, $date);
		$data['content'] = $sx;
		$this -> load -> view('content', $data);
		$this -> footer();
	}

}
?>
