<?php

class ListarEgresos extends TwigView {

    public function show($egresos, $args, $cant_total_elementos, $cant_elementos, $pagina) {

        $args = array_merge($args, ['isLogged' => true]);
        $args = array_merge($args, ['egresos' => $egresos]);
        $args = array_merge($args, ['cant_total_elementos' => $cant_total_elementos[0]]);
        $args = array_merge($args, ['cant_elementos' => $cant_elementos]);
        $args = array_merge($args, ['pagina' => $pagina]);
        echo self::getTwig()->render('listar_egresos.html.twig', $args);

    }

}