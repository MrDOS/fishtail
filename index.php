<?php

require_once('AuthRepository.php');
require_once('FishingSessionRepository.php');
require_once('FishRepository.php');

require_once('FishException.php');
require_once('FishingSession.php');
require_once('Fish.php');

require_once('config.php');

function finish($error = null)
{
    if (!$error)
        die(json_encode(['success' => true]));
    die(json_encode(['success' => false, 'error' => $error]));
}

header('Content-Type: application/json');

try
{
    $db = new \PDO(DB_TYPE . ':host=' . DB_HOST . ';port=' . DB_PORT
        . ';dbname=' . DB_NAME . ';user=' . DB_USER . ';password=' . DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (\PDOException $e)
{
    finish('Failed to establish a database connection.');
}

if (!isset($_REQUEST['secret']))
    finish('A secret must be provided.');

if (!isset($_POST['sessions']))
    finish('Session data must be provided.');

$auth = new \ca\acadiau\cs\comp4583\fishtail\data\persistence\AuthRepository($db);
$fishRepository = new \ca\acadiau\cs\comp4583\fishtail\data\persistence\FishRepository($db);
$sessionRepository = new \ca\acadiau\cs\comp4583\fishtail\data\persistence\FishingSessionRepository($db, $fishRepository);

if (!$auth->authenticate($_REQUEST['secret']))
    finish('The given secret is invalid.');

try
{
    foreach (json_decode($_POST['sessions']) as $session)
        $sessionRepository->store(new \ca\acadiau\cs\comp4583\fishtail\data\FishingSession($session));
}
catch (\ca\acadiau\cs\comp4583\fishtail\data\FishException $e)
{
    finish('An error occurred parsing the session data.');
}
catch (\PDOException $e)
{
    finish('An error occurred submitting the data to the database.');
}
catch (\Exception $e)
{
    finish('An unspecified error occurred.');
}

finish();