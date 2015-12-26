<?php

namespace Netwerven\Tests;

use Netwerven\Model\Vacancy;
use Netwerven\VacancyRepository;

/**
 * Vacancy Repository Test.
 */
class VacancyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $source1;
    private $source2;
    private $vacancy1;
    private $vacancy2;

    /**
     * Set up mocks and fixtures.
     */
    public function setUp()
    {
        $this->source1 = $this->getMockBuilder('Netwerven\Sources\SourceInterface')
            ->setMethods(array('findAll', 'find', 'getName'))
            ->getMock();
        $this->source2 = clone $this->source1;

        $this->vacancy1 = new Vacancy();
        $this->vacancy1->id = 1;
        $this->vacancy1->title = 'Vacancy 1';

        $this->vacancy2 = new Vacancy();
        $this->vacancy2->id = 2;
        $this->vacancy2->title = 'Vacancy 2';

        $this->source1->expects($this->any())->method('getName')->will($this->returnValue('source1'));
        $this->source1->expects($this->any())->method('find')->with(1)->will($this->returnValue($this->vacancy1));
        $this->source1->expects($this->any())->method('findAll')->will($this->returnValue(array($this->vacancy1)));

        $this->source2->expects($this->any())->method('getName')->will($this->returnValue('source2'));
        $this->source2->expects($this->any())->method('find')->with(2)->will($this->returnValue($this->vacancy2));
        $this->source2->expects($this->any())->method('findAll')
            ->will($this->returnValue(array($this->vacancy1, $this->vacancy2)));
    }

    /**
     * Test finding one vacancy by id.
     */
    public function testFind()
    {
        $repository = new VacancyRepository(array($this->source1, $this->source2));

        $vacancyId = 1;
        $this->assertEquals($this->vacancy1, $repository->find($vacancyId));
    }

    /**
     * Test finding one vacancy by id in certain source.
     */
    public function testFindInSource()
    {
        $repository = new VacancyRepository(array($this->source2));

        $vacancyId = 2;
        $sourceName = 'source2';
        $this->assertEquals($this->vacancy2, $repository->findInSource($vacancyId, $sourceName));
    }

    /**
     * Test finding vacancies from all sources. Sources are added and removed dynamically.
     * One vacancy can be taken only once.
     */
    public function testFindAll()
    {
        $repository = new VacancyRepository();
        $repository->addSource($this->source1);
        $repository->addSource($this->source2);

        $this->assertEquals(
            array(
                1 => $this->vacancy1,
                2 => $this->vacancy2,
            ),
            $repository->findAll()
        );

        $repository->removeSource($this->source2);

        $this->assertEquals(
            array(
                1 => $this->vacancy1,
            ),
            $repository->findAll()
        );

        $repository->removeSource($this->source1);

        $this->assertEquals(
            array(),
            $repository->findAll()
        );
    }
}
