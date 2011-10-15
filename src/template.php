<?php

class Template
{
	var $buffer;
	
	function load($file_name)
	{
		$fh = fopen($file_name, 'r');
		
		while(($buffer = fgets($fh)) !== FALSE)
			$this->buffer .= $buffer;
		
		fclose($fh);
	}
	
	function assign($key, $value = '')
	{
		$this->buffer = str_replace("{{$key}}", $value, $this->buffer);
	}
}

?>