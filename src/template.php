<?php

class Template
{
	var $buffer;
	var $assignments;
	
	function Template()
	{
		$this->buffer = "";
		$this->assignments = array();
	}
	
	function load($file_name)
	{
		if(!file_exists($file_name))
			die("Could not find template: {$file_name}");
		
		$fh = fopen($file_name, 'r');
		
		while(($buffer = fgets($fh)) !== FALSE)
			$this->buffer .= $buffer;
		
		fclose($fh);
	}
	
	function assign($key, $value = null)
	{
		$this->assignments[$key] = $value;
	}
	
	function render_value($key, $value = null, $buffer = '')
	{
		if(!$buffer)
			$buffer = $this->buffer;
		
		return preg_replace("/\{{$key}\}/", $value, $buffer);
	}
	
	function render_block($key, $value = array(), $buffer = '')
	{
		if(!$buffer)
			$buffer = $this->buffer;
		
		$matches = array();
		
		$block_exp = "/\{block:{$key}\}(.*?)\{\/block:{$key}\}/s";
		$block_body = "";
		$block_result = "";
		
		preg_match_all($block_exp, $buffer, $matches);
		
		$block_body = $matches[1][0];
		
		for($i = 0; $i < count($value); $i++) {
			$r = $block_body;
			
			foreach($value[$i] as $k => $v) {
				if(!is_array($v))
					continue;
				
				$r = $this->render_block($k, $v, $block_body);
			}
			
			foreach($value[$i] as $k => $v) {
				if(is_array($v))
					continue;
				
				$r = $this->render_value($k, $v, $r);
			}
			
			$block_result .= $r;
		}
		
		$buffer = preg_replace($block_exp, $block_result, $buffer);
		
		return $buffer;
	}
	
	function render()
	{
		foreach($this->assignments as $key => $value) {
			if(!is_array($value))
				continue;
			$this->buffer = $this->render_block($key, $value);
		}
		
		foreach($this->assignments as $key => $value) {
			if(is_array($value))
				continue;
			$this->buffer = $this->render_value($key, $value);
		}
	}
}

?>