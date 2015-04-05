<?php

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Validator\Assert\AtLeastOneInitialStateAssert;

class AtLeastOneInitialStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Michcald\Fsm\Exception\Validator\Assert\MissingInitialStateException
     * @expectedExceptionMessageRegExp #FSM <.*> must have an initial state#
     */
    public function testNoInitialState()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1'),
            new State('s2'),
            new State('s1'),
        ));

        $assert = new AtLeastOneInitialStateAssert();
        $assert->validate($fsm);
    }

    public function testMultipleInitialStates()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', true),
            new State('s2'),
            new State('s1', true),
        ));

        $assert = new AtLeastOneInitialStateAssert();
        $assert->validate($fsm);
    }

    public function testGoodAssert()
    {
        $fsm = new Fsm('fsm');
        $fsm->setStates(array(
            new State('s1', true),
            new State('s2'),
            new State('s3'),
        ));

        $assert = new AtLeastOneInitialStateAssert();
        $assert->validate($fsm);
    }
}
