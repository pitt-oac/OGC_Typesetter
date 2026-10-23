<?php

class ServerSetup implements \PHPUnit\Framework\TestListener{

	use \PHPUnit\Framework\TestListenerDefaultImplementation;

	public function startTestSuite(\PHPUnit\Framework\TestSuite $suite): void{
		echo pre('start test suite');
	}

	public function endTestSuite(\PHPUnit\Framework\TestSuite $suite): void{
		echo pre('end test suite');
	}
}
