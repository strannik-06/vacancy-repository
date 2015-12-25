<?php

namespace Netwerven\Sources;

use Netwerven\Model\Vacancy;

/**
 * Source interface
 */
interface SourceInterface
{
    /**
     * Unique string identifier for each source.
     *
     * @return string
     */
    public function getName();

    /**
     * Find one vacancy by id.
     *
     * @param $id
     *
     * @return Vacancy|null
     */
    public function find($id);

    /**
     * @return Vacancy[]
     */
    public function findAll();
}
