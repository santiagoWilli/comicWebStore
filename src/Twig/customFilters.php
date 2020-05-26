<?php

namespace App\Twig;
use App\Service\ComicDataAccess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class customFilters extends AbstractExtension {

    private $comicDataAccess;

    public function __construct(ComicDataAccess $comicDataAccess)
    {
        $this->comicDataAccess = $comicDataAccess;
    }

    /*Filtros*/
    public function getFilters() {
        return array(
            new TwigFilter('role', [$this, 'getUserRole']),
            new TwigFilter('serialize', [$this, 'serialize']),
            new TwigFilter('genres', [$this, 'getComicGenres']),
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

    public function getComicGenres($input) {
        return $this->comicDataAccess->getTagsFromComic($input);
    }

}