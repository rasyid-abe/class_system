<?php
namespace Config;

class MyValidations
{
      public function my_unique(string $str, ?string &$param = null, array $data = null): bool
      {
            $db = \Config\Database::connect();

            $params = explode('.',$param);
            $table = $params[0].'_'.$params[1];

            $manyFields = explode('-', $params[2]);
            $where = '';
            if (count($manyFields) < 2) {
                  $field = $params[1].'_'.$params[2];
            } else {
                  $field = $params[1].'_'.$manyFields[0];
                  for ($i=1; $i < count($manyFields) ; $i++) { 
                        $uniqf = explode('>', $manyFields[$i]);
                        if ($uniqf[0] == 'mts') {
                              $where .= " AND ".$params[1].'_time = "'.$uniqf[1].' - '.$str.'"';
                        } else {
                              $where .= " AND ".$params[1].'_'.$uniqf[0]." = '".$uniqf[1]."'";
                        }

                  }
            }

            $status = $params[1].'_status';
            $school = $params[1].'_school_id';

            if ($params[0] == 'account') {
                  $sql = "SELECT ".$field." FROM ".$table." WHERE ".$field." = '".$str."' AND ".$status." < 9";
            } else if ($params[1] == 'teaching_schedule') {
                  $sql = "SELECT ".$field." FROM ".$table." WHERE ".$status." < 9 AND ".$school." = " . userdata()['school_id'] . $where;
            } else {
                  $sql = "SELECT ".$field." FROM ".$table." WHERE ".$field." = '".$str."' AND ".$status." < 9 AND ".$school." = " . userdata()['school_id'] . $where;
            }

            $row = $db->query($sql)->getNumRows();
            
            return $row < 1 ? true : false;
      }

}
