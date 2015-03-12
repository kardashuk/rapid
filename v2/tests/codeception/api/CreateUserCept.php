<?php 
$I = new ApiTester($scenario);
$I->wantTo('create a user via API');
$I->haveHttpHeader('Accept', 'application/json');

$I->sendPOST('users', [
    'first_name' => 'Test1',
    'last_name'=>'Test2',
    'email' => 'test_'.time().'@codeception.com',
    'password'=>'xxxzzz',
    'phone'=>'(111) 111-11-11'
]);

$I->seeResponseCodeIs(201);


$I->seeResponseIsJson();
$I->seeResponseContains('"password":"xxxzzz"');