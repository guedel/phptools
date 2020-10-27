<?php


class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function frontpageWorks(AcceptanceTester $I)
    {
      $I->amGoingTo('Afficher la page d\'accueil');
      $I->amOnPage('/');
      $I->see('Authentification');
    }

    public function firstLoginSuccess(AcceptanceTester $I)
    {
      $I->amGoingTo('Se connecter à un serveur MySql');
      $I->amOnPage('/');
      $I->selectOption('driver', 'mysql');
      $I->fillField('hote', 'localhost');
      $I->fillField('user_name', 'root');
      $I->click('Suivant');
      $I->see('Sélection de la base de données');
    }
}
