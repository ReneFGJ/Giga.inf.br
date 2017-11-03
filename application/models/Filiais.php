<?php
class filiais extends CI_model
    {
        function filiais()
            {
                $sql = "select * from _filiais where fi_ativo = 1";
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                return($rlt);                
            }      
    }
?>
