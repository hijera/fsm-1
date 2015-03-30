<?php

require __DIR__ . '/../vendor/autoload.php';

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\FsmState;
use Michcald\Fsm\Model\FsmTransaction;
use Michcald\Fsm\Validator\FsmValidator;

// defining all the states
$s1 = new FsmState('s1', FsmState::TYPE_START);
$s2 = new FsmState('s2', FsmState::TYPE_NORMAL);
$s3 = new FsmState('s3');
$s4 = new FsmState('s4', FsmState::TYPE_END);

// defining all the transactions
$t1 = new FsmTransaction('t1', 's1', 's2');
$t2 = new FsmTransaction('t2', 's1', 's3');
$t3 = new FsmTransaction('t3', 's3', 's1');
$t4 = new FsmTransaction('t4', 's2', 's4');

// initializing the FSM
$fsm = new Fsm('fsm1');

$fsm->addState($s1);
$fsm->addState($s2);
$fsm->addState($s3);
$fsm->addState($s4);

$fsm->addTransaction($t1);
$fsm->addTransaction($t2);
$fsm->addTransaction($t3);
$fsm->addTransaction($t4);

// validating the FSM
$validator = new FsmValidator();

$isValid = $validator->validate($fsm, false);

if ($isValid) {
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} else {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}

// or we can use exceptions

// adding an invalid transaction
$fsm->addTransaction(
    new FsmTransaction('t1', 's1', 's2')
);

try {
    $validator->validate($fsm);
    printf('FSM <%s> is valid%s', $fsm->getName(), PHP_EOL);
} catch (\Exception $e) {
    printf('FSM <%s> is NOT valid%s', $fsm->getName(), PHP_EOL);
}