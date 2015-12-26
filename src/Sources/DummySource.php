<?php

namespace Netwerven\Sources;

use Netwerven\Model\Vacancy;

/**
 * Dummy Source for testing purposes.
 */
class DummySource implements SourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dummy';
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $vacancy = new Vacancy();
        $vacancy->id = 5;
        $vacancy->title = 'Dummy vacancy';
        $vacancy->content = 'Dummy vacancy content';
        $vacancy->description = 'Dummy vacancy description';

        return $vacancy;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $vacancy1 = new Vacancy();
        $vacancy1->id = 1;
        $vacancy1->title = 'Vacancy 1';

        $vacancy2 = new Vacancy();
        $vacancy2->id = 2;
        $vacancy2->title = 'Vacancy 2';

        return array($vacancy1, $vacancy2);
    }
}
