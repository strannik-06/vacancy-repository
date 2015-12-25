<?php

namespace Netwerven;

use Netwerven\Sources\SourceInterface;
use Netwerven\Model\Vacancy;

/**
 * Main Vacancy Repository
 */
class VacancyRepository
{
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
