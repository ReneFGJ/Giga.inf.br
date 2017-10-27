<?php
class Main extends CI_Controller {
    function __construct() {
        global $dd, $acao;
        parent::__construct();
        $this -> lang -> load("app", "portuguese");
        $this -> load -> helper('form_sisdoc');
        $this -> load -> helper('email');
        $this -> load -> model('users');
        $this -> load -> helper('url');
        $this -> load -> library('session');

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
        $this -> load -> view('header/header_print', $data);

        if (!(isset($data['nocab']))) {
            $this -> load -> view('menus/menu_cab_top', $data);
        } else {
            $this -> load -> view('header/header_nomargin.php', null);
        }

        $this -> users -> security();
    }

    function footer() {
        $this -> load -> view('header/footer', null);
    }

    function index() {
        $this -> load -> model("user_drh");

        $this -> cab();
        $this -> load -> view('home', null);

        $data['content'] = $this -> user_drh -> aniversariantes();
        $data['title'] = '';
        if (strlen($data['content']) > 0) {
            $this -> load -> view('content', $data);
        }
        $this -> footer();
    }

    /****************************************** PEDIDOS *********************/
    function menu_pedidos($tipo = '', $situacao = '') {
        $id_us = $_SESSION['id'];
        if (strlen($tipo) == 0) {
            //$tipo = '1';
        }
        $model = "pedidos";
        $this -> load -> model($model);

        $this -> cab();

        /* Pedidos */
        $tela = $this -> $model -> pedidos_abertas_resumo($id_us, $tipo);
        switch($tipo) {
            case '1' :
                $data['title'] = 'Resumo dos Orçamentos';
                break;
            case '2' :
                $data['title'] = 'Resumo dos Pedidos';
                break;
            case '3' :
                $data['title'] = 'Resumo dos Pedidos de locação';
                break;
            case '4' :
                $data['title'] = 'Resumo das ordem de serviço - Laboratório';
                break;
            case '5' :
                $data['title'] = 'Resumo das ordem de atendimento - onsite';
                break;
            default :
                $data['title'] = 'Resumo';
                break;
        }

        $data['content'] = $tela;

        if ((strlen($tipo) > 0) and (strlen($situacao) > 0)) {
            $data['br'] = true;
            $data['content'] .= $this -> $model -> mostra_lista_detalhes($id_us, $tipo, $situacao);
            $this -> load -> view('content', $data);
        } else {
            $data['br'] = true;
            $data['content'] .= $this -> $model -> mostra_lista_detalhes($id_us, $tipo, $situacao);
            $this -> load -> view('content', $data);
        }

        /* Pedidos */
        $tela = $this -> $model -> pedidos_abertas_resumo($id_us, $tipo);
        switch($tipo) {
            case '1' :
                $data['title'] = 'Resumo dos Orçamentos';
                break;
            case '2' :
                $data['title'] = 'Resumo dos Pedidos';
                break;
            case '3' :
                $data['title'] = 'Resumo dos Pedidos de locação';
                break;
            case '4' :
                $data['title'] = 'Resumo das ordem de serviço - Laboratório';
                break;
            case '5' :
                $data['title'] = 'Resumo das ordem de atendimento - onsite';
                break;
            default :
                $data['title'] = 'Resumo';
                break;
        }

        /* gestor */
        if (perfil('#ADM#GEC')) {
            $data['content'] = '';
            $data['br'] = true;
            $data['content'] .= $this -> $model -> mostra_lista_detalhes(-1, $tipo, $situacao);
            $this -> load -> view('content', $data);
        }
        $this -> footer();
    }

    /****************************************** PEDIDOS *********************/
    function menu_orcamentos($tipo = '', $situacao = '') {
        $id_us = $_SESSION['id'];
        $model = "pedidos";
        $this -> load -> model($model);

        $this -> cab();

        /* Pedidos */
        $tela = $this -> $model -> pedidos_abertas_resumo($id_us, '1');
        $data['title'] = 'Resumo dos Orçamentos';
        $data['content'] = $tela;
        $this -> load -> view('content', $data);

        if ((strlen($tipo) > 0) and (strlen($situacao) > 0)) {
            $data['content'] = $this -> $model -> mostra_lista_detalhes($id_us, $tipo, $situacao);
            $this -> load -> view('content', $data);
        }
        $this -> footer();
    }

    /****************************************** PEDIDO *********************/
    function pedido_set_contato($ped) {
        $dd1 = round(get("pedido"));
        $dd2 = round(get("contato"));
        $dd3 = get("value");
        echo '===>' . $dd3;
        if (($dd3 == 'True') or ($dd3 == 'true')) { $dd3 = 1;
        } else { $dd3 = 0;
        }

        $sql = "select * from pedido_contato 
						WHERE pct_id_pp = $dd1
						AND pct_id_contato = $dd2 ";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) == 0) {
            $sql = "insert into pedido_contato
							(
								pct_id_pp, 	pct_id_contato, pct_ativo
							) values (
								$dd1,$dd2,$dd3
							)";
            $rlt = $this -> db -> query($sql);
        } else {
            $line = $rlt[0];
            $sql = "update pedido_contato 
						set pct_ativo = $dd3
						where id_pct = " . $line['id_pct'];
            $rlt = $this -> db -> query($sql);
            echo $sql;
        }
    }

    function pedido_novo_inserir($id = 0, $chk = '', $tipo = 2) {
        $this -> load -> model('pedidos');
        $idp = $this -> pedidos -> pedido_novo($id, $tipo);
        redirect(base_url('index.php/main/pedido_editar/' . $idp . '/' . checkpost_link($id)));
    }

    function pedido_enviar_email($id) {
        $editar = 1;
        $this -> load -> library('tcpdf');
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');

        $this -> pedidos -> pedido_pdf($id);
        return ('');

    }

    function pedido_editar($id) {
        $editar = 1;
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');

        $data = $this -> pedidos -> le($id);
        $id_cliente = $data['pp_cliente'];
        $id_cliente_f = $data['pp_cliente_faturamento'];
        $client = $this -> clientes -> le($id_cliente);

        /* Salva item */
        $acao = get("acao");
        if (strlen($acao) > 0) {
            switch (get("dd1")) {
                case 'CONDICOES' :
                    print_r($_POST);
                    $dd0 = get("dd0");
                    $cp = $this -> pedidos -> cp_condicoes($dd0, $id);
                    $form = new form;
                    $form -> id = $dd0;
                    $form -> editar($cp, $this -> pedidos -> table);
                    if ($form -> saved > 0) {
                        redirect(base_url('index.php/main/pedido_editar/' . $id . '/' . checkpost_link($id)));
                    }
                    break;
            }

        }
        /***************************************************************************************************************************/

        $this -> cab();

        $data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
        if ($data['pp_cliente_faturamento'] > 0) {
            $client_f = $this -> clientes -> le($id_cliente_f);
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
        } else {
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
        }

        $data['id_pp'] = $id;
        $data['dados_item_form'] = $this -> pedidos -> form_item_novo(0, $id);
        $data['dados_item'] = $this -> pedidos -> pedido_items($id, $editar);
        $data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
        $data['dados_item'] .= $this -> load -> view('pedido/pedido_item', $data, true);
        $data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);

        /* contatos do pedido */
        $data['contatos'] = $this -> pedidos -> contatos_do_pedido($id, $id_cliente, $editar);

        /* habilita cancelamento */
        $data['pp_situacao'] = 0;
        $data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);
        $this -> load -> view('pedido/pedido', $data);
    }

    function pedido_item_editar($id, $ped, $chk) {
        $this -> load -> model('pedidos');

        $data['nocab'] = true;
        $this -> cab($data);

        $cp = $this -> pedidos -> cp_item($id, $ped);
        $form = new form;
        $form -> id = $id;
        $tela = $form -> editar($cp, $this -> pedidos -> table_item);

        if ($form -> saved > 0) {
            $data['title'] = '';
            $data['content'] = '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        } else {
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        }
    }

    function pedido_mostra($id, $chk = '') {
        $editar = 0;
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');
        $this -> load -> model('ics');

        $data = $this -> pedidos -> le($id);
        $id_cliente = $data['pp_cliente'];
        $id_cliente_f = $data['pp_cliente_faturamento'];

        $client = $this -> clientes -> le($id_cliente);
        $data['nocab'] = true;
        $this -> cab($data);

        $client['data'] = data_completa($data['pp_data']);

        $txt = $this -> ics -> busca('PED_' . $data['pp_tipo_pedido'], $client);
        if (!isset($txt['nw_texto'])) {
            echo 'Não existe texto para o código PED_' . $data['pp_tipo_pedido'];
            echo '<br><br>Cadastre primeiro em -> Administrador -> Mensagens do sistema';
            exit ;
        }
        $data['cab'] = $txt['nw_texto'];

        $data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
        if ($data['pp_cliente_faturamento'] > 0) {
            $client_f = $this -> clientes -> le($id_cliente_f);
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
        } else {
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
        }
        $data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
        $data['id_pp'] = $id;
        $data['dados_item'] = $this -> pedidos -> pedido_items($id);
        //$data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);
        $data['dados_acoes'] = '';
        //$data['contatos'] = $this -> pedidos -> contatos_do_pedido($id, $id_cliente, $editar);

        //$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
        $data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);
        $this -> load -> view('pedido/pedido', $data);
    }

    function pedido_cancelar($id = 0, $chk = '') {
        $editar = 0;
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');
        $this -> load -> model('ics');
        $chk2 = checkpost_link($id);

        if ($chk2 == $chk) {
            $this -> pedidos -> pedido_cancelar($id);
            redirect(base_url('index.php/main/menu_pedidos/'));
        } else {
            echo "Erro de Check";
        }
    }

    function pedido($id, $chk = '') {
        $editar = 0;
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');
        $this -> load -> model('ics');

        $data = $this -> pedidos -> le($id);
        $id_cliente = $data['pp_cliente'];
        $id_cliente_f = $data['pp_cliente_faturamento'];

        $client = $this -> clientes -> le($id_cliente);
        $this -> cab();

        $client['data'] = data_completa($data['pp_data']);

        $txt = $this -> ics -> busca('PED_' . $data['pp_tipo_pedido'], $client);
        if (!isset($txt['nw_texto'])) {
            echo 'Não existe texto para o código PED_' . $data['pp_tipo_pedido'];
            echo '<br><br>Cadastre primeiro em -> Administrador -> Mensagens do sistema';
            exit ;
        }
        $data['cab'] = $txt['nw_texto'];

        $data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
        if ($data['pp_cliente_faturamento'] > 0) {
            $client_f = $this -> clientes -> le($id_cliente_f);
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
        } else {
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
        }
        $data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
        $data['id_pp'] = $id;
        $data['dados_item'] = $this -> pedidos -> pedido_items($id);
        $data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);
        $data['contatos'] = $this -> pedidos -> contatos_do_pedido($id, $id_cliente, $editar);

        //$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
        $data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);
        $this -> load -> view('pedido/pedido', $data);
    }

    function locacao_item_novo_serie($id, $ped, $cliente) {
        $editar = 0;
        if (strlen(get("acao")) == 0) {
            $_POST['dd2'] = stodbr(sonumero($_SESSION['data_ini']));
            $_POST['dd3'] = stodbr(sonumero($_SESSION['data_fim']));
        }
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');
        $this -> load -> model('produtos');
        $this -> load -> model('ics');
        $data['nocab'] = 0;
        $this -> cab($data);

        $cp = array();
        array_push($cp, array('$H8', '', '', false, false));
        array_push($cp, array('$S50', '', 'N. série', true, true));
        array_push($cp, array('$D8', '', 'Dt. Início', true, true));
        array_push($cp, array('$D8', '', 'Dt. Devolução', true, true));
        array_push($cp, array('$B8', '', 'Inserir >>>', false, true));

        $form = new form;
        $tela = $form -> editar($cp, '');

        /* */
        if ($form -> saved > 0) {
            $serie = get("dd1");
            $d1 = brtos(get("dd2"));
            $d2 = brtos(get("dd3"));
            echo "==>" . $d1 . "==" . $d2;

            $tela .= $this -> produtos -> produto_registra_serie($serie, $ped, $d1, $d2, $cliente);
        }

        $data['content'] = $tela;
        $data['title'] = '';
        $this -> load -> view('content', $data);
    }

    function locacao_item($id, $chk = '') {
        $editar = 0;
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('pedidos');
        $this -> load -> model('produtos');
        $this -> load -> model('ics');

        $data = $this -> pedidos -> le($id);
        $id_cliente = $data['pp_cliente'];
        $id_cliente_f = $data['pp_cliente_faturamento'];

        $client = $this -> clientes -> le($id_cliente);
        $this -> cab();

        $client['data'] = data_completa($data['pp_data']);

        $txt = $this -> ics -> busca('PED_' . $data['pp_tipo_pedido'], $client);
        if (!isset($txt['nw_texto'])) {
            echo 'Não existe texto para o código PED_' . $data['pp_tipo_pedido'];
            echo '<br><br>Cadastre primeiro em -> Administrador -> Mensagens do sistema';
            exit ;
        }
        $data['cab'] = $txt['nw_texto'];

        $data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
        if ($data['pp_cliente_faturamento'] > 0) {
            $client_f = $this -> clientes -> le($id_cliente_f);
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
        } else {
            $client_f['id_pp'] = $id;
            $client_f['editar'] = $editar;
            $data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
        }
        $data['dados_proposta'] = '';
        $data['id_pp'] = $id;

        $_SESSION['data_ini'] = $data['pp_dt_ini_evento'];
        $_SESSION['data_fim'] = $data['pp_dt_fim_evento'];

        $data['dados_item'] = $this -> pedidos -> pedido_items($id);
        $data['dados_acoes'] = '<button onclick="newwin(\'' . base_url('index.php/main/locacao_item_novo/' . $id) . '\',800,600);" class="btn btn-primary">Incluir equipamentos</button>';
        $data['dados_acoes'] .= ' | <button onclick="newwin(\'' . base_url('index.php/main/locacao_item_novo_serie/' . $id . '/' . $data['pp_nr'] . '/' . $data['pp_cliente']) . '\',800,600);" class="btn btn-primary">Incluie equipamentos pelo n. série</button>';
        $data['dados_acoes'] .= ' | <button onclick="newwin(\'' . base_url('index.php/main/contrato_pdf/' . $id) . '\',800,600);" class="btn btn-primary">Contrato Imprimir</button>';
        $data['dados_acoes'] .= ' | <button onclick="newwin(\'' . base_url('index.php/main/romaneio/' . $id) . '\',800,600);" class="btn btn-primary">Romaneio Imprimir</button>';
        $data['contatos'] = '';

        //$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
        $data['dados_condicoes'] = $this -> produtos -> produtos_reservados($id);
        $this -> load -> view('pedido/pedido', $data);
    }

    function locacao_item_editar($id = '', $chk = '') {
        $this -> load -> model('produtos');
        $data['nocab'] = true;

        $this -> cab($data);
        $tela = '';
        $form = new form;
        $cp = $this -> produtos -> cp_agenda();
        $tabela = 'produto_agenda';
        $form -> id = $id;

        $tela .= $form -> editar($cp, $tabela);
        if ($form -> saved > 0) {
            $tela = '<script> wclose(); </script>';
        }

        $data['content'] = $tela;
        $data['title'] = '';
        $this -> load -> view('content', $data);
    }

    function locacao_item_novo($id = '', $tp = '', $it = '') {
        $this -> load -> model('produtos');
        $data['nocab'] = true;

        if (strlen($it) > 0) {
            $d1 = sonumero($_SESSION['data_ini']);
            $d2 = sonumero($_SESSION['data_fim']);

            $cliente = 1;
            $err = $this -> produtos -> produto_registra($it, $id, $d1, $d2);
            $data['title'] = '';
            if (strlen($err) == 0) {
                $data['content'] = ' 
                    <div class="alert alert-success">
                        <strong>Successo!</strong> Item incorporado na locação.
                    </div>';
                $this -> load -> view('content', $data);
            } else {
                $data['content'] = ' 
                    <div class="alert alert-danger">
                        <strong>Erro!</strong> ' . $err . '
                    </div>';
                $this -> load -> view('content', $data);
            }
        }
        $this -> cab($data);
        $tela = '';
        if (strlen($tp == 0)) {
            $tela .= $this -> produtos -> locacao_categorias($id);
        } else {
            $tela .= $this -> produtos -> locacao_item($id, $tp);
        }
        $data['content'] = $tela;
        $data['title'] = '';
        $this -> load -> view('content', $data);
    }

    function cliente_faturamento($id, $chk = '') {
        $data = array();
        $data['clie_sel'] = $id;
        $data['clie_chk'] = $chk;
        $this -> session -> set_userdata($data);
        redirect(base_url('index.php/main/cliente_faturamento_sel'));
    }

    function cliente_faturamento_confirma($id = '', $chk = '') {
        $data['nocab'] = true;
        $this -> cab($data);
        $idc = $_SESSION['clie_sel'];
        $sql = "update pedido set pp_cliente_faturamento = " . round($id) . " where id_pp = " . round($idc);
        $this -> db -> query($sql);

        $data['content'] = '<script> wclose(); </script>';
        $data['title'] = 'Sucesso';
        $this -> load -> view('content', $data);
    }

    function cliente_faturamento_sel($npag = '') {
        /* Load Model */
        $this -> load -> model("clientes");
        if (!isset($_SESSION['clie_sel'])) {
            echo 'Erro de sessão';
            return ('');
        }
        $idc = $_SESSION['clie_sel'];
        $data['nocab'] = true;
        $this -> cab($data);

        $form = new form;

        $form -> fd = array('id_f', 'f_nome_fantasia', 'f_razao_social', 'f_estado');
        $form -> lb = array('id', msg('f_nome_fantasia'), msg('f_razao_social'), msg('f_estado'));
        $form -> mk = array('', 'L', 'L', 'L');
        $form -> pre_where = ' f_ativo = 1 ';

        $form -> tabela = $this -> clientes -> table;
        $form -> see = True;
        $form -> novo = false;
        $form -> edit = false;
        $form -> npag = $npag;

        $form -> row_view = base_url('index.php/main/cliente_faturamento_confirma/');
        $form -> row = base_url('index.php/main/cliente_faturamento_sel/');

        $data = array();
        $data['title'] = 'Clientes para faturamento';
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);

    }

    function confirmar_finalizar($id, $chk = '') {
        $this -> load -> model('pedidos');
        $this -> pedidos -> pedido_finalizar($id);
        redirect(base_url('index.php/main/menu_pedidos'));
    }

    /****************************************** CLIENTES *********************/
    function clientes($id = '') {
        /* Load Model */
        $this -> load -> model('clientes');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Clientes cadastrados';
        $data['content'] = $this -> clientes -> row($id);
        $this -> load -> view('content', $data);
    }

    function cliente($id = 0, $chk = '') {
        /* Load Model */
        $this -> load -> model('clientes');
        $this -> load -> model('mensagens');
        $this -> load -> model('pedidos');
        $this -> load -> model('financeiros');

        /* Controller */
        $this -> cab();
        $data = $this -> clientes -> le($id);

        $data['model'] = $this -> pedidos -> botao_novo_pedido($id);

        /* financeiro */
        $fin = $this -> financeiros -> resumo($id, 1);
        $data['finan_total'] = $fin['titulos'];
        $data['finan_valor'] = number_format($fin['total'], 2, ',', '.');
        $data['financeiro'] = $this -> financeiros -> lista_por_cliente($id, 1);
        //$data['financeiro_resumo'] = $this -> financeiros -> resumo_cliente($id, 1);

        /* orcamento / proposta */
        $data['orcamentos_total'] = $this -> pedidos -> resumo($id, 1);
        $data['orcamentos'] = $this -> pedidos -> lista_por_cliente($id, 1);
        $data['orcamentos'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

        /* pedido */
        $data['pedidos_total'] = $this -> pedidos -> resumo($id, 2);
        $data['pedidos'] = $this -> pedidos -> lista_por_cliente($id, 2);
        $data['pedidos'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

        /* locacao */
        $data['locacoes_total'] = $this -> pedidos -> resumo($id, 3);
        $data['locacao'] = $this -> pedidos -> lista_por_cliente($id, 3);
        $data['locacao'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

        /* onsite */
        $data['onsites_total'] = $this -> pedidos -> resumo($id, 5);
        $data['onsite'] = $this -> pedidos -> lista_por_cliente($id, 5);
        $data['onsite'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

        /* labo */
        $data['labos_total'] = $this -> pedidos -> resumo($id, 4);
        $data['labo'] = $this -> pedidos -> lista_por_cliente($id, 4);
        $data['labo'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

        $contato = $this -> clientes -> contatos($id);

        $data['contatos'] = $contato;
        $data['contatos'] .= $this -> clientes -> novo_contato($id);
        $data['contatos_total'] = $this -> clientes -> contatos_total($id);

        $data['mensagens'] = $this -> mensagens -> mostra_mensagens($id);
        $data['mensagens'] .= $this -> mensagens -> nova_mensagem($id);
        $data['mensagens_total'] = $this -> mensagens -> mensagens_total($id);

        /* resumo */
        $data['resumo'] = $this -> load -> view('cliente/resumo', $data, true);
        $data['resumo'] .= $contato;
        $data['resumo'] .= $this -> clientes -> novo_contato($id);

        $this -> load -> view('cliente/show', $data);
        $this -> load -> view('cliente/show_about', $data);
        $this -> footer();
    }

    function clientes_edit($id = 0, $chk = '') {
        /* Load Model */
        $this -> load -> model('clientes');

        /* Controller */
        $this -> cab();
        $saved = $this -> clientes -> editar($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            if ($id > 0) {
                redirect(base_url('index.php/main/cliente/' . $id . '/' . checkpost_link($id)) . '#contatos');
            }
            redirect(base_url('index.php/main/clientes'));
        }
    }

    function cliente_contato_edit($id, $idc = 0) {
        $this -> load -> model('clientes');
        $param = array('nocab' => True);
        $this -> cab($param);

        /* EDIT */
        $form = new form;
        $form -> id = $id;
        $cp = $this -> clientes -> cp_contatos($id, $idc);
        $tela = $form -> editar($cp, $this -> clientes -> table_contatos);
        $tela = '<table width="100%"><tr><td>' . $tela . '</td></tr></table>';
        $data['content'] = $tela;
        $data['title'] = '';
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            $data['content'] = '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        }
    }

    /************************************************************************* PRODUTOS CATEGORIA *****************/
    function locacao() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['locacoes_aberto'] = $this -> $model -> contratos_situacao(2);
        $data['locacoes_em_locacao'] = $this -> $model -> contratos_situacao(3);

        $this -> load -> view('locacao/resumo', $data);
        $this -> footer();

    }

    /************************************************************************** PICTURE ***************************/
    function picture($id) {
        $data['nocab'] = true;
        $this -> cab($data);

        $this -> load -> model('geds');
        $this -> geds -> tabela = 'produto_doc_ged';
        $this -> geds -> page = base_url('index.php/main/picture/' . $id . '/PRODT');
        $this -> geds -> extension = array('.jpg', '.png');

        $this -> load -> model('produtos');
        $data = $this -> produtos -> le($id);

        $tela = $this -> geds -> form($id, '');
        $data['content_form'] = $tela;
        $data['title'] = '';
        $this -> load -> view('produto/picture', $data);
    }

    /************************************************************************* PRODUTOS ***************************/
    function produtos($id = '') {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Produtos';
        $data['content'] = $this -> load -> view('produto/search', null, true);
        $this -> load -> view('content', $data);

        if (strlen(get("acao"))) {
            $tela = $this -> produtos -> busca(get("dd1"), get("dd2"));
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        }
        $this -> footer();
    }

    function produtos_cadastrar($id = '') {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Produtos - Incorporar Item';
        $data['content'] = $this -> load -> view('produto/search', null, true);
        $data['content'] .= '<button class="btn btn-default" onclick="newxy(\'' . base_url('index.php/main/produto_item') . '\',600,600);">Novo Item</button>';
        $this -> load -> view('content', $data);

        if (strlen(get("acao"))) {
            $tela = $this -> produtos -> busca(get("dd1"), get("dd2"));
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        }
        $this -> footer();
    }

    function produtos_cadastrar_serial($id = '') {
        $this -> load -> model('produtos');
        $this -> cab();
        if (get("dd99")) {
            $_POST['dd8'] = get("dd99");
            $_POST['dd9'] = "1";
            $_POST['acao'] = "valid";
        }

        $cp = $this -> produtos -> cp_item_patrimonio($id);
        $form = new form;
        $form -> id = $id;

        $tela = $form -> editar($cp, $this -> produtos -> table);
        //$_POST['dd3'] = get("prod");

        if ($form -> saved > 0) {
            $quant = round(get("dd8"));
            /* Multiplas entradas */
            if (strlen($id) == 0) {
                $s = get("dd7");
                for ($z = 2; $z <= $quant; $z++) {
                    $_POST['dd7'] = $s . '#' . $z;
                    $tela = $form -> editar($cp, $this -> produtos -> table);
                }
            }
            $this -> produtos -> updatex();
            $data['title'] = '';
            $data['content'] = '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        } else {
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        }
    }

    function produtos_categoria_editar() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Cadastro de produtos';
        $data['content'] = $this -> $model -> row();
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function produtos_view($id) {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = $this -> produtos -> le($id);

        $data['imagens'] = $this -> load -> view('produto/picture_slider', $data, true);

        $this -> load -> view('produto/view', $data);

        $data['row'] = $this -> produtos -> row_produtos($id);

        $this -> load -> view('produto/produtos_view', $data);

        $this -> footer();
    }

    function produtos_edit($id = 0, $chk = '') {
        $modal = 'produtos';
        /* Load Model */
        $this -> load -> model($modal);

        /* Controller */
        $this -> cab();
        $saved = $this -> $modal -> editar($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            redirect(base_url('index.php/main/produtos'));
        }
    }

    /************************************************************************* PRODUTOS NOME *****************/
    function produtos_nomes() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Descrição dos produtos';
        $data['content'] = $this -> $model -> row_descricao();
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function produtos_nomes_edit($id = 0, $chk = '') {
        $modal = 'produtos';
        /* Load Model */
        $this -> load -> model($modal);

        /* Controller */
        $this -> cab();
        $saved = $this -> $modal -> editar_produto($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            redirect(base_url('index.php/main/produtos_nomes'));
        }
    }

    function produtos_nomes_view($id = '') {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = $this -> $model -> le_descricao($id);
        $this -> load -> view('produto/view_pn', $data);

        $data['title'] = '';
        $data['content'] = $this -> produtos -> lista_produtos_descricao($id);
        $data['content'] .= $this -> load -> view('produto/descricao_novo', $data, True);

        $this -> load -> view('content', $data);
        $this -> footer();
    }

    /************************************************************************* PRODUTOS CATEGORIA *****************/
    function produtos_categoria() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Descrições dos produtos';
        $data['content'] = $this -> $model -> row_categoria();
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function produtos_categoria_edit($id = 0, $chk = '') {
        $modal = 'produtos';
        /* Load Model */
        $this -> load -> model($modal);

        /* Controller */
        $this -> cab();
        $saved = $this -> $modal -> editar_categoria($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            redirect(base_url('index.php/main/produtos_categoria'));
        }
    }

    function produtos_categoria_view($id, $chk) {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = $this -> $model -> le_categoria($id);
        $this -> load -> view('categoria/show', $data);

        $data['title'] = '';
        $data['content'] = $this -> produtos -> lista_produtos_categoria($id);
        $data['content'] .= $this -> load -> view('produto/produto_novo', $data, True);

        $this -> load -> view('content', $data);
        $this -> footer();
    }

    /************************************************************************* PRODUTOS MODELO *****************/
    function produtos_modelo() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Modelo dos produtos';
        $data['content'] = $this -> $model -> row_modelos();
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function produtos_modelos_edit($id = 0, $chk = '') {
        $modal = 'produtos';
        /* Load Model */
        $this -> load -> model($modal);

        /* Controller */
        $this -> cab();
        $saved = $this -> $modal -> editar_modelos($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            redirect(base_url('index.php/main/produtos_modelo'));
        }
    }

    function produtos_modelos_view($id, $chk) {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = $this -> $model -> le_modelos($id);
        $this -> load -> view('modelos/show', $data);
        $this -> footer();
    }

    /************************************************************************* PRODUTOS MARC *****************/
    function produtos_marca() {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Marca dos produtos';
        $data['content'] = $this -> $model -> row_marcas();
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function produtos_marca_edit($id = 0, $chk = '') {
        $modal = 'produtos';
        /* Load Model */
        $this -> load -> model($modal);

        /* Controller */
        $this -> cab();
        $saved = $this -> $modal -> editar_marca($id, $chk);
        $this -> footer();

        /****************/
        if ($saved > 0) {
            redirect(base_url('index.php/main/produtos_marca'));
        }
    }

    function produtos_marca_view($id, $chk) {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = $this -> $model -> le_marca($id);
        $this -> load -> view('marca/show', $data);
        $this -> footer();
    }

    function produtos_movimentacao($tipo = '') {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model($model);
        $cod = get("dd1");
        $acao = get("acao");
        $data = array();

        /* Controller */
        $this -> cab();
        $data['dados_produto'] = '';
        $data['title'] = 'Consulta produto';

        if (strlen($acao) > 0) {
            $cod = substr($cod, 0, 7);
            $cod = strzero($cod, 7);

            $data2 = $this -> $model -> le_produto_ean($cod);
            if (count($data2) > 0) {
                $data['dados_produto'] = $this -> load -> view('produto/view_6', $data2, true);
                switch ($tipo) {
                    case '1' :
                        /* Entrada na filial */
                        $data['title'] = 'Entrada de produto na unidade';
                        $this -> $model -> movimenta_para_estoque($data2['id_pr']);
                        break;
                    default :
                        break;
                }
            } else {
                $data['erro'] = 'Código Inválido<br>' . $cod;
                $data['dados_produto'] = $this -> load -> view('alert', $data, true);
            }
        }

        $data['cod'] = $cod;
        $data['content'] = $this -> load -> view('produto/leitor_codigo', $data, true);
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function myaccount() {
        $id = $_SESSION['id'];

        $this -> cab();
        $data['title'] = '';
        $data['content'] = $this -> users -> my_account($id);
        $this -> load -> view('content', $data);
    }

    function change_password() {
        $id = $_SESSION['id'];

        $this -> cab();
        $data['title'] = '';

        $data['content'] = $this -> users -> change_password($id);
        $this -> load -> view('content', $data);
    }

    function change_my_picture($id = '', $chk = '') {
        if (strlen($id) == 0) {
            $id = $_SESSION['id'];
            $chk = checkpost_link($id);
        }
        $this -> load -> model('users');
        $data = $this -> users -> le($id);
        $data['picture'] = $this -> users -> picture($id);

        $this -> cab();
        $data['title'] = '';

        $data['content'] = $this -> users -> change_picture($id);
        $this -> load -> view('content', $data);

    }

    function change_my_email() {
        $id = $_SESSION['id'];

        $this -> cab();
        $data['title'] = '';

        $data['content'] = $this -> users -> change_email($id);
        $this -> load -> view('content', $data);
    }

    function change_my_sign() {
        $id = $_SESSION['id'];

        $this -> cab();
        $data['title'] = '';

        $data['content'] = $this -> users -> change_sign($id);
        $this -> load -> view('content', $data);
    }

    function produto_reimpressao($id = '', $at = '') {
        $this -> load -> model('produtos');

        if (strlen($at) > 0) {
            $this -> produtos -> seta_etiqueta($id, $at);
        }
        $data['nocab'] = true;
        $this -> cab($data);
        $data = $this -> produtos -> le_produto($id);
        $tela = $this -> load -> view('produto/produtos_detalhes', $data, true);

        if ($data['pr_etiqueta'] == 1) {
            $tela .= 'Etiqueta: <span class="btn btn-success">Para impressão</span>';
            $tela .= ' | <a href="' . base_url('index.php/main/produto_reimpressao/' . $id . '/0') . '" class="btn btn-default">Cancelar impressão</a>';
        } else {
            $tela .= 'Etiqueta: <span class="btn btn-warning">Impressa</span>';
            $tela .= ' | <a href="' . base_url('index.php/main/produto_reimpressao/' . $id . '/1') . '" class="btn btn-default">Reimprimir etiqueta</a>';
        }
        $data['content'] = $tela;
        $data['title'] = '';
        $this -> load -> view('content', $data);
    }

    function produto_item_editar($id = '') {
        $this -> load -> model('produtos');
        $data['nocab'] = true;
        $this -> cab($data);
        $cp = $this -> produtos -> cp_item_patrimonio($id);
        $form = new form;
        $form -> id = $id;

        $tela = $form -> editar($cp, $this -> produtos -> table);

        if ($form -> saved == 0) {
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        } else {
            $data['title'] = '';
            $data['content'] = '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        }

    }

    function produto_item($id = '') {
        $this -> load -> model('produtos');
        $data['nocab'] = true;
        $this -> cab($data);

        $cp = $this -> produtos -> cp_item_patrimonio($id);
        $form = new form;
        $form -> id = $id;

        $tela = $form -> editar($cp, $this -> produtos -> table);
        //$_POST['dd3'] = get("prod");

        if ($form -> saved > 0) {
            $quant = round(get("dd8"));
            /* Multiplas entradas */
            if (strlen($id) == 0) {
                $s = get("dd7");
                for ($z = 2; $z <= $quant; $z++) {
                    $_POST['dd7'] = $s . '#' . $z;
                    $tela = $form -> editar($cp, $this -> produtos -> table);
                }
            }
            $this -> produtos -> updatex();
            $data['title'] = '';
            $data['content'] = '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        } else {
            $data['content'] = $tela;
            $data['title'] = '';
            $this -> load -> view('content', $data);
        }
    }

    function produtos_etiquetas() {
        $filename = 'etiqueta.prn';
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=" . $filename);
        $this -> load -> model('produtos');
        $this -> produtos -> etiquetas();
    }

    function produto_view($id = '') {
        /* Load Model */
        $model = 'produtos';
        $this -> load -> model('produtos');

        /* Controller */
        $this -> cab();
        $data = $this -> produtos -> le_produto($id);

        $data['imagens'] = $this -> load -> view('produto/picture_slider', $data, true);

        $this -> load -> view('produto/view', $data);

        $data['row'] = $this -> produtos -> row_produtos($id);

        $this -> load -> view('produto/produtos_detalhes', $data);

        $data['content'] = 'x';
        $data['title'] = 'Histórico do produto';
        $this -> load -> view('content', $data);

        $this -> footer();
    }

    /********************************* mensagem *********************/
    function cliente_mensagem_edit($id, $cliente) {
        $this -> load -> model('mensagens');
        $this -> load -> model('clientes');

        $data['nocab'] = true;
        $this -> cab($data);

        $cp = $this -> mensagens -> cp($cliente);
        $form = new form;
        $form -> id = $id;
        $data['content'] = $form -> editar($cp, $this -> mensagens -> table);
        $data['title'] = msg('mensagens');
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            if (get("dd5") == '1') {
                $assunto = utf8_decode(get("dd3"));
                $text = utf8_decode(get("dd4"));
                $de = 1;
                $anexos = array();
                $this -> clientes -> enviaremail_cliente($cliente, $assunto, $text, $de, $anexos);
            }
            $data['content'] .= '<script> wclose(); </script>';
            $this -> load -> view('content', $data);
        }
    }

    /************** prazo de entrega ************************/
    function prazo_entrega($npag = '') {
        $model = 'prazos_entrega';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $form = $this -> $model -> row($form);

        $form -> tabela = $this -> $model -> table;
        $form -> see = False;
        $form -> novo = true;
        $form -> edit = true;
        $form -> npag = $npag;

        $form -> row = base_url('index.php/main/' . $model . '/');
        $form -> row_edit = base_url('index.php/main/' . $model . '_edit/');

        $data = array();
        $data['title'] = msg('tit_' . $model);
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);
    }

    function prazos_entrega_edit($id = '', $chk = '') {
        $model = 'prazos_entrega';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $cp = $this -> $model -> cp($id);
        $form -> cp = $cp;

        $form -> tabela = $this -> $model -> table;
        $form -> id = $id;

        $data['content'] = $form -> editar($cp, $form -> tabela);

        $data['title'] = msg('tit_' . $model);
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            redirect(base_url('index.php/main/prazo_entrega'));
        }
    }

    /************** prazo de garantia ************************/
    function prazo_garantia($npag = '') {
        $model = 'prazos_garantia';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $form = $this -> $model -> row($form);

        $form -> tabela = $this -> $model -> table;
        $form -> see = False;
        $form -> novo = true;
        $form -> edit = true;
        $form -> npag = $npag;

        $form -> row = base_url('index.php/main/' . $model . '/');
        $form -> row_edit = base_url('index.php/main/' . $model . '_edit/');

        $data = array();
        $data['title'] = msg('tit_' . $model);
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);
    }

    function prazos_garantia_edit($id = '', $chk = '') {
        $model = 'prazos_garantia';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $cp = $this -> $model -> cp($id);
        $form -> cp = $cp;
        $form -> id = $id;

        $form -> tabela = $this -> $model -> table;

        $data['content'] = $form -> editar($cp, $form -> tabela);

        $data['title'] = msg('tit_' . $model);
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            redirect(base_url('index.php/main/prazo_garantia'));
        }
    }

    /************** prazo_montagem ************************/
    function prazo_montagem($npag = '') {
        $model = 'prazos_montagem';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $form = $this -> $model -> row($form);

        $form -> tabela = $this -> $model -> table;
        $form -> see = False;
        $form -> novo = true;
        $form -> edit = true;
        $form -> npag = $npag;

        $form -> row = base_url('index.php/main/' . $model . '/');
        $form -> row_edit = base_url('index.php/main/' . $model . '_edit/');

        $data = array();
        $data['title'] = msg('tit_' . $model);
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);
    }

    function prazos_montagem_edit($id = '', $chk = '') {
        $model = 'prazos_montagem';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $cp = $this -> $model -> cp($id);
        $form -> cp = $cp;

        $form -> tabela = $this -> $model -> table;
        $form -> id = $id;

        $data['content'] = $form -> editar($cp, $form -> tabela);

        $data['title'] = msg('tit_' . $model);
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            redirect(base_url('index.php/main/prazo_montagem'));
        }
    }

    /************** pedido_validade ************************/
    function pedido_validade($npag = '') {
        $model = 'pedidos_validade';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $form = $this -> $model -> row($form);

        $form -> tabela = $this -> $model -> table;
        $form -> see = False;
        $form -> novo = true;
        $form -> edit = true;
        $form -> npag = $npag;

        $form -> row = base_url('index.php/main/' . $model . '/');
        $form -> row_edit = base_url('index.php/main/' . $model . '_edit/');

        $data = array();
        $data['title'] = msg('tit_' . $model);
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);
    }

    function pedidos_validade_edit($id = '', $chk = '') {
        $model = 'pedidos_validade';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $cp = $this -> $model -> cp($id);
        $form -> cp = $cp;

        $form -> tabela = $this -> $model -> table;
        $form -> id = $id;

        $data['content'] = $form -> editar($cp, $form -> tabela);

        $data['title'] = msg('tit_' . $model);
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            redirect(base_url('index.php/main/pedido_validade'));
        }
    }

    /************** condicoes_pagamento ************************/
    function condicoes_pagamento($npag = '') {
        $model = 'condicoes_pagamento';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $form = $this -> $model -> row($form);

        $form -> tabela = $this -> $model -> table;
        $form -> see = False;
        $form -> novo = true;
        $form -> edit = true;
        $form -> npag = $npag;

        $form -> row = base_url('index.php/main/' . $model . '/');
        $form -> row_edit = base_url('index.php/main/' . $model . '_edit/');

        $data = array();
        $data['title'] = msg('tit_' . $model);
        $data['content'] = row($form, $npag);
        $this -> load -> view('content', $data);
    }

    function condicoes_pagamento_edit($id = '', $chk = '') {
        $model = 'condicoes_pagamento';
        $this -> load -> model($model);
        /* Load Model */
        $this -> cab();

        $form = new form;
        $cp = $this -> $model -> cp($id);
        $form -> cp = $cp;

        $form -> tabela = $this -> $model -> table;
        $form -> id = $id;

        $data['content'] = $form -> editar($cp, $form -> tabela);

        $data['title'] = msg('tit_' . $model);
        $this -> load -> view('content', $data);

        if ($form -> saved > 0) {
            redirect(base_url('index.php/main/condicoes_pagamento'));
        }
    }

    function romaneio($id = 0) {
        $this -> load -> model('clientes');
        $this -> load -> model('contratos');
        $this -> load -> model('pedidos');
        $this -> load -> model('empresas');
        $this -> load -> model('ics');

        $data = $this -> contratos -> le($id);
        
        $data4 = $this -> pedidos -> le($id);
        $data3 = $this -> empresas -> le(1);
        $data2 = $this -> clientes -> le($data4['pp_cliente']);

        //$data2 = $this->filiais->le(1);
        $data = array_merge($data, $data2, $data3);
        $anexo = $this -> contratos -> anexos($id);
        $condicoes = '';

        $txt = $this->ics->busca('RECIBO_1');
        $contrato = $txt['nw_texto'];
        $contrato = troca($contrato, '$LOCATARIO_DADOS', $this -> load -> view('contrato/contrato_locatario', $data, true));
        $contrato = troca($contrato, '$LOCADORA_DADOS', $this -> load -> view('contrato/contrato_locador', $data, true));
        $contrato = troca($contrato, '$EQUIPAMENTOS', $anexo);
        $contrato = troca($contrato, '$CONDICOES', $condicoes);
        $contrato = troca($contrato, '$LOCATARIA', $data['f_razao_social']);
        $contrato = troca($contrato, '$LOCADORA', $data['f_razao_social']);

        //$data['content'] = $contrato;
        $data['nocab'] = true;
        $this->cab($data);
        
        $tela = $contrato;        
        $data['content'] = $tela;
        $data['title'] = 'Recibo de entrega - '.$data4['pp_nr'];

        $this->load->view('content',$data);
    }

    function contrato_pdf($id = 0) {
        $this -> load -> helper('tcpdf');
        $this -> load -> model('contratos');
        $this -> load -> model('pedidos');
        $this -> load -> model('empresas');

        $data = $this -> contratos -> le($id);
        $data2 = $this -> pedidos -> le($id);
        $data3 = $this -> empresas -> le(1);

        //$data2 = $this->filiais->le(1);
        $data = array_merge($data, $data2, $data3);
        $anexo = $this -> contratos -> anexos($id);
        $condicoes = '';

        $contrato = $data['c_contrato'];
        $contrato = troca($contrato, '$LOCATARIO_DADOS', $this -> load -> view('contrato/contrato_locatario', $data, true));
        $contrato = troca($contrato, '$LOCADORA_DADOS', $this -> load -> view('contrato/contrato_locador', $data, true));
        $contrato = troca($contrato, '$EQUIPAMENTOS', $anexo);
        $contrato = troca($contrato, '$CONDICOES', $condicoes);
        $contrato = troca($contrato, '$LOCATARIA', $data['f_razao_social']);
        $contrato = troca($contrato, '$LOCADORA', $data['f_razao_social']);

        $data['content'] = $contrato;

        $this -> load -> view('contrato/contrato_pdf', $data);
    }

}
?>
