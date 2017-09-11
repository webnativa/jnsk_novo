<?php

namespace Keep\Helper;

class Filter {

    public static function configure(array $filters) {
        
        if(array_key_exists('page', $filters)){
            unset($filters['page']);
        }
        
        $filter_itens = '';
        foreach ($filters as $key => $param) {
            if (!empty($param)) {
                $field = str_replace('_', '.', $key);
                
                if($field == 'u.nome' || $field == 'q.nome'){
                    $filter_itens .= " And $field Like '%$param%'";
                }else{
                    $filter_itens .= " And $field = '$param'";
                }
                
            }
        }
        return $filter_itens;
    }
    

}
