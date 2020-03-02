<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//composer require elasticsearch/elasticsearch

if (!defined('BASEPATH'))
    die('No direct script access allowed');
use Elasticsearch\ClientBuilder;
class Elasticsearch {

    public function __construct() {
        $this->client = $this->getClient();
        $this->CI = & get_instance();
        //$this->CI->load->config('elasticsearch_mapping', TRUE);
        //$this->CI->load->model('cron_model');
    }

    function create_index($index, $type, $params) {
        $index_name = $this->get_index_name($index);
        if (false === $index_name) {
            $params['index'] = $index . '_v1';
            $response = $this->client->indices()->create($params);
            $aliases['body'] = array(
                'actions' => array(
                    array(
                        'add' => array(
                            'index' => $params['index'],
                            'alias' => $index
                        )
                    )
                )
            );
            $this->client->indices()->updateAliases($aliases);
        } else {
            $params['type'] = $type;
            $this->client->indices()->putMapping($params);
        }
        return;
    }

    function get_index_name($index_name) {
        if (!$this->client->indices()->exists(['index' => $index_name])) {
            return false;
        }

        $mappings = $this->client->indices()->getMapping(['index' => $index_name]);
        $keys = array_keys($mappings);
        return reset($keys);
    }

    function get_lastId($index, $type, $sortby, $id) {
        $param = array(
            'index' => $index,
            'type' => $type,
            'sort' => $sortby,
            'size' => '1',
            
        );
        $response = $this->client->search($param);
        if ($response['hits']['total'] > 0)
            if (isset($response['hits']['hits'][0]['_source'][$type]))
                return $response['hits']['hits'][0]['_source'][$type][$id] + 1;
            else
                return $response['hits']['hits'][0]['_source'][$id] + 1;
        else
            return 1;
    }

    function get_count($index, $type) {
        $param = array(
            'index' => $index,
            'type' => $type,
        );
        $response = $this->client->search($param);
        return $response['hits']['total'];
    }

    function get_allRecord($index, $type, $options = "", $sortby = "") {
        $param = array(
            'index' => $index,
            'type' => $type,
        );
        if (!empty($options)) {
            $param['from'] = $options['start'];
            $param['size'] = $options['length'];
            $param['sort'] = @$sortby;
        }
        $response = $this->client->search($param);
        if ($response['hits']['total'] > 0)
            return $response['hits']['hits'];
        else
            return 0;
    }

    function get_recordByCondition($index, $type, $term, $index_value, $all = "") {
        $param = array(
            'index' => $index,
            'type' => $type,
        );
        $param['body']['query']['filtered']['filter']['bool']['must'][] = ['term' => [$term => $index_value]];
        $response = $this->client->search($param);
        if ($response['hits']['total'] > 0) {
            if ($all != "" && $all == "all") {
                return $response['hits'];
            } else {
                return $response['hits']['hits'][0]['_source'];
            }
        } else
            return 0;
    }

    function delete_Record($index, $type, $id) {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id
        ];
        if ($response = $this->client->delete($params))
            return true;
        else
            return false;
    }

    function get_checkExist($index, $type, $term, $value, $exist_field, $id) {
        $error_msg = array(
            "status" => "error",
            "data" => "Oops! Error. " . $exist_field . " already exist!!!"
        );
        $param = array(
            'index' => $index,
            'type' => $type,
        );
        if ($id != "") {
            $param['body']['query']['filtered']['filter']['bool']['must_not'][] = ['term' => ["_id" => $id]];
            $param['body']['query']['filtered']['filter']['bool']['must'][] = ['term' => [$term => $value]];
        } else
            $param['body']['query']['filtered']['filter']['bool']['must'][] = ['term' => [$term => $value]];

        $response = $this->client->search($param);
        if ($response['hits']['total'] > 0)
            return $error_msg;
        else
            return 0;
    }

    function save($param) {
        if ($response = $this->client->index($param))
            return TRUE;
        else
            return FALSE;
    }

    function update($param) {
        if ($response = $this->client->update($param))
            return TRUE;
        else
            return FALSE;
    }

    
    // Get client based on Environment
    public function getClient() {
        if (ENVIRONMENT == 'production'){
            $hosts = [[  'host' => ELASTIC_SEARCH_HOST,
                     'port' => 443,
                     'scheme' => 'https' ]];
            $clientBuilder = ClientBuilder::create();   // Instantiate a new ClientBuilder
            $clientBuilder->setHosts($hosts);           // Set the hosts
            $client = $clientBuilder->build();          // Build the client object
            return $client;
        }else{
            return Elasticsearch\ClientBuilder::create()->build();
        }
    }

    public function get_column_name($index_name, $indexing_type) {
        $params = [
            'index' => $index_name,
            'type' => $indexing_type
        ];
        $response = $this->client->indices()->getMapping($params);
        return $response[$index_name . '_v1']['mappings'][$indexing_type]['properties'];
    }

    public function is_index_exists($index) {
        if (!$this->client->indices()->exists(['index' => $index])) {
            return false;
        }
    }


    public function get_record_by_id($index_name, $type, $id) {
        $params = ['index' => $index_name, 'type' => $type];
        if (is_array($id)) {
            foreach ($ids as $id) {
                $params['body']['query']['filtered']['filter']['bool']['should'][] = ['match' => ["id" => $id]];
            }
        } else {
            $params['body']['query']['filtered']['filter']['bool']['should'][] = ['match' => ["id" => $id]];
        }


        $response = $this->client->search($params);
        return $response['hits'];
    }


    function update_data($data) {
        return $this->client->update(
                        array(
                            'index' => $data['index'],
                            'type' => $data['type'],
                            'id' => $data['id'],
                            'body' => ['doc' => $data['body_doc']]
                        )
        );
    }

}
