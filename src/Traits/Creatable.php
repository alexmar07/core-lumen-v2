<?php namespace AlexMarTech\CoreLumenV2\Traits;

use Illuminate\Database\Eloquent\Model;

trait Creatable {

    use Relations;

    public function store(array $data) : Model {

        info($this->tag. ': Richiesta creazione della risorsa', ['data' => $data]);

        $data = $this->beforeStore($data);

        $relations = $this->extractRelations($data);

        // Creazione
        $resource = $this->repository->create($data);

        info($this->tag. ': Creazione della risorsa', ['resource' => $resource]);


        $relations = $this->afterStore($resource, $relations);

        if ( ! empty($relations)) {
            foreach ( $relations as $relation => $values) {
                $this->storeRelations($resource, $relation, $values);
            }
        }

        return $resource;
    }

    protected function beforeStore(array $data) : array {
        return $data;
    }
}