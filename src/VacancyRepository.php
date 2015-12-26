<?php

namespace Netwerven;

use Netwerven\Sources\SourceInterface;
use Netwerven\Model\Vacancy;

/**
 * Vacancy Repository can get vacancies from different sources. Sources can be added and removed dynamically.
 */
class VacancyRepository
{
    /**
     * @var array
     */
    private $sources = array();

    /**
     * @param array $sources
     */
    public function __construct(array $sources = array())
    {
        /* @var SourceInterface $source */
        foreach ($sources as $source) {
            $this->addSource($source);
        }
    }

    /**
     * @param SourceInterface $source
     */
    public function addSource(SourceInterface $source)
    {
        $this->sources[$source->getName()] = $source;
    }

    /**
     * @param SourceInterface $source
     *
     * @return bool
     */
    public function removeSource(SourceInterface $source)
    {
        unset($this->sources[$source->getName()]);
    }

    /**
     * Find one vacancy by id from all sources.
     *
     * @param $id
     *
     * @return Vacancy|null
     */
    public function find($id)
    {
        /* @var SourceInterface $source */
        foreach ($this->sources as $source) {
            if ($vacancy = $source->find($id)) {
                return $vacancy;
            }
        }

        return null;
    }

    /**
     * Find all vacancies from all sources. Vacancy can be taken only once - from first source where it was found.
     *
     * @return Vacancy[]
     */
    public function findAll()
    {
        $allVacancies = array();

        /* @var SourceInterface $source */
        foreach ($this->sources as $source) {
            $vacancies = $source->findAll();
            /* @var Vacancy $vacancy */
            foreach ($vacancies as $vacancy) {
                if (!isset($allVacancies[$vacancy->id])) {
                    $allVacancies[$vacancy->id] = $vacancy;
                }
            }
        }

        return $allVacancies;
    }

    /**
     * Find one vacancy by id from certain source by source name.
     *
     * @param integer $id
     * @param string  $sourceName
     *
     * @return Vacancy|null
     */
    public function findInSource($id, $sourceName)
    {
        if ($this->sources[$sourceName]) {
            /** @var SourceInterface $source */
            $source = $this->sources[$sourceName];

            return $source->find($id);
        }

        return null;
    }

    /**
     * Find all vacancies from certain source by source name.
     *
     * @param string $sourceName
     *
     * @return Vacancy[]
     */
    public function findAllInSource($sourceName)
    {
        if ($this->sources[$sourceName]) {
            /** @var SourceInterface $source */
            $source = $this->sources[$sourceName];

            return $source->findAll();
        }

        return array();
    }
}
