<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $inputFilename;
    
    private $commandOutput;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have the input:
     */
    public function iHaveTheInput(PyStringNode $string)
    {
        $filename = tempnam(sys_get_temp_dir(), 'feature-test');
        file_put_contents($filename, $string->getRaw());
        
        $this->inputFilename = $filename;
    }

    /**
     * @When I run the script :script with input
     */
    public function iRunTheScript($script)
    {
        $command = sprintf('php advent.php -i %s %s', $this->inputFilename, $script);
        
        $output = [];
        exec($command, $output);
        $this->commandOutput = $output;
        unlink($this->inputFilename);
    }

    /**
     * @Then the output should be :output
     */
    public function theOutputShouldBe($expectedOutput)
    {
        $actualOutput = implode('', $this->commandOutput);
        if($expectedOutput !== implode('', $this->commandOutput)) {
            throw new Exception(sprintf('Output "%s" does not match expected "%s', $actualOutput, $expectedOutput));
        }
    }
}
