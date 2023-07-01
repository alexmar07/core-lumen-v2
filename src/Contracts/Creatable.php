<?php namespace AlexMarTech\CoreLumenV2\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interfaccia per l'implementazione della
 * creazione di una risorsa
 *
 * @method \Illuminate\Database\Eloquent\Model store(array $data)
 */
interface Creatable {

    //---------------------------------------------------------------------------------------------------

    /**
     * Crea una nuova risorsa.
     *
     * @param array $data   Dati della risorsa
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data) : Model;

    //---------------------------------------------------------------------------------------------------
}