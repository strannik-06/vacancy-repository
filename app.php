<?php
require_once __DIR__.'/vendor/autoload.php';

use Netwerven\VacancyRepository;
use Netwerven\Sources\DummySource;

$repository = new VacancyRepository(array(new DummySource()));

$id = 125;
$vacancy = $repository->find($id);
var_dump($vacancy);

$vacancies = $repository->findAll();
var_dump($vacancies);
