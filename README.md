VacancyRepository - small example of architecture where all vacancy data will be requested from a centralized point.

The VacancyRepository is responsible to talk to the different data sources, and for that reason it needs to be able to talk to a new data source with minimal additions to the code. It also needs to be able to select which data sources is going to communicate with (in other words, the  data sources should be able to be added/removed dynamically).

<h3>Requirements:</h3>
PHP 5.4 or later

<h3>Installation:</h3>
<code>composer install</code>

<h3>Example usage:</h3>
<code>php app.php</code>

<h3>To run tests:</h3>
<code>phpunit</code>
