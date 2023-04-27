<?php
namespace Src\Controller;

use Src\TableGateways\DevicesGateway;

class DevicesController {

    private $db;
    private $requestMethod;

    private $devicesGateway;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->devicesGateway = new DevicesGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getAllDevices();
                break;
            case 'POST':
                $response = $this->createDeviceFromRequest();
                break;
            case 'PUT':
                $response = $this->updateDeviceFromRequest();
                break;
            case 'DELETE':
                $response = $this->deleteDevice();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllDevices()
    {
        $result = $this->devicesGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getDevice($id)
    {
        $result = $this->devicesGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createDeviceFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateDevice($input)) {
            return $this->unprocessableEntityResponse();
        }
        $res = $this->devicesGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $res;
        return $response;
    }

    private function updateDeviceFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $id = $input['id'];
        $result = $this->devicesGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        if (! $this->validateDevice($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->devicesGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = "Successfully updated";
        return $response;
    }

    private function deleteDevice()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $id = $input['id'];
        $result = $this->devicesGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->devicesGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = "Successfully deleted";
        return $response;
    }

    private function validateDevice($input)
    {
        if (! isset($input['model'])) {
            return false;
        }
        if (! isset($input['brand'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    public function notFoundResponse()
    {
        
        if(!isset($response)){
            $response = array();
        }
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}