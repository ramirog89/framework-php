<?php
namespace Core;

class Mail
{

    public function __construct()
    {}

	protected function _validate($key, $value) {
		$regexEmail = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
		if ($key == "email") {
			return preg_match($regexEmail, $value);
		} else if ($key == "tel") {
			if (strlen($value) == 0)
				return true;
			
			return is_numeric($value);
		} else {
			return (strlen($value) > 0);
		}
	}
	
    public function send()
    {
        $content = array();
        $response = array("response" => "fail", "fields" => array());
        $send = true;
        
        foreach ($_POST as $key => $value) {
            $v = validate($key, $value);
            $response["fields"][$key] = $v;
            $content[$key] = trim($value);
            if ($v == false) {
                $send = false;
            }
        }
        
        if ($send) {			
            $to = "jesushernan3@gmail.com";
            $subject = "Mail enviado desde la pagina";

            $body =<<<HTML
    {$content["name"]} te envio un mail, su numero de telefono es : {$content["tel"]}, <br >
    su email es : {$content["email"]} <br >
    <h3>Mensaje:</h3>
    <p>{$content["userMessage"]}</p>
HTML;

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            if (mail($to, $subject, $body, $headers)) {
                $response["response"] = "success";
            }
        }
    }
	
}
?>
