<?php
    namespace guedel\GenForm\Test;

    require_once 'bootstrap.php';

    use \guedel\Microtest\UnitTest;
    use \guedel\Microtest\Assert;

    UnitTest::title('Test de la classe CodeWriterEx');
    $ut = new UnitTest();

    $ut->add_test('initialisation', function() {
        $writer = new \CodeWriterEx();
        Assert::is_false($writer === null);
    });

    $ut->add_test('initialisation 2', function() {
        $writer = new \CodeWriterEx('  ', 2);
        Assert::is_false($writer === null);
    });

    $ut->add_test('ecriture/flush', function() {
        $writer = new \CodeWriterEx(' ');
        $writer->write('abc');
        Assert::equal("abc", $writer->render());
    });

    $ut->add_test('indentation/desindentation', function() {
        $writer = new \CodeWriterEx(' ');
        $writer->indent();
        $writer->writeln('abc');
        $writer->unindent();
        $writer->write('cde');
        Assert::equal(" abc\ncde", $writer->render());
    });

    $ut->add_test('chargement', function() {
        $text = "abc\n\tcde\n";
        $writer = new \CodeWriterEx();
        $writer->fromString($text);
        Assert::equal($text, $writer->render());
    });

    $ut->test_all();
