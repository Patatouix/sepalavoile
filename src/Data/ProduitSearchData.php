<?php

namespace App\Data;

use App\Entity\ProduitType;

/**
 * Objet représentant les données associées au formulaire de filtrage des produits.
 * Tuto grafikart : https://www.grafikart.fr/tutoriels/filtre-produit-symfony-1211
 */
class ProduitSearchData
{
    /**
     * @var ProduitType[]
     */
    public $produitTypes = [];

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;
}