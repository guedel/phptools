<?php
    namespace guedel\GenForm\Test;

    require_once 'bootstrap.php';

    use \guedel\Microtest\UnitTest;
    use \guedel\Microtest\Assert;

    UnitTest::title('Test de la classe CodeWriter');
    $ut = new UnitTest();
    
    $ut->add_test('initialisation', function() {
        $writer = new \CodeWriter();
        Assert::is_false($writer === null);
    });

    $ut->add_test('initialisation 2', function() {
        $writer = new \CodeWriter('  ', 2);
        Assert::is_false($writer === null);
    });

    $ut->add_test('ecriture/flush', function() {
        $writer = new \CodeWriter(' ');
        $writer->write('abc');
        Assert::equal("abc\n", $writer->render());
    });
    
    $ut->add_test('indentation/desindentation', function() {
        $writer = new \CodeWriter(' ');
        $writer->indent();
        $writer->writeln('abc');
        $writer->unindent();
        $writer->write('cde');
        Assert::equal(" abc\ncde\n", $writer->render());
    });
    $ut->test_all();
