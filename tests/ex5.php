<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const PROJECT_DIRECTORY = '';

function distributesNumbersToSets() {

    chdir(getProjectDirectory() . '/ex5');

    require_once 'distribute.php';

    $sets = distributeToSets([4, 1, 6, 7, 2, 1, 6, 9, 9, 1]);

    assertThat(count($sets), is(6));

    assertThat($sets[4], contains([4]));
    assertThat($sets[1], contains([1, 1, 1]));
    assertThat($sets[2], contains([2]));
    assertThat($sets[6], contains([6, 6]));
    assertThat($sets[7], contains([7]));
    assertThat($sets[9], contains([9, 9]));
}

function findsContactsWithPhones() {

    chdir(getProjectDirectory() . '/ex5/phones');

    require_once 'phones.php';

    $contacts = getContacts();

    assertThat(count($contacts), is(3));

    assertThat($contacts[0]->getName(), is('Alice'));
    assertThat($contacts[0]->getPhones(), containsInAnyOrder(['123', '555']));

    assertThat($contacts[1]->getName(), is('Bob'));
    assertThat($contacts[1]->getPhones(), containsInAnyOrder(['456', '789']));

    assertThat($contacts[2]->getName(), is('Carol'));
    assertThat($contacts[2]->getPhones(), contains([]));
}

function menuHasTwoRootItems() {

    chdir(getProjectDirectory() . '/ex5/menu');

    require_once 'menu.php';

    $menu = getMenu();

    assertThat(count($menu), is(2));

    assertThat($menu[0]->name, is('Item 1'));
    assertThat($menu[1]->name, is('Item 2'));
}

function firstMenuItemHasCorrectSubStructure() {

    chdir(getProjectDirectory() . '/ex5/menu');

    require_once 'menu.php';

    $menu = getMenu();

    assertThat(count($menu[0]->subItems), is(2));

    assertThat($menu[0]->subItems[0]->name, is('Item 1.1'));
    assertThat($menu[0]->subItems[1]->name, is('Item 1.2'));
}

function secondMenuItemHasCorrectSubStructure() {

    chdir(getProjectDirectory() . '/ex5/menu');

    require_once 'menu.php';

    $menu = getMenu();

    assertThat(count($menu[1]->subItems), is(1));

    assertThat($menu[1]->subItems[0]->name, is('Item 2.1'));
    assertThat($menu[1]->subItems[0]->subItems[0]->name, is('Item 2.1.1'));
}

stf\runTests(getPassFailReporter(5));
