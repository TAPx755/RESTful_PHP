<?php

abstract class RESTController
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';

    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';

    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';

    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();

    /**
     * Property: file
     * Stores the input of the PUT request
     */
    protected $file = Null;


    /**
     * Property: token
     * Stores the token sent by the user via the Authorization: Bearer Header
     */
    protected $token = '';


    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct()
    {
        header("Access-Control-Allow-Origin: https://bock-martin.at");
        header("Access-Control-Allow-Methods: GET, DELETE, UPDATE, PUT, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization");
        header("Content-Type: application/json");

        $this->args = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : [];
        if (sizeof($this->args) == 0) {
            throw new Exception('Invalid request');
        }

        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        //Get's the token from the Authorization Header
        if(isset(apache_request_headers()['Authorization']))
        {
            $this->token = apache_request_headers()['Authorization'];
            $this->token = str_replace("Bearer", "", $this->token);
            $this->token = trim($this->token);
        }

        switch ($this->method) {
            case 'DELETE':
            case 'POST':
                $this->request = $this->_cleanInputs($_POST);
                $this->file = json_decode(file_get_contents("php://input"), true);
            break;
            case 'GET':
                $this->request = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->_cleanInputs($_GET);
                $this->file = json_decode(file_get_contents("php://input"), true);
                //$this->file = file_get_contents("php://input");
                break;
            default:
                $this->response('Invalid Method', 405);
                break;
        }
    }

    public abstract function handleRequest();

    protected function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        echo json_encode($data);
    }

    private function _cleanInputs($data)
    {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}
?>