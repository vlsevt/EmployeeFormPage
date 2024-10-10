<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080/';

function indexToA() {
    navigateTo(getUrl());

    clickRelativeLinkWithText('a.html');

    assertCurrentUrl(getUrl('a/a.html'));
}

function aToE() {
    navigateTo(getUrl('a/a.html'));

    clickRelativeLinkWithText('e.html');

    assertCurrentUrl(getUrl('a/b/c/d/e/e.html'));
}

function eToD() {
    navigateTo(getUrl('a/b/c/d/e/e.html'));

    clickRelativeLinkWithText('d.html');

    assertCurrentUrl(getUrl('a/b/c/d/d.html'));
}

function dToB() {
    navigateTo(getUrl('a/b/c/d/d.html'));

    clickRelativeLinkWithText('b.html');

    assertCurrentUrl(getUrl('a/b/b.html'));
}

function emptyLink() {
    navigateTo(getUrl('a/b/c/d/e/f/f.html'));

    $linkText = 'shortest self';

    $href = getHrefFromLinkWithText($linkText);

    clickRelativeLinkWithText($linkText);

    assertCurrentUrl(getUrl('a/b/c/d/e/f/f.html'));

    assertThat(strlen($href), is(0),
        "'$href' is not the shortest link possible");
}

function directoryLink() {
    navigateTo(getUrl('a/b/c/d/e/f/f.html'));

    $linkText = 'shortest f/index.html';

    $href = getHrefFromLinkWithText($linkText);

    clickRelativeLinkWithText($linkText);

    assertCurrentUrl(getUrl('a/b/c/d/e/f/'));

    assertThat(strlen($href), is(1),
        "'$href' is not the shortest link possible");
}

function logoImageSrcIsCorrect() {

    navigateTo(getUrl('a/b/c/d/e/f/f.html'));

    $src = getAttributeFromElementWithId('logo', 'src');

    assertThat(isRelativeLink($src), is(true),
        "'$src' is not a relative link");

    assertImageExists(getCurrentUrlDir() . $src);
}

#Helpers

function getUrl(string $relativeUrl = ''): string {
    $baseUrl = removeLastSlash(BASE_URL);

    return "$baseUrl/ex2/nav/$relativeUrl";
}

function isRelativeLink($href): bool {
    return !preg_match("/:/", $href) && !preg_match("/^\//", $href);
}

function clickRelativeLinkWithText($linkText): void {
    $href = getHrefFromLinkWithText($linkText);

    if (!isRelativeLink($href)) {
        throw new RuntimeException("$href is not a relative link");
    }

    clickLinkWithText($linkText);
}

setBaseUrl(BASE_URL);

stf\runTests(getPassFailReporter(7));
