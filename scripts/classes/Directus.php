<?php

class Directus extends Projectfunctions
{
    private $directus_instance = '';

    // public function __construct($param)
    // {
    //     $this->param = $param;
    // }
    
    public function setInstance($instance)
    {
        try {
            $this->directus_instance = $instance;
            
            return true;
        } catch (Exception $e) {

            // update error log table here
            return false;
        }
	}
	
	public function getInstance()
	{
		return $this->directus_instance;
	}
    
    // @OPTIONS is array with optional key => value pairs
    // Refer to directus Docs for more Info on key => value pairs
    // https://api.getdirectus.com/1.1/#Get_Items

    public function createCustomRequest($table, $options)
    {
        $database_results = $this->directus_instance->getItems($table, $options);

        // $database_results = $database_results->getData();

        if (count($database_results) < 1) {
            return [
                "status"=> false,
                "result"=> $database_results
            ];
        } else {
            return [
                "status"=> true,
                "result"=> $database_results[0],
            ];
        }
    }

    public function updateEntryData($table, $entry, $options)
    {
        try{
            $update = $this->directus_instance->updateItem($table, $entry['id'], $options);

            return [
                "status" => true,
                "result" => $update
            ];
        }catch(Exception $e){
             return [
                "status"=> false
            ];

        }
    }

    public function addEntry($table, $data)
    {
        $response = new Response();

        try {
            $c = $this->directus_instance->createItem($table, $data);

            $custom_response = [
                "message"=> "entry added successfully",
                "create_response"=> $c
            ];

            $response->editSuccessResponseInfo($custom_response);

            return $response->success_response();
        } catch (Exception $e) {
            // update error log table here
            $custom_response = [
                "directus_error"=>$e
            ];

            return $response->error_response();
        }
    }

    
    public function getAllActiveItems($table, $options = ["status"=>1])
    {
        $active_items = $this->directus_instance->getItems($table, $options);

        // check the result to see if it got anything
        
        // if (count($database_results) < 1) {
        // 	return [
        // 		"status"=> false,
        // 		"result"=> $database_results
        // 	];
        // }else {
        // 	return [
        // 		"status"=> true,
        // 		"result"=> $database_results[0],
        // 	];
        // }

        return $active_items->getData();
    }
    
    public function getItemByID($table, $id)
    {
        $response = new Response();

        try {
            $item = $this->directus_instance->getItem($table, $id);

            $custom_response = [
                "item" => $item
            ];

            $response->editSuccessResponseInfo($custom_response);

            return $response->success_response();
        } catch (Exception $e) {
            return $response->error_response();
        }
    }
    
    public function entryExists($table, $options)
    {
        $response = new Response();

        try {
            $item = $this->directus_instance->getItems($table, $options);

            if (count($item) < 1) {
                return [
                    "status"=> false,
                    "result"=> $item
                ];
            } else {
                return [
                    "status"=> true,
                    "result"=> $item[0],
                ];
            }
        } catch (Exception $e) {
			return [
				"status"=> false,
				"error"=>[
					"message"=> 'error checking if user exists'
				],
            ];

			// $response->editErrorResponseInfo($custom_response);

            // return $response->error_response();

            
		}
		
	// return self::getInstance();
    }
}
