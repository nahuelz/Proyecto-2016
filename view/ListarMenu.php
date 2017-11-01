<?php

class ListarMenu extends TwigView {

    public function show($menus, $args, $cant_total_elementos, $cant_elementos, $pagina,$fecha) {

        $args = array_merge($args, ['menus' => $menus, 'isLogged' => true, 'cant_total_elementos' => $cant_total_elementos[0],'cant_elementos' => $cant_elementos,'pagina' => $pagina, 'fecha' => $fecha]);
;
        echo self::getTwig()->render('listar_menus.html.twig', $args);

    }
}