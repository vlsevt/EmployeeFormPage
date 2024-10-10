<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const PROJECT_DIRECTORY = '';

function canSaveNewPosts() {

    chdir(getProjectDirectory() . '/ex4/posts');

    require_once 'post-functions.php';

    $title = getRandomString(5);
    $text = getRandomString(10);

    $post = new Post(null, $title, $text);

    savePost($post);

    assertContains(getAllPosts(), $post);
}

function canDeletePosts() {

    chdir(getProjectDirectory() . '/ex4/posts');

    require_once 'post-functions.php';

    $title = getRandomString(10);

    $post = new Post(null, $title, '');

    $id = savePost($post);

    deletePostById($id);

    assertDoesNotContainPostWithTitle(getAllPosts(), $title);
}

function canUpdatePosts() {

    chdir(getProjectDirectory() . '/ex4/posts');

    require_once 'post-functions.php';

    $oldTitle = getRandomString(10);
    $newTitle = getRandomString(10);

    $oldPost = new Post(null, $oldTitle, '');

    $id = savePost($oldPost);

    assertContains(getAllPosts(), $oldPost);

    $newPost = new Post($id, $newTitle, '');

    savePost($newPost);

    assertContains(getAllPosts(), $newPost);
    assertDoesNotContainPostWithTitle(getAllPosts(), $oldTitle);
}

stf\runTests(getPassFailReporter(3));
