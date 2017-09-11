<?php

namespace Keep\Helper;

use Zend\Authentication\Storage\Session as SessionStorage;

class PermissoesView {

    public function permitido($user, $rota) {

        $is_super_usuario = $user->getSuper();

        if ($is_super_usuario) {
            return;
        }

        // Lista as permissões do grupo
        $permissoesGrupo = $user->getPermissoes();
        $areasPermitidas = array();

        foreach ($permissoesGrupo as $value) {

            $controller = $value->getPermissao()->getController();
            $action = $value->getPermissao()->getAction();

            $areasPermitidas[$controller][$action] = $action;
        }
        
        
        $html = "";
        
        if (!in_array('novo', $areasPermitidas[$rota])) {
            $html .= ".permissao_add{display:none !important;} ";
        }
        
        if (!in_array('editar', $areasPermitidas[$rota])) {
            $html .= ".permissao_editar{display:none !important;} ";
        }
        
        if (!in_array('remover', $areasPermitidas[$rota])) {
            $html .= ".permissao_remover{display:none !important;} ";
        }
        
        if (!in_array('detalhes', $areasPermitidas[$rota])) {
            $html .= ".permissao_detalhes{display:none !important;} ";
        }
        
        return $html;
    }

}
