<?php namespace AlexMarTech\CoreLumenV2\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait Relations {

    //---------------------------------------------------------------------------------------------------

    /**
     * Recupera la lista delle relazioni da inserire e pulisce
     * l'array contenente i dati della richiesta.
     *
     * Se l'array $data è formato in questo modo:
     *  [
     *      'key' => 'value',
     *      'key1' => 'value1',
     *      'key3' => [
     *          'subkey' => 'subvalue'
     *       ]
     * ]
     *
     * Restituisce i dati della richiesta senza la chiave 'key3'
     * e tale chiave verrà considerata una relazione che verrà inserita post
     * creazione della risorsa.
     *
     * @access protected
     *
     * @param array &$data  Dati della richiesta
     *
     * @return array    Dati della richiesta puliti
     */
    protected function extractRelations(array &$data) : array {

        $relations = [];

        // Ciclo l'array data per trovare sottoarray,
        // se ci sono li estraggo
        foreach ( $data as $key => $value ) {
            if ( is_array($value) ) {
                $relations[$key] = $value;
                unset($data[$key]);
            }
        }

        return $relations;
    }

    //---------------------------------------------------------------------------------------------------

    protected function storeRelations(Model $model, string $relation, array $values) : void {

        $relationType = $model->{$relation}();

        if ( $relationType instanceof HasMany  ) {
            $model->{$relation}()->createMany($values);
        }
        else if ($relationType instanceof HasOne) {
            $model->{$relation}()->create($values);
        }
        else if ( $relationType instanceof BelongsToMany ) {

            $sync = [];

            $key = $relation.'_id';

            foreach ( $values as $value ) {

                if ( ! isset($value[$key]) ) {

                    error("La creazione dell'associazione", [
                        'model' => $model::class,
                        'relation'  => $relation,
                        'values'    => $value
                    ]);

                    continue;
                }

                $id = $value[$key];
                unset($value[$key]);

                $sync[$id] = $value;
            }

            $model->{$relation}()->sync($sync);

        }


    }

    //---------------------------------------------------------------------------------------------------

}