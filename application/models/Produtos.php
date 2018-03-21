<?php
class produtos extends CI_model {
    var $table = 'produtos';
    var $table_tipo = 'produtos_tipo';
    var $table_tipo_2 = '(select * from produtos_tipo LEFT JOIN produtos_marca ON pr_marca = id_ma) as produtos_tipo ';
    var $table_categoria = 'produtos_categoria';
    var $table_marca = 'produtos_marca';
    var $table_descricao = 'produto_nome';
    var $table_modelo = 'produto_modelo';

    var $table_produto = '(SELECT * FROM produtos
							LEFT JOIN produtos_situacao ON pr_ativo = id_ps
							LEFT JOIN clientes ON pr_cliente = id_f
							LEFT JOIN produtos_marca ON pr_marca = id_ma
							LEFT JOIN _filiais ON pr_filial = id_fi
							LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						   ) as produtos ';

    /************************************************************************** PRODUTOS *****************************/
    function le($id) {
        $sql = "select * from " . $this -> table_tipo . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						WHERE id_prd = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) > 0) {
            $line = $rlt[0];
            $line['imgs'] = $this -> le_imagem($id);
            return ($line);
        } else {
            return ( array());
        }
    }

    function le_produto($id) {
        /* LEFT JOIN " . $this -> table_tipo . " ON pr_produto = id_prd */
        $sql = "select * from " . $this -> table . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						LEFT JOIN produtos_situacao ON pr_ativo = id_ps
						LEFT JOIN clientes ON pr_cliente = id_f
						LEFT JOIN _filiais ON pr_filial = id_fi				
						WHERE id_pr = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) > 0) {
            $line = $rlt[0];
            $line['imgs'] = $this -> le_imagem($id);
            return ($line);
        } else {
            return ( array());
        }
    }

    function le_descricao($id) {
        $sql = "select * from " . $this -> table_descricao . " where id_pn = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $line = $rlt[0];
        return ($line);
    }

    function le_produto_ean($id) {
        $sql = "select * from " . $this -> table . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						LEFT JOIN produtos_situacao ON pr_ativo = id_ps
						LEFT JOIN clientes ON pr_cliente = id_f
						LEFT JOIN _filiais ON pr_filial = id_fi				
						WHERE pr_patrimonio = '" . $id . "'";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) > 0) {
            $line = $rlt[0];
            $line['imgs'] = $this -> le_imagem($id);
            return ($line);
        } else {
            return ( array());
        }
    }

    function le_imagem($id) {
        $sql = "select * from produto_doc_ged
						INNER JOIN produto_doc_ged_tipo on doc_tipo = id_doct
						WHERE doct_codigo = 'PRODT'
						AND doc_dd0 = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        return ($rlt);
    }

    function busca($t, $cat) {
        $t = troca($t, ' ', ';');
        
        if (strlen(sonumero($t)) ==8) 
            {
                $t = substr($t,0,7);
            }
        $t = splitx(';', $t . ';');            
        $wh1 = '';
        $wh2 = '';
        $wh3 = '';
        $wh4 = '';
        for ($r = 0; $r < count($t); $r++) {
            $term = $t[$r];
            if (strlen($term) > 0) {
                if (strlen($wh1) > 0) {
                    $wh1 .= ' AND ';
                }
                $wh1 .= " (pr_modelo like '%$term%' ";
                $wh1 .= " or pr_serial like '%$term%' ";
                $wh1 .= " or pc_nome like '%$term%' ";
                $wh1 .= " or ma_nome like '%$term%' ";
                $wh1 .= " ) ";

                if (strlen($wh2) > 0) {
                    $wh2 .= ' OR ';
                }
                $wh2 .= " (pr_serial like '%$term%' 
                            or pr_patrimonio like '%$term%'
                            or pr_tag like '%$term%')
                ";
            }
        }
        if (strlen($wh1) == 0) {
            $wh1 = '1=1';
            $wh2 = '1=1';
        }
        if (strlen($cat) > 0) {
            $wh3 = 'AND (id_pc = ' . $cat . ')';
        }

        /* total */
        $sql = "select count(*) as total from produtos
						LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						LEFT JOIN produtos_situacao ON id_ps = pr_ativo
						LEFT JOIN produtos_MARCA ON id_ma = pr_marca
						LEFT JOIN _filiais ON pr_filial = id_fi
						WHERE (($wh1) OR ($wh2)) $wh3
						ORDER BY pc_nome, pr_serial
						LIMIT 100
						";
						
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $total = $rlt[0]['total'];

        $sql = "select * from produtos
						LEFT JOIN produto_nome ON id_pn = pr_produto
						LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						LEFT JOIN produtos_situacao ON id_ps = pr_ativo
						LEFT JOIN produtos_MARCA ON id_ma = pr_marca
						LEFT JOIN produto_modelo ON id_pm = pr_modelo
						LEFT JOIN _filiais ON pr_filial = id_fi
						WHERE (($wh1) OR ($wh2)) $wh3
						ORDER BY pc_nome, pr_serial
						";

        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table class="table" width="100%">';
        $sx .= '<tr class="middle"><td colspan=9>Total Recuperado ' . $total . '</td></tr>' . cr();
        $sx .= '<tr class="small">' . cr();
        $sx .= '	<th width="2%"><b>#</b></th>' . cr();
        $sx .= '    <th width="5%"><b>Patrimonio</b></th>' . cr();
        $sx .= '	<th width="18%"><b>Produto</b></th>' . cr();
        $sx .= '    <th width="18%"><b>Marca</b></th>' . cr();
        $sx .= '	<th width="18%"><b>Modelo</b></th>' . cr();
        $sx .= '	<th width="10%"><b>Serial</b></th>' . cr();
        $sx .= '	<th width="10%"><b>Característica</b></th>' . cr();
        $sx .= '	<th width="35%"><b>Situação / Filial</b></th>' . cr();
        if (perfil("#ADM")) {
            $sx .= '    <th colspan="1">-</th>' . cr();
        }
        $sx .= '</tr>' . cr();
        $ID = 0;
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = '<a href="'.base_url('index.php/main/produto/'.$line['id_pr']).'" target="_new'.$line['id_pr'].'">';
            $tit = 'title="'.($line['pm_obs']).($line['pm_obss']).'" ';
            $tit .= 'alt="'.($line['pm_obs']).($line['pm_obss']).'" ';
            $ID++;
            $sx .= '<tr class="' . trim($line['ps_class']) . '"  '.$tit.'>' . cr();
            $sx .= '	<td class="small">';
            $sx .= strzero($ID, 3) . '. ';
            $sx .= '	</td>' . cr();

            $sx .= '    <td >';
            $sx .= $link.$line['pr_tag'];
            $sx .= '<br>'.$line['pr_patrimonio'].'</a>';
            $sx .= '    </td>' . cr();
                        
            $sx .= '	<td >';
            $sx .= $line['pn_descricao'];
            $sx .= '	</td>' . cr();
            
            $sx .= '    <td >';
            $sx .= $line['ma_nome'];
            $sx .= '    </td>' . cr();
            $sx .= '	<td >';
            $sx .= $line['pr_modelo'];
            $sx .= '	</td>' . cr();
            $sx .= '	<td class="middle">';
            $sx .= $line['pr_serial'];
            $sx .= '	</td>' . cr();
            $sx .= '	<td  class="small">';
            $sx .= $line['pc_nome'];
            $sx .= '	</td>' . cr();
            $sx .= '	<td class="small" >';
            $sx .= $line['ps_descricao'];
            $sx .= ' (' . $line['pr_patrimonio'] . ')';
            $sx .= ' - ' . $line['fi_nome_fantasia'] . '&nbsp;';
            $sx .= '	</td>' . cr();

            if (perfil("#ADM#GEC")) {
                $link1 = '<a href="#" onclick="newxy(\'' . base_url('index.php/main/produto_item_editar/' . $line['id_pr']) . '\',600,600);" title="editar produto">';
                $link2 = '<a href="#" onclick="newxy(\'' . base_url('index.php/main/produto_reimpressao/' . $line['id_pr']) . '\',600,600);" title="reimprimir etiqueta">';
                $sx .= '    <td colspan="1">';
                $sx .= $link1 . '<span class="glyphicon glyphicon-pencil"></span></a>';
                $sx .= ' ';
                $sx .= $link2 . '<span class="glyphicon glyphicon-print"></span></a>';

                $sx .= '</td>' . cr();
            }

            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>';
        return ($sx);
    }

    function contratos_situacao($sit) {
        $order = 'pp_dt_ini_evento, pp_entrega_hora';
        $hora = 'pp_entrega_hora';
        switch($sit)
            {
            case '7':
                $order = 'pp_dt_fim_evento, pp_dt_fim_evento_hora';
                $hora = 'pp_dt_fim_evento_hora';
                break;
            }
        $sql = "select * from pedido
						INNER JOIN clientes ON pp_cliente = id_f 
						INNER JOIN users ON id_us = pp_vendor
						INNER JOIN _filiais ON pp_filial = id_fi
						WHERE pp_tipo_pedido = 3 and pp_situacao = " . $sit . "
					ORDER BY $order
					";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '';
        $sx .= '<table class="table" width="100%">';
        $sx .= '<tr><th>Contrato</th><th>Cliente</th><th>Início Locação</th><th>Fim Locação</th></tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = 'index.php/main/locacao_item/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp']);
            $link = '<a href="' . base_url($link) . '" >';

            $sx .= '<tr>';
            $sx .= '<td>';
            $sx .= $link;
            $sx .= strzero($line['id_pp'], 7) . '/' . $line['pp_ano'];
            $sx .= '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['f_razao_social'];
            $sx .= ' / ';
            $sx .= $line['f_nome_fantasia'];
            $sx .= '<br><span class="small">Vendedor: <i>' . $line['us_nome'] . '</i></span>';
            $sx .= '<br><span class="small">Filial: <i>' . $line['fi_nome_fantasia'] . '</i></span>';
            $sx .= '</td>';

            $sx .= '<td align="center">';
            $sx .= stodbr($line['pp_dt_ini_evento']);
            $sx .= '<br>'.$line[$hora];
            $sx .= '</td>';

            $sx .= '<td align="center">';
            $sx .= stodbr($line['pp_dt_fim_evento']);
            $sx .= '</td>';
            $sx .= '</tr>';
        }
        $sx .= '</table>';
        return ($sx);
    }

    function le_produtos_categoria($id) {
        $sql = "select * from produtos_categoria 
					WHERE id_pc = " . $id;
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $line = $rlt[0];
        return ($line);
    }

    function cp_agenda() {
        $cp = array();
        $op = '1:Alocado&9:cancelado';
        array_push($cp, array('$H8', 'id_ag', '', False, True));
        array_push($cp, array('$D8', 'ag_data_reserva', 'Início', False, True));
        array_push($cp, array('$D8', 'ag_data_reserva_ate', 'Fim', False, True));
        $sql = "select * from produto_agenda_status";
        array_push($cp, array('$Q id_pas:pas_descricao:' . $sql, 'ag_situacao', 'Status', True, True));
        return ($cp);
    }
    
    function cp_etiqueta() {
        $cp = array();
        $op = '1:Alocado&9:cancelado';
        array_push($cp, array('$H8', 'id_et', '', False, True));
        array_push($cp, array('$S100', 'st_nome', 'Nome da etiqueta', True, True));
        array_push($cp, array('$O ' . $op, 'st_ativo', 'Ativo', True, True));
        
        array_push($cp, array('$A', '', 'Etiqueta #1', False, True));
        array_push($cp, array('$I8', 'st_p1', 'Codigo de Barras #1 - Direita', True, True));
        array_push($cp, array('$I8', 'st_p2', 'Codigo de Barras #1 - Altura', True, True));
        array_push($cp, array('$I8', 'st_p3', 'Texto #1 - Direita', True, True));
        array_push($cp, array('$I8', 'st_p4', 'Texto #1 - Altura', True, True));
        array_push($cp, array('$I8', 'st_p5', 'Reservado', True, True));

        array_push($cp, array('$A', '', 'Etiqueta #2', False, True));
        array_push($cp, array('$I8', 'st_o1', 'Codigo de Barras #2 - Direita', True, True));
        array_push($cp, array('$I8', 'st_o2', 'Codigo de Barras #2 - Altura', True, True));
        array_push($cp, array('$I8', 'st_o3', 'Texto #2 - Direita', True, True));
        array_push($cp, array('$I8', 'st_o4', 'Texto #2 - Altura', True, True));
        array_push($cp, array('$I8', 'st_o5', 'Reservado', True, True));

        return ($cp);
    }    

    function cp_item() {
        $cp = array();
        array_push($cp, array('$H8', 'id_prd', '', False, True));
        array_push($cp, array('$A', '', 'Dados do produto', False, True));

        $sql = "select * from produto_nome where pn_ativo = 1 order by pn_descricao";
        array_push($cp, array('$Q id_pn:pn_descricao:' . $sql, 'pr_produto', 'Produto', True, True));

        //array_push($cp, array('$S80', 'pr_nome', 'Nome do produto', True, True));
        array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
        array_push($cp, array('$S40', 'pr_patrimonio', 'Nº do patrimonio', False, True));
        $sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
        array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));
        $sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
        array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Categoria', True, True));
        array_push($cp, array('$T80:5', 'pr_descricao', 'Dados técnicos / Descrição', False, True));

        $sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
        array_push($cp, array('$Q id_ps:ps_descricao:' . $sql, 'pr_ativo', 'Situação', True, True));

        //array_push($cp, array('$O 1:SIM', '', 'Confirma inclusão', True, True));
        array_push($cp, array('$B8', '', 'Gravar', False, True));

        array_push($cp, array('$A', '', 'Fornecedor', False, True));
        array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
        array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
        array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
        array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));
    
        return ($cp);
    }

    function cp_item_patrimonio($id = '') {
        $cp = array();
        array_push($cp, array('$H8', 'id_pr', '', False, True));
        array_push($cp, array('$A', '', 'Dados do produto', False, True));

        $sql = "select * from produto_nome where pn_ativo = 1 order by pn_descricao";
        array_push($cp, array('$Q id_pn:pn_descricao:' . $sql, 'pr_produto', 'Produto (Tipo)', True, True));

        $sql = "select * from produtos_categoria where pc_ativo = 1 order by id_pc";
        array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Descrição', True, True));

        $sql = "select * from produtos_marca where ma_ativo = 1 order by id_ma";
        array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));

        //array_push($cp, array('$S80', 'pr_modelo', 'Modelo', True, True));
        $sql = "select * from produto_modelo where pm_ativo = 1 order by pm_descricao";
        array_push($cp, array('$Q pm_descricao:pm_descricao:' . $sql, 'pr_modelo', 'Modelo', True, True));

        $texto = 'Clique no nome para cadastrar um item no listbox:<br>';
        $texto .= '| ';
        $texto .= '<a href="' . base_url('index.php/main/produtos_nomes') . '" target="_new_' . date("His") . 'a">Produtos</a> | ';
        $texto .= '<a href="' . base_url('index.php/main/produtos_categoria') . '" target="_new_' . date("His") . 'b">Descrições</a> | ';
        $texto .= '<a href="' . base_url('index.php/main/produtos_marca') . '" target="_new_' . date("His") . 'c">Marca</a> | ';
        $texto .= '<a href="' . base_url('index.php/main/produtos_modelo') . '" target="_new_' . date("His") . 'c">Modelo</a> | ';

        array_push($cp, array('$M', '', $texto, False, True));

        array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
        array_push($cp, array('$S40', 'pr_tag', 'Nº do patrimonio', False, True));
        //array_push($cp, array('$S40', 'pr_tag', 'Nº do Tag', False, True));

        if (strlen($id) == 0) {
            array_push($cp, array('$HV', '', '1', True, True));
        } else {
            array_push($cp, array('$HV', '', '0', True, True));
        }

        array_push($cp, array('$T80:5', 'pm_obs', 'Observação do produtos', False, True));

        $sql = "select * from _filiais where fi_ativo = 1 order by id_fi";
        array_push($cp, array('$Q id_fi:fi_nome_fantasia:' . $sql, 'pr_filial', 'Filial', True, True));

        array_push($cp, array('$HV', 'pr_ativo', '1', True, True));

        array_push($cp, array('$HV', '', '1', True, True));
        array_push($cp, array('$B8', '', 'Gravar', False, True));

        array_push($cp, array('$A', '', 'Fornecedor', False, True));
        array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
        array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
        array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
        array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));


        return ($cp);
    }

    function cp_produtos() {
        $cp = array();
        array_push($cp, array('$H8', 'id_pn', '', False, True));
        array_push($cp, array('$A', '', 'Descrição do produto', False, True));
        array_push($cp, array('$S80', 'pn_descricao', 'Nome do produto', True, True));

        $sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
        array_push($cp, array('$O 1:Ativo&0:Inativo', 'pn_ativo', 'Situação', True, True));

        array_push($cp, array('$B8', '', 'Gravar', False, True));
        return ($cp);
    }

    function cp_modelos() {
        $cp = array();
        array_push($cp, array('$H8', 'id_pm', '', False, True));
        array_push($cp, array('$A', '', 'Descrição do modelo', False, True));
        array_push($cp, array('$S80', 'pm_descricao', 'Nome do modelo', True, True));

        $sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
        array_push($cp, array('$O 1:Ativo&0:Inativo', 'pm_ativo', 'Situação', True, True));
        array_push($cp, array('$T80:5', 'pm_obss', 'Obs', False, True));        

        array_push($cp, array('$B8', '', 'Gravar', False, True));
        return ($cp);
    }

    function cp() {
        $cp = array();
        array_push($cp, array('$H8', 'id_prd', '', False, True));
        array_push($cp, array('$A', '', 'Dados do produto', False, True));
        array_push($cp, array('$S80', 'prd_nome', 'Nome do produto', True, True));
        $sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
        array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));
        $sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
        array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Categoria', True, True));
        array_push($cp, array('$T80:5', 'prd_descricao', 'Dados técnicos / Descrição', False, True));

        $sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
        array_push($cp, array('$O 1:Ativo&0:Inativo', 'prd_ativo', 'Situação', True, True));

        array_push($cp, array('$B8', '', 'Gravar', False, True));
        return ($cp);
    }

    function row($id = '') {
        $form = new form;

        $form -> fd = array('id_prd', 'prd_nome', 'ma_nome', 'prd_ativo');
        $form -> lb = array('id', msg('pr_descricao'), msg('ma_nome'), msg('pr_ativo'));
        $form -> mk = array('', 'L', 'C', 'C', 'SN');

        $form -> tabela = $this -> table_tipo_2;
        $form -> see = true;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/produtos_edit');
        $form -> row_view = base_url('index.php/main/produtos_view');
        $form -> row = base_url('index.php/main/produtos');

        return (row($form, $id));
    }

    function editar($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, $this -> table_tipo);
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    /****************************************************************************************** HISTORICO *********************/
    function inserir_historico($dt) {
        $prod = round($dt['id_pr']);
        $user = $_SESSION['id'];
        $hist = $dt['id_hs'];
        $pedi = $dt['nr_pedido'];
        $sql = "insert into produtos_historico 
						(
						ph_produto, ph_historico, ph_log, ph_pedido
						) values (
						$prod,$hist,$user,$pedi
						)";
        $rlt = $this -> db -> query($sql);
    }

    /************************************************************************** PRODUTOS CATEGORIA ****************************/
    function le_categoria($id) {
        $sql = "select * from " . $this -> table_categoria . " where id_pc = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $line = $rlt[0];
        return ($line);
    }

    function cp_categoria() {
        $cp = array();
        array_push($cp, array('$H8', 'id_pc', '', False, True));
        array_push($cp, array('$S80', 'pc_nome', 'Nome da categoria', True, True));
        array_push($cp, array('$S80', 'pc_codigo', 'Código', False, True));
        array_push($cp, array('$T80:5', 'pc_desc_basica', 'Descrição Básica', False, True));
        array_push($cp, array('$O 1:SIM&0:NÃO', 'pc_ativo', 'Ativo', True, True));

        return ($cp);
    }

    function row_descricao($id = '') {
        $form = new form;

        $form -> fd = array('id_pn', 'pn_descricao', 'pn_ativo');
        $form -> lb = array('id', msg('pc_nome'), msg('pc_ativo'));
        $form -> mk = array('', 'L', 'A');

        $form -> tabela = $this -> table_descricao;
        $form -> see = true;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/produtos_nomes_edit');
        $form -> row_view = base_url('index.php/main/produtos_nomes_view');
        $form -> row = base_url('index.php/main/produtos_nomes');

        return (row($form, $id));
    }

    function row_modelos($id = '') {
        $form = new form;

        $form -> fd = array('id_pm', 'pm_descricao', 'pm_ativo');
        $form -> lb = array('id', msg('pc_nome'), msg('pc_ativo'));
        $form -> mk = array('', 'L', 'A');

        $form -> tabela = $this -> table_modelo;
        $form -> see = true;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/produtos_modelos_edit');
        $form -> row_view = base_url('index.php/main/produtos_modelos_view');
        $form -> row = base_url('index.php/main/produtos_modelo');

        return (row($form, $id));
    }
    
    function row_etiquetas($id = '') {
        $form = new form;

        $form -> fd = array('id_et', 'st_nome', 'st_p1', 'st_p2', 'st_p3', 'st_p4', 'st_p5', 'st_o1', 'st_o2', 'st_o3', 'st_o4', 'st_o5');
        $form -> lb = array('id', msg('pc_nome'), 'pos','pos','pos','pos','pos','pos','pos','pos','pos','pos','pos');
        $form -> mk = array('', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');

        $form -> tabela = "etiqueta";
        $form -> see = false;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/etiqueta_edit');
        $form -> row_view = base_url('index.php/main/etiqueta_config');
        $form -> row = base_url('index.php/main/produtos_modelo');

        return (row($form, $id));
    }    

    function row_categoria($id = '') {
        $form = new form;

        $form -> fd = array('id_pc', 'pc_nome', 'pc_codigo', 'pc_ativo');
        $form -> lb = array('id', msg('pc_nome'), msg('pc_codigo'), msg('pc_ativo'));
        $form -> mk = array('', 'L', 'L', 'A');

        $form -> tabela = $this -> table_categoria;
        $form -> see = true;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/produtos_categoria_edit');
        $form -> row_view = base_url('index.php/main/produtos_categoria_view');
        $form -> row = base_url('index.php/main/produtos_categoria');

        return (row($form, $id));
    }

    function editar_categoria($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp_categoria();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, $this -> table_categoria);
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    function editar_produto($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp_produtos();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, $this -> table_descricao);
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    /************************************************************************** PRODUTOS MODELO ****************************/
    function le_modelos($id) {
        $sql = "select * from " . $this -> table_modelo . " where id_pm = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $line = $rlt[0];
        return ($line);
    }

    /************************************************************************** PRODUTOS MARCA ****************************/
    function le_marca($id) {
        $sql = "select * from " . $this -> table_marca . " where id_ma = " . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $line = $rlt[0];
        return ($line);
    }

    function cp_marca() {
        $cp = array();
        array_push($cp, array('$H8', 'id_ma', '', False, True));
        array_push($cp, array('$S80', 'ma_nome', 'Nome da marca', True, True));
        array_push($cp, array('$S80', 'ma_logo', 'Link logotipo', false, True));
        array_push($cp, array('$O 1:SIM&0:NÃO', 'ma_ativo', 'Ativo', True, True));
        array_push($cp, array('$B8', '', 'Gravar', false, True));

        return ($cp);
    }

    function row_marcas($id = '') {
        $form = new form;

        $form -> fd = array('id_ma', 'ma_nome', 'ma_logo', 'ma_ativo');
        $form -> lb = array('id', msg('ma_nome'), msg('ma_logo'), msg('ma_ativo'));
        $form -> mk = array('', 'L', 'L', 'L');

        $form -> tabela = $this -> table_marca;
        $form -> see = true;
        $form -> novo = true;
        $form -> edit = true;

        $form -> row_edit = base_url('index.php/main/produtos_marca_edit');
        $form -> row_view = base_url('index.php/main/produtos_marca_view');
        $form -> row = base_url('index.php/main/produtos_marca');

        return (row($form, $id));
    }

    function row_produtos($id = '') {
        $sx = '';
        $sql = 'select * from ' . $this -> table_produto . ' WHERE id_prd = ' . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%" class="table">' . cr();
        $sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = base_url('index.php/main/produto_view/' . $line['id_pr'] . '/' . checkpost_link($line['id_pr']));
            $link = '<a href="' . $link . '">';
            $sx .= '<tr class="' . $line['ps_class'] . '">';
            $sx .= '<td>';
            $sx .= $link . $line['prd_nome'] . '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_patrimonio'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_serial'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['ps_descricao'];
            $sx .= '</td>';

            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>' . cr();
        return ($sx);
    }

    function editar_marca($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp_marca();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, $this -> table_marca);
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    function editar_etiqueta($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp_etiqueta();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, "etiqueta");
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    function editar_modelos($id, $chk) {
        $form = new form;
        $form -> id = $id;
        $cp = $this -> cp_modelos();
        $data['title'] = '';
        $data['content'] = $form -> editar($cp, $this -> table_modelo);
        $this -> load -> view('content', $data);
        return ($form -> saved);
    }

    function seta_etiqueta($id, $st) {
        $st = round($st);
        $sql = "update produtos set pr_etiqueta = $st where id_pr = " . round($id);
        $rlt = $this -> db -> query($sql);
        return (1);
    }

    function etiquetas($tp='') {
        $sz = '80'; $sy = '';
        if ($tp==2) { $sz = 50; }
        
        $sql = "select * from etiqueta where id_et = ".round('0'.$tp);
        $rlt = $this->db->query($sql);
        $rlt = $rlt->result_array();
        if (count($rlt) > 0)
            {
                $line = $rlt[0];
                $p1 = $line['st_p1'];
                $p2 = $line['st_p2'];
                $p3 = $line['st_p3'];
                $p4 = $line['st_p4'];
                $p5 = $line['st_p5'];
                $o1 = $line['st_o1'];
                $o2 = $line['st_o2'];
                $o3 = $line['st_o3'];
                $o4 = $line['st_o4'];
                $o5 = $line['st_o5'];                
            } else {
                $p1 = 60;
                $p2 = 30;
                $p3 = 90;
                $p4 = 140;
                $p5 = 0;
                $o1 = 480;
                $o2 = 30;
                $o3 = 510;
                $o4 = 90;
                $o5 = 0;
            }
        $sql = "select * from produtos 
						WHERE pr_etiqueta = 1
			";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '';
        $i = 35;

        for ($r = 0; $r < count($rlt); $r = $r + 2) {
            $line = $rlt[$r];
            $mod = trim($line['pr_modelo']);
            $mod2 = '';
            if (strlen($mod) > $i) {
                $mod2 = substr($mod, $i, 30);
                $mod = substr($mod, 0, $i);
            }
            $sx .= 'N' . cr();
            $sx .= 'q816' . cr();
            $sx .= 'Q200,24' . cr();
            $sx .= 'A'.$p3.','.$p4.',0,1,1,2,N,"' . $mod . '"' . cr();
            $sx .= 'B'.$p1.','.$p2.',0,E80,3,7,'.$sz.',B,"' . $line['pr_patrimonio'] . '"' . cr();            

            if (isset($rlt[$r + 1])) {
                $line = $rlt[$r + 1];
                $mod = trim($line['pr_modelo']);
                $mod2 = '';
                if (strlen($mod) > $i) {
                    $mod2 = substr($mod, $i, 30);
                    $mod = substr($mod, 0, $i);
                }
                $sx .= '' . cr();
                $sx .= 'A'.$o3.','.$o4.',0,1,1,2,N,"' . $mod . '"' . cr();
                $sx .= 'B'.$o1.','.$o2.',0,E80,3,7,'.$sz.',B,"' . $line['pr_patrimonio'] . '"' . cr();
            }
            $sx .= '' . cr();
            $sx .= 'P1' . cr();
        }
        echo $sx;
    }

    function etiquetas_para_imprimir() {
        $sql = "select * from produtos 
                    INNER JOIN produtos_categoria ON id_pc = pr_categoria
                    INNER JOIN produto_nome ON id_pn = pr_produto
                        WHERE pr_etiqueta = 1
                        order by pc_nome, pc_nome, pr_serial
            ";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '';
        $i = 35;
        $xcat = '';
        for ($r = 0; $r < count($rlt); $r = $r + 1) {
            $line = $rlt[$r];
            $mod = trim($line['pr_modelo']);
            $cat = $line['pc_nome'];
            if ($cat != $xcat) {
                $xcat = $cat;
                $sx .= '<div class="row">';
                $sx .= '<div class="col-md-12"><h3>' . $cat . '</h3></div>';
                $sx .= '</div>' . cr();
            }
            $sx .= '<div class="row">';
            $sx .= '<div class="col-md-1">';
            $sx .= '<b>#' . strzero($r + 1, 3) . '</b>';
            $sx .= '</div>' . cr();

            $sx .= '<div class="col-md-2">';
            $sx .= $line['pr_patrimonio'];
            $sx .= '</div>' . cr();

            $sx .= '<div class="col-md-4">';
            $sx .= $line['pn_descricao'];
            $sx .= '</div>' . cr();

            $sx .= '<div class="col-md-2">';
            $sx .= $line['pr_serial'];
            $sx .= '</div>' . cr();

            $sx .= '<div class="col-md-2">';
            $sx .= $line['pr_modelo'];
            $sx .= '</div>' . cr();

            $sx .= '<div class="col-md-1">';
            $sx .= '</div>' . cr();

            $sx .= '</div>' . cr();
            $sx .= cr();
        }
        return ($sx);
    }

    function historico_produto($id)
        {
            $sx = '<h3>Histórico do produto</h3>';
            
            $sql = "select * from produtos_historico
                        left join produtos_historico_tipo on ph_historico = id_ht 
                        where ph_produto = $id ";
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            $sx .= '<table class="table">';
            $sx .= '<tr>';
            $sx .= '<th width="20%">data e hora</th>';
            $sx .= '<th width="70%">descrição</th>';
            $sx .= '<th width="10%" align="right">pedido</th>';
            $sx .= '</tr>';
            for ($r=0;$r < count($rlt);$r++)
                {
                    $line = $rlt[$r];
                    $sx .= '<tr>';
                    $sx .= '<td>'.stodbr($line['ph_data']).' '.substr($line['ph_data'],11,8).'</td>';
                    $sx .= '<td>'.$line['ht_descricao'].'</td>';
                    $sx .= '<td align="center">'.strzero($line['ph_pedido'],7).'</td>';
                    $sx .= '</tr>';
                    $sx .= cr();
                }
            $sx .= '</table>';
            return($sx);
        }

    function lista_produtos_categoria($id) {
        $sql = 'select * from ' . $this -> table_produto . ' 
                    WHERE id_pc = ' . round($id).'
                    ORDER BY pr_tag, pr_patrimonio';
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%" class="table">' . cr();
        $sx .= '<tr>
						<th>N. tombo</th>
						<th>Barcode</th>
						<th>nº série</th>
						<th>situação</th>
						<th>unidade</th>
					</tr>';
        $tot = 0;
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $tot++;
            $link = base_url('index.php/main/produto/' . $line['id_pr'] . '/' . checkpost_link($line['id_pr']));
            $link = '<a href="' . $link . '">';
            $sx .= '<tr class="' . $line['ps_class'] . '">';
            $sx .= '<td>';
            $sx .= $link . $line['pr_tag'] . '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_patrimonio'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_serial'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['ps_descricao'];
            $sx .= '</td>';

            $link = base_url('index.php/main/produtos_relatorio/0/' . $line['id_fi'] . '/' . checkpost_link($line['id_fi']));
            $link = '<a href="' . $link . '">';

            $sx .= '<td>';
            $sx .= $link.$line['fi_nome_fantasia'].'</a>';
            $sx .= '</td>';

            $sx .= '</tr>' . cr();
        }
        $sx .= '<tr class="' . $line['ps_class'] . '">';
        $sx .= '<td align="right" colspan=6 >';
        $sx .= 'Total '.$tot.' iten(s)';
        $sx .= '</td></tr>';
        $sx .= '</table>' . cr();
        return ($sx);
    }

    function lista_produtos_descricao($id) {
        $sql = 'select * from ' . $this -> table_produto . '
					inner join produto_nome on id_pn = pr_produto 
					WHERE pr_produto = ' . round($id);
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%" class="table">' . cr();
        $sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = base_url('index.php/main/produto_view/' . $line['id_pr'] . '/' . checkpost_link($line['id_pr']));
            $link = '<a href="' . $link . '">';
            $sx .= '<tr class="' . $line['ps_class'] . '">';
            $sx .= '<td>';
            $sx .= $link . $line['prd_nome'] . '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_patrimonio'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['pr_serial'];
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $line['ps_descricao'];
            $sx .= '</td>';

            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>' . cr();
        return ($sx);
    }

    function locacao_categorias($id) {
        $sql = "select pn_descricao, id_pn from produto_nome
		              INNER JOIN produtos ON pr_produto = id_pn  
		              where pn_ativo = 1 
		              GROUP BY pn_descricao, id_pn
		              ORDER BY pn_descricao";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%">';
        $sx .= '<tr><th>Descrição</th></tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = base_url('index.php/main/locacao_item_novo/' . $id . '/' . $line['id_pn']);
            $link = '<a href="' . $link . '">';
            $sx .= '<tr class="table">';
            $sx .= '<td>';
            $sx .= $link . $line['pn_descricao'] . '</a>';
            $sx .= '</td>';
        }        $sx .= '</table>';
        return ($sx);
    }

    function locacao_item($id, $ct) {
        $sql = "SELECT * FROM produto_nome 
					INNER JOIN produtos ON pr_produto = id_pn
					LEFT JOIN produtos_marca ON pr_marca = id_ma 
					LEFT JOIN _filiais ON pr_filial = id_fi
					WHERE pr_produto = $ct and pr_ativo > 0
					";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%">';
        $sx .= '<tr>
		              <th>Patrimonio</th>
		              <th>Barcod</th>
		              <th>Marca</th><th>Serial</th>
		              <th>Filial</th></tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = base_url('index.php/main/locacao_item_novo/' . $id . '/' . $ct . '/' . $line['id_pr']);
            $link = '<a href="' . $link . '">';
            $sx .= '<tr class="table">';
            $sx .= '<td>';
            $sx .= $link . UpperCase($line['pr_tag']) . '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $link . $line['pr_patrimonio'] . '</a>';
            $sx .= '</td>';
            $sx .= '<td>';
            $sx .= $link . $line['ma_nome'] . '</a>';
            $sx .= '</td>';
            $sx .= '<td>';
            $sx .= $link . $line['pr_serial'] . '</a>';
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= $link . $line['fi_nome_fantasia'] . '</a>';
            $sx .= '</td>';
        }
        $sx .= '</table>';
        return ($sx);
    }

    function items_por_pedido($pd)
        {
            $sql = "select * from produto_agenda
                        inner join produtos on id_pr = ag_produto
                        inner join produto_nome ON pr_produto = id_pn
                        left join produtos_marca ON id_ma = pr_marca
                        where ag_pedido = ".$pd." order by id_ag desc";
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            $sx = '<table wdith="100%" class="table">';
            $sx .= '<tr><th>Patrimonio</th>
                        <th>Barcod</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Reservado em</th>
                        </tr>';
            for ($r=0;$r < count($rlt);$r++)
                {
                    $line = $rlt[$r];
//                    echo '<hr>';
                    //print_r($line);
                    $sx .= '<tr>';
                    $sx .= '<td>';
                    $sx .= $line['pr_tag'];
                    $sx .= '</td>';

                    $sx .= '<td>';
                    $sx .= $line['pr_patrimonio'];
                    $sx .= '</td>';
                    
                    $sx .= '<td>';
                    //$sx .= $line['pn_descricao'];
                    $sx .= $line['ma_nome'];
                    $sx .= '</td>';                    

                    $sx .= '<td>';
                    $sx .= $line['pr_modelo'];
                    $sx .= '</td>';
                    
                    $sx .= '<td>';
                    $sx .= stodbr($line['ag_data_reserva']);
                    $sx .= ' ';
                    $sx .= $line['ag_hora_reserva'];
                    $sx .= '</td>';


                    $sx .= '</tr>';
                }
            $sx .= '</table>';
            return($sx);
        }

    function items_por_pedido_devolvido($pd)
        {
            $sql = "select * from produto_agenda
                        inner join produtos on id_pr = ag_produto
                        inner join produto_nome ON pr_produto = id_pn
                        left join produtos_marca ON id_ma = pr_marca
                        where ag_pedido = ".$pd." 
                        and ag_situacao = 3
                        order by ag_devolucao desc, ag_devolucao_hora desc";

                                                
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            $sx = '<table wdith="100%" class="table">';
            $sx .= '<tr><th>Patrimonio</th>
                        <th>Barcod</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Reservado em</th>
                        </tr>';
            for ($r=0;$r < count($rlt);$r++)
                {
                    $line = $rlt[$r];
//                    echo '<hr>';
                    //print_r($line);
                    $sx .= '<tr>';
                    $sx .= '<td>';
                    $sx .= $line['pr_tag'];
                    $sx .= '</td>';

                    $sx .= '<td>';
                    $sx .= $line['pr_patrimonio'];
                    $sx .= '</td>';
                    
                    $sx .= '<td>';
                    //$sx .= $line['pn_descricao'];
                    $sx .= $line['ma_nome'];
                    $sx .= '</td>';                    

                    $sx .= '<td>';
                    $sx .= $line['pr_modelo'];
                    $sx .= '</td>';
                    
                    $sx .= '<td>';
                    $sx .= stodbr($line['ag_data_reserva']);
                    $sx .= ' ';
                    $sx .= $line['ag_hora_reserva'];
                    $sx .= '</td>';


                    $sx .= '</tr>';
                }
            $sx .= '</table>';
            return($sx);
        }

    /****************** LOGISTICA *************/
    function movimenta_para_estoque($id, $tipo = 0) {
        $user = $_SESSION['id'];
        $et = 0;
        if ($tipo == 5) {
            $et = 1;
        }
        $sql = "update produtos set
						pr_etiqueta = $et,
						pr_ativo = 1,
						pr_cliente = 0,
						pr_doc = 0
					where id_pr = " . round($id);
        $rlt = $this -> db -> query($sql);
        $sql = "insert into produtos_historico
						(
							ph_produto, ph_historico, ph_log,
							ph_pedido
						)
						values
						(
							$id,$tipo,$user,
							0
						)";
        $rlt = $this -> db -> query($sql);
        return (1);
    }

    function produto_devolucao_serie($serie, $id, $d1) {
        $sql = "select * from produto_agenda
                        inner join produtos on id_pr = ag_produto
                        inner join produto_nome ON pr_produto = id_pn                       
                    where ag_pedido = '$id' and (ag_situacao = 1 or ag_situacao = 2)
                        AND (pr_tag like '%$serie%' OR pr_patrimonio = '$serie')                            
                    ";

        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();

        if (count($rlt) == 1) {
            $line = $rlt[0];
            $err = $this -> produto_registra_devolucao($line, $d1);
            if (strlen($err) == 0) {
                $sx = '<div class="alert alert-success">
                                        <strong>Item devolvido com sucesso!</strong>
                                    </div>';
            } else {
                $sx = '<div class="alert alert-danger">
                                        <strong>' . $err . '</strong>
                                    </div>';
            }
            return ($sx);
        }
        $sx = '';

        $sx .= '<table width="100%" class="table" style="border: 1px solid #000000;">';
        $sx .= '<tr><th width="10%">Patrimonio</th>
                            <th width="10%">BarCod</th>
                            <th>Descricao</th>
                            <th width="10%">Período</th>
                            <th width="10%">Até</th>
                            </tr>' . cr();

        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $sx .= '<tr>';
            $sx .= '<td>' . UpperCase($line['pr_tag']) . '</td>';
            $sx .= '<td>' . UpperCase($line['pr_patrimonio']) . '</td>';

            $sx .= '<td>' . $line['pn_descricao'] . '</td>';

            $sx .= '<td>' . stodbr($line['ag_data_reserva']) . '</td>';
            $sx .= '<td>' . stodbr($line['ag_data_reserva_ate']) . '</td>';

            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>' . cr();
        return ($sx);

    }

    function produto_registra_serie($serie, $ped, $d1, $d2, $cliente = 1) {
        $serie = substr($serie,0,7);
        $sql = "SELECT * FROM `produtos`where pr_tag = '$serie' or pr_patrimonio = '$serie' ";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) == 0) {
            $sx = '<div class="alert alert-danger">
                                <strong>Produto não localizado!</strong> Patrimonio não localizado na base.
                                <div class="col-md-4 text-right">
                                    <a href="' . base_url('index.php/main/produtos_cadastrar_serial?dd99=' . $serie) . '" target="_new' . date("YmdHis") . '"  class="btn btn-default">Cadastrar</a>
                                    <a href="#"  class="btn btn-default" onclick="window.history.back();">Voltar</a>                                    
                                </div>
                            </div>';
            $data['title'] = '';
            $data['content'] = $sx;
            echo $sx;
            $this -> load -> view('content', $data);
            exit;
            return('');
            $err = '';
            return ($err);
        } else {
            $line = $rlt[0];
            $prod = $line['id_pr'];
            $err = $this -> produto_registra($prod, $ped, $d1, $d2, $cliente);
            if (strlen($err) == 0) {
                $sx = '<div class="alert alert-success">
                                        <strong>Item incluído com sucesso!</strong>
                                    </div>';
            } else {
                $sx = '<div class="alert alert-danger">
                                        <strong>' . $err . '</strong>
                                    </div>';
            }
            return ($sx);
        }
    }

    function produto_registra_devolucao($ln, $dt) {
        $err = '';
        $sit = $ln['ag_situacao'];
        $ida = $ln['id_ag'];
        $time = date("H:i:s");
        if (($sit == 1) or ($sit == 2)) {
            $sql = "update produto_agenda set ag_situacao = 3, ag_devolucao = '$dt' , ag_devolucao_hora = '$time'
                                where id_ag = " . $ida;
            $rlt = $this -> db -> query($sql);
            $dt = array();
            $dt['id_hs'] = 5;
            $dt['nr_pedido'] = $ln['ag_pedido'];
            $dt['id_pr'] = $ln['ag_produto'];
            $this -> produtos -> inserir_historico($dt);
        } else {
            $err = 'Item já devolvido ou cancelado';
        }

        return ($err);
    }

    function produto_registra($prod, $ped, $d1, $d2, $cliente = 1) {
        $data = date("Y-m-d");
        $hora = date("H:i:s");
        $cliente = 1;
        $res = 0;
        $sit = 1;
        $vend = $_SESSION['id'];
        $sql = "select * from produto_agenda 
						WHERE ag_produto = $prod and
						      ag_cliente = $cliente and
						      ag_data_reserva = $d1 and
						      (ag_situacao = 1 OR ag_situacao = 2)";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) > 0) {
            $err = "Item já incluído na locação ou no já está no cliente.";
            return ($err);
        }
        $sql = "insert into produto_agenda 
						(ag_produto, ag_data, ag_cliente, 
						ag_vendedor, ag_data_reserva, ag_data_reserva_ate, 
						ag_hora_reserva, ag_reservado, ag_situacao,
						ag_pedido)
						values
						($prod,'$data',$cliente,
						$vend,'$d1','$d2',
						'$hora','$res','$sit',
						$ped
						)
			";
        $rlt = $this -> db -> query($sql);
        return ('');
    }

    function produtos_reservados($id) {
        $sql = "select * from produto_agenda
						inner join produtos on id_pr = ag_produto
						inner join produtos_categoria  ON pr_categoria = id_pc
						inner join produtos_marca ON id_ma = pr_marca						
					where ag_pedido = $id
					order by ag_situacao
					";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table class="table" width="100%">';
        $sx .= '<tr class="small">';
        $sx .= '<th>patrimônio</th>';
        $sx .= '<th>descrição</th>';
        $sx .= '<th>marca</th>';
        $sx .= '<th>modelo</th>';
        $sx .= '<th>barcode</th>';
        $sx .= '<th>situacao</th>';
        $sx .= '<th style="text-center" width="10%">início</th>';
        $sx .= '<th style="text-center" width="10%">fim</th>';
        $sx .= '<th style="text-center" width="10%">devolução</th>';
        $sx .= '<th style="text-center" width="3%">#</th>';
        $sx .= '</tr>';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $idag = $line['id_ag'];
            $status = $line['ag_situacao'];

            switch($status) {
                case '1' :
                    $bg = ' class="alert alert-success" ';
                    break;
                case '2' :
                    $bg = ' class="alert alert-info" ';
                    break;
                case '9' :
                    $bg = ' class="alert alert-danger nopr" ';
                    break;
                default :
                    $bg = '';
                    break;
            }
            $link = 'onclick="newxy(\'' . base_url('index.php/main/locacao_item_editar/' . $idag . '/' . checkpost_link($id)) . '\',800,600);" style="cursor: pointer;" ';
            $sx .= '<tr ' . $bg . '>';

            $sx .= '<td align="left">';
            $sx .= $line['pr_tag'];
            $sx .= '</td>';

            $sx .= '<td align="left">';
            $sx .= $line['pc_nome'];
            $sx .= '</td>';


            $sx .= '<td align="left">';
            $sx .= $line['ma_nome'];
            $sx .= '</td>';

            $sx .= '<td align="left">';
            $sx .= $line['pr_modelo'];
            $sx .= '</td>';

            $sx .= '<td align="left">';
            $sx .= $line['pr_patrimonio'];
            $sx .= '</td>';

            $sx .= '<td align="left">';
            $sx .= msg('situacao_' . $line['ag_situacao']);
            $sx .= '</td>';

            $sx .= '<td align="center">';
            $sx .= stodbr($line['ag_data_reserva']);
            $sx .= '</td>';

            $sx .= '<td align="center">';
            $sx .= stodbr($line['ag_data_reserva_ate']);
            $sx .= '</td>';

            $sx .= '<td align="center">';
            $sx .= stodbr($line['ag_devolucao']);
            $sx .= '</td>';

            $sx .= '<td>';
            $sx .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true" ' . $link . '></span>';
            $sx .= '</td>';

            $sx .= '</tr>';
        }
        $sx .= '</table>';
        return ($sx);
    }

    function updatex() {
        $sql = "update produtos set pr_patrimonio = lpad(id_pr,7,0) where pr_patrimonio = '' or pr_patrimonio is null";
        $rlt = $this -> db -> query($sql);

    }

    function estoque_geral($lj) {
        $table = $this -> table_produto;

        $sql = "select * from " . $table . " 
                        where pr_ativo = 1
                        order by fi_nome_fantasia, pc_nome, pr_tag";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '';
        $pc_nome_x = '';
        $nv = 0;
        $tot = 0;
        $totg = 0;
        $last = '';
        $filialx = '';
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $filial = $line['fi_nome_fantasia'];
            if ($filial != $filialx) {
                $sx .= '<div class="row">';
                $sx .= '<div class="col-md-12">';
                $sx .= '<h3>' . $filial . '</h3>';
                $sx .= '</div>';
                $sx .= '</div>';
                $filialx = $filial;
            }
            $pc_nome = $line['pc_nome'];

            if ($pc_nome != $pc_nome_x) {
                if ($tot > 0) {
                    $sx .= '<div class="col-md-12 text-right">Total ' . $tot . '</div>';
                    $tot = 0;
                }
                $sx .= '<div class="row">';
                $sx .= '<div class="col-md-12 big">';
                $sx .= $pc_nome;
                $sx .= '</div>';
                $sx .= '</div>';
                $pc_nome_x = $pc_nome;
            }
            /**********************************************/
            $cor = '';
            $cora = '';
            if ($last == $line['pr_tag']) {
                $cor = '<span style="color: red">';
                $cora = '</span>';
            }

            $last = $line['pr_patrimonio'].' ('.$line['pr_tag'].')';

            /**********************************************/
            $link = '<a href="' . base_url('index.php/main/produto/' . $line['id_pr']) . '" target="_new_' . $line['id_pr'] . '">';
            $linka = '</a>';
            $sx .= '<div class="col-md-1">' . $link . $cor . $line['pr_patrimonio'].' ('.$line['pr_tag'].')' . $cora . $linka . '</div>';
            $tot++;
            $totg++;
        }
        if ($tot > 0) {
            $sx .= '<div class="col-md-12 text-right">Total ' . $tot . '</div>';
            $tot = 0;
        }
        if ($totg > 0) {
            $sx .= '<div class="col-md-12 text-right"><b>Total Geral ' . $totg . ' Itens</div>';
            $tot = 0;
        }
        $sx .= '';
        return ($sx);
    }
    function itens_status($pd,$st)
        {
            $sql = "select * from produto_agenda
                        INNER JOIN produtos ON ag_produto = id_pr
                        where ag_pedido = ".$pd;
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            $sx = '<table width="100%" class="table">';
            $sx .= '<tr>
                        <th>#</th>
                        <th>Barcode</th>
                        <th>Serial</th>
                        <th>Modelo</th>
                        <th>Entrega</th>
                        <th>Devolução</th>
                    </tr>';
            for ($r=0;$r < count($rlt);$r++)
                {
                   $line = $rlt[$r];
                   
                   $sx .= '<tr>';
                   $sx .= '<td>';
                   $sx .= $line['pr_patrimonio'];
                   $sx .= '</td>';

                   $sx .= '<td>';
                   $sx .= $line['pr_serial'];
                   $sx .= '</td>';
                    

                   $sx .= '<td>';
                   $sx .= $line['pr_modelo'];
                   $sx .= '</td>';
                                        
                   $sx .= '<td>';
                   $sx .= stodbr($line['ag_data_reserva']);
                   $sx .= '</td>';
                   
                   $sx .= '<td>';
                   $sx .= stodbr($line['ag_data_reserva_ate']);
                   $sx .= '</td>';
                   
                   $sx .= '</tr>';
                }
            return($sx);
        }

    function itens_atualiza_status($pd,$st1,$st2)
        {
            
            $sql = "update produto_agenda set ag_situacao = ".$st2." where ag_situacao = ".$st1." and ag_pedido = ".$pd;
            $rlt = $this->db->query($sql);
            return(1);
        }
}
?>
