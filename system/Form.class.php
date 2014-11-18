<?php
class Form{
	
	private $form;
	private $form_body = '';
	
	function __construct($action = '', $method='post',  $class = null, $enctype = false, $id = null)
    {
        $this->form = '<form method="' . $method . '"';

        if(!empty($action)) $this->form .= ' action="' . $action . '"';
        if($id != null) $this->form .= ' id="' . $id  . '"';
        if($class != null) $this->form .= ' class="' . $class . '"';

        $enctype ? $this->form .= ' enctype="multipart/form-data">' : $this->form .= '>';
    }
	
	 function display(){ return $this->form . $this->form_body . '</form>'; }
	
	 function input($type, $name , $value = null, $class = 'form-control', $id = null){
		$this->form_body .= '<input type="'. $type .'" name ="'. $name .'" value="'. $value .'" class="'. $class .'" id="'. $id .'"/>';
	}
	
	 function textarea($name, $value = null, $class = 'form-control' , $id = null){
		$this->form_body .= '<textarea name="'. $name .'" value="'. $value .'" class="'. $class .'" id="'. $id .'"></textarea>';
	}
	 
	 function submit($value, $class = 'btn btn-primary', $name = null, $id = null){
	 	$this->form_body .= '<input type="submit" name ="'. $name .'" value="'. $value .'" class="'. $class .'" id="'. $id .'"/>';
	 }
	
	 function raw($content){
		$this->form_body .= $content;
	}
	
	 function select($name, $options, $class = null, $id = null){
		
		$this->form_body .= '<select name="'. $name .'" class="'. $class .'" id="'. $id .'">';
		foreach ($options as $key => $value) {
			$this->form_body .= '<option value="'. $key .'">'. $value .'</option>';
		}
		
		$this->form_body .= '</select>';
	}
	 
	 function label($label, $class = null){
	 	$this->form_body .= '<label class="'. $class .'">'. $label .'</label>';
	 }
	 
	 function br($number = 1){
	 	if($number > 1){
	 		for($i = 0 ; $i < $number; $i++){
	 			$this->form_body .= '</br>';
	 		}
	 	}else{
	 		$this->form_body .= '</br>';	
	 	}
	 	
	 }
	 
	 function title($title, $tag = 'h1'){
	 	$this->form_body .= '<'. $tag .'> '. $title .' </'. $tag .'>';
	 }
	
	
	
}


