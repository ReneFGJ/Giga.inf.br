<div class="row">
	<div class="col-md-12">
		Empresas
	</div>
</div>
<div class="row">
    <?php 
    $cia = -1;
    $class = "btn-default'";
    
    if (isset($_SESSION['cia']) and (strlen($_SESSION['cia']) > 0))
        {
            $cia = round($_SESSION['cia']);
        } else {
            $class = "btn-primary";
        }

    $link = base_url('index.php/'.$path.'/'.$dia.'/X');
    echo '
    <div class="col-md-1">
        <a href="'.$link.'" class="btn '.$class.' text-center" style="width:100%;">::Todas</a>
    </div>'.cr();
    if (strlen($dia) == 0)
        {
            $dia = date("Ymd");
        }
    for ($r=0;$r < count($filiais);$r++)
        {
            $line = $filiais[$r];
            $link = base_url('index.php/'.$path.'/'.$dia.'/'.$line['id_fi']);
            echo '<div class="col-md-3">'.cr();
            $class = "btn-default";
            if ($line['id_fi'] == $cia)
                {
                    $class="btn-primary";
                }
            echo '<a href="'.$link.'" class="btn '.$class.' text-center" style="width:100%;">'.$line['fi_nome_fantasia'].'</a>'.cr();
            echo '</div>'.cr();
        }
    ?>        
</div>
