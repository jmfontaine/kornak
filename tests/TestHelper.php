<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Framework/IncompleteTestError.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Runner/Version.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Filter.php';

/*
 * Set error reporting to the level to which Kornak code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Determine the root, library, and tests directories of Kornak
 * distribution.
 */
$rootPath    = dirname(dirname(__FILE__));
$libraryPath = $rootPath . DIRECTORY_SEPARATOR . 'library';
$testsPath   = $rootPath . DIRECTORY_SEPARATOR . 'tests';

/*
 * Prepend the Kornak library/ and tests/ directories to the
 * include_path. 
 */
$path = array(
    $libraryPath,
    $testsPath,
    get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $path));

/*
 * Enable autoloading
 */
require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if (is_readable($testsPath . DIRECTORY_SEPARATOR . 'TestConfiguration.php')) {
    require_once $testsPath . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
} else {
    require_once $testsPath . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}

/*
 * Add Kornak library/ directory to the PHPUnit code coverage
 * whitelist. This has the effect that only production code source files appear
 * in the code coverage report and that all production code source files, even
 * those that are not covered by a test yet, are processed.
 */
if (TESTS_GENERATE_REPORT === true &&
    version_compare(PHPUnit_Runner_Version::id(), '3.1.6', '>=')) {
    PHPUnit_Util_Filter::addDirectoryToWhitelist($libraryPath);
}

/*
 * Unset global variables that are no longer needed.
 */
unset($rootPath, $libraryPath, $testsPath, $path);
