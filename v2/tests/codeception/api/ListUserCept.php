<?php 
$I = new ApiTester($scenario);
$I->wantTo('get a list of users via API');
$I->haveHttpHeader('Accept', 'application/json');
$I->sendGET('users');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"email":"kardashuk@gmail.com"');

