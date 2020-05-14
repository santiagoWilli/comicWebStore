<?php

namespace App\Twig;
use App\Service\CursosDataAccess;
use App\Service\EmpresaDataAccess;
use App\Service\UserDataAccess;
use App\Service\UsuarioDataAccess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class customFilters extends AbstractExtension {

    /*Filtros*/
    public function getFilters() {
        return array(
            new TwigFilter('role', [$this, 'getUserRole']),
            new TwigFilter('serialize', [$this, 'serialize']),
        );
    }

    public function getUserRole($input) {
        $ROLES = [
            1 => "Administrador",
            4 => "Usuario"
        ];

        return $ROLES[$input];
    }

    public function serialize($input) {
        return base64_encode(serialize($input));
    }

}