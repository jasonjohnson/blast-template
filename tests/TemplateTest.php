<?php

require '../src/template.php';

class TemplateTest extends PHPUnit_Framework_TestCase
{
	var $template;
	
	protected function setUp()
	{
		$this->template = new Template();
	}
	
	function testFileLoader()
	{
		$file_name = 'examples/001.html';
		
		$this->template->load($file_name);
		
		$this->assertStringEqualsFile($file_name, $this->template->buffer);
	}
	
	function testSingleVariableReplacement()
	{
		$file_name = 'examples/002.html';
		$file_name_output = 'examples/002-output.html';
		
		$this->template->load($file_name);
		$this->template->assign('name', 'Jason Johnson');
		$this->template->render();
		
		$this->assertStringEqualsFile($file_name_output, $this->template->buffer);
	}
	
	function testMultipleVariableReplacement()
	{
		$file_name = 'examples/003.html';
		$file_name_output ='examples/003-output.html';
		
		$this->template->load($file_name);
		$this->template->assign('name', 'Jason Johnson');
		$this->template->assign('address', '123 Main Street');
		$this->template->assign('city', 'Dallas');
		$this->template->assign('state', 'Texas');
		$this->template->assign('postal_code', '12345');
		$this->template->render();
		
		$this->assertStringEqualsFile($file_name_output, $this->template->buffer);
	}
	
	function testBlockAndSingleVariableReplacement()
	{
		$file_name = 'examples/004.html';
		$file_name_output = 'examples/004-output.html';
		
		$names = array(
			array('name' => 'Philip J. Fry'),
			array('name' => 'Bender'),
			array('name' => 'Turanga Leela'),
			array('name' => 'Hermes Conrad'),
			array('name' => 'Amy Wong'),
			array('name' => 'Professor Hubert J. Farnsworth'),
			array('name' => 'Dr. John Zoidberg')
		);
		
		$this->template->load($file_name);
		$this->template->assign('names', $names);
		$this->template->render();
		
		$this->assertStringEqualsFile($file_name_output, $this->template->buffer);
	}
	
	function testBlockAndMultipleVariableReplacement()
	{
		$file_name = 'examples/005.html';
		$file_name_output = 'examples/005-output.html';
		
		$contacts = array(
			array('name' => 'Bob', 'email' => 'bob@example.com'),
			array('name' => 'John', 'email' => 'john@example.com'),
		);
		
		$this->template->load($file_name);
		$this->template->assign('contacts', $contacts);
		$this->template->render();
		
		$this->assertStringEqualsFile($file_name_output, $this->template->buffer);
	}
}

?>