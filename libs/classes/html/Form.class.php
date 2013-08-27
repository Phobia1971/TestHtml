<?PHP

/**
*  HTML Form Class 
*  To create a form on the fly
*  eg: 
*  $form = new Form;
*  $form->create('do.php', 'register', Null, "span_border", "POST")
*         ->input("text", "first_name",Null,"enter your firstname")
*         ->label("Firstname:")
*         ->input("text", "last_name",Null,"enter your lastname")
*         ->label("Lastname:")
*         ->input("br")
*         ->input("submit", "submit","Send")
*         ->label(" ");
*
*   @author Phobia <morphius.inc@upcmail.nl>
*   
*/
class Form
{
    private $_nl            = PHP_EOL; // newline to make soucecode look pretty
    private $_form          = array(); // class variable to hold the form data
    private $_inputs        = array(); // class variable to hold the input data
    private $_current_input = Null;    // to keep track of the last added input 
    private $_break_count   = 0;       // to number the br en hr added as inputs
    private $_form_name     = Null;    // name of the form for the wrap div class of the input and label

    public function create($action, $name, $id = Null, $class = Null, $method = "POST", $upload_form = False)
    {
        $encrypt = ($upload_form)?'enctype="multipart/form-data"':Null;
        $post    = (strtolower($method) != "post" || strtolower($method) != "get")?'method="'.strtoupper($method).'"':'method="POST"';
        $id      = ($id != Null)?' id="'.$id.'"':Null;
        $class   = ($class != Null)?' class="'.$class.'"':Null;
        $this->_form["comment"] = $this->_nl."<!--- Generated Form --->".$this->_nl;
        $this->_form["open"]    = '<form' . $id . $class . ' action="'.$action.'" '.$post.' '.$encrypt.' >'.$this->_nl;
        $this->_form["close"]   = "</form>".$this->_nl;
        return $this;
    }

    public function input($type, $name = Null, $value = Null, $placeholder = Null )
    {
        if(strtolower($type) == "br" || strtolower($type) == "hr") 
        {
            $breakname = "break".$this->_break_count++;
            $this->_inputs[$breakname]["input"] = "<".strtolower($type)." />".$this->_nl;
            $this->_inputs[$breakname]["type"]  = $type;
            $this->_current_input = Null;
        }
        else 
        {
            if($name == Null) throw new Exception("ERROR: no $name $value provided in ".__METHOD__, 1);            
            $this->_inputs[$name]["input"] = '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" />';
            $this->_inputs[$name]["type"]  = $type;
            $this->_current_input = $name;
        }
        return $this;
    }

    public function textarea($name, $value = Null, $placeholder = Null, $rows = 4, $collums = 10)
    {

        $this->inputs[$name]["input"] = '<textarea name="'.$name.'" id="'.$name.'" placeholder="'.$placeholder.'" rows="'.$rows.'" cols="'.$collums.'">'
                                        .$this->_nl . $value . $this->_nl
                                        .'</textarea>' . $this->_nl;
        $this->_inputs[$name]["type"]  = "textarea";
        $this->_current_input = $name;
    }

    public function label($label_text, $on_own_line = False)
    {
        if($this->_current_input != Null)
        {
            $this->_inputs[$this->_current_input]["label"] = '<label for="'.$this->_current_input.'">'.$label_text.'</label>'.$this->_nl;
            if($on_own_line) $this->_inputs[$this->_current_input]["label"] .= "<br />".$this->_nl;
            $this->_current_input = Null;
        }
        return $this;
    }

public function build()
{   
    $display  = $this->_form["comment"];
    $display .= $this->_form["open"];
    foreach ($this->_inputs as $input)
    {
        $display .= '<div class="form_'.$this->_form_name.'_'.$input["type"].'">';
       if(isset($input["label"])) $display .= $input["label"];
       $display .= $input["input"];
       $display .= "</div>".$this->_nl;
    }
    $display .= $this->_form["close"];

    return $display;
}

}// End of Class