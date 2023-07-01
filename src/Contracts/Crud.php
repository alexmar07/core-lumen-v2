<?php namespace AlexMarTech\CoreLumenV2\Contracts;

/**
 * Interfaccia per l'implementazione di servizio
 * crud completo
 *
 * @extends parent<Creatable>
 *
 * @method \Illuminate\Database\Eloquent\Model store(array $data)
 */
interface Crud extends Creatable {}