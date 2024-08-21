<?php

namespace App\Models\Datas;

use CodeIgniter\Model;

class TerritoryModel extends Model
{
    public function list_province()
    {
        $query = "
            SELECT * FROM data_territory GROUP BY SUBSTRING(territory_code,1,2)
        ";

        return $this->db->query($query)->getResultArray();
    }
    
    public function list_area($fil)
    {
        $query = "
            SELECT * FROM data_territory 
            WHERE LEFT(territory_code, ".$fil['fillen'].") = '".$fil['code']."'
            AND CHAR_LENGTH(territory_code) = ".$fil['len']."
        ";
        return $this->db->query($query)->getResultArray();
    }

    public function arr_id_prov()
    {
        $spr = '","';
        $query = "
        SELECT GROUP_CONCAT(territory_code SEPARATOR ".$spr.") AS arr
        FROM data_territory
        WHERE CHAR_LENGTH(territory_code) = 2;
        ";

        return $this->db->query($query)->getRow('arr');
    }
    
    public function arr_id_rege($fillen, $code, $len)
    {
        $spr = '","';
        $query = "
        SELECT GROUP_CONCAT(territory_code SEPARATOR ".$spr.") AS arr
        FROM data_territory
        WHERE CHAR_LENGTH(territory_code) = ".$len."
        AND LEFT(territory_code, ".$fillen.") = '".$code."';
        ";

        return $this->db->query($query)->getRow('arr');
    }
}

