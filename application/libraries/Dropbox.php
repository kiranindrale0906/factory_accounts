<?php

class Dropbox {

//    use Kunnu\Dropbox\DropboxApp;

    private $client_id = 'qqdkx3vbg6pjig5';
    private $client_secret = '1sljx6kxf6tina1';

    function __construct() {
        require_once APPPATH.'third_party/Dropbox/vendor/autoload.php';

        $this->ci = & get_instance();
        // $this->access_token = $this->ci->config->item('access-token', 'Dropbox');
        $this->ci->load->model('Client_dropbox_model');
        $this->access_token = $this->ci->Client_dropbox_model->get();
        $this->dropbox_client = $this->getClient();
    }

    function getClient() {
        if ($this->checkAccessToken()) {
            $app = new Kunnu\Dropbox\DropboxApp($this->client_id, $this->client_secret, $this->access_token);
        } else {
            $app = new Kunnu\Dropbox\DropboxApp($this->client_id, $this->client_secret);
        }

        return new Kunnu\Dropbox\Dropbox($app);
    }

    function authorize() {
        $authHelper = $this->dropbox_client->getAuthHelper();
        $callbackUrl = BASE_URL.'Client_dropbox/success';
        // echo $callbackUrl;die;
        if (isset($_GET['code']) && isset($_GET['state'])) {
            $code = $_GET['code'];
            $state = $_GET['state'];
            $accessToken = $authHelper->getAccessToken($code, $state, $callbackUrl);
            return $accessToken->getToken();
        } else {
            $authUrl = $authHelper->getAuthUrl($callbackUrl);
            redirect($authUrl);
        }
    }

    function checkAccessToken() {
        if (isset($this->access_token) && '' != $this->access_token) {
            $_SESSION['access-token'] = $this->access_token;
            return true;
        } else {
            return false;
        }
    }

    function getFiles($path="/") {
        $listFolderContents = $this->dropbox_client->listFolder($path);
        $items = $listFolderContents->getItems();
        // $list = $items->all();
        // $items->first();
        // $items->last();
        return $items;
        // $listFolderContents = $this->dropbox_client->listFolder($path);
        //     if ($listFolderContents->hasMoreItems()) {
        //         //Fetch Cusrsor for listFolderContinue()
        //         $cursor = $listFolderContents->getCursor();

        //         //Paginate through the remaining items
        //         $listFolderContinue =$this->dropbox_client->listFolderContinue($cursor);

        //         $remainingItems = $listFolderContinue->getItems();
        //     }
        //    return $remainingItems;
    }

    function get($path) {
        $entry = array();
        $entry = $this->dropbox_client->listFolder('/' . $path);
        return $entry;
    }
    public function getMetadataExists($searchQuery){
        $searchResults = $this->dropbox_client->search("/", $searchQuery, ['start' => 0, 'max_results' => 5]);
        $items = $searchResults->getItems();
        if($searchResults->getCursor() > 0){
            $first_item = $items->first();
            return $first_item->metadata['path_display'];
        }
        return false;

    }

    public function getThumbnail($path) {
        $size = 'small'; //Default size

        $format = 'jpeg'; //Default format

        $file = $this->dropbox_client->getThumbnail($path, $size, $format);

        return $file->getContents();
    }
    public function download_files($path,$upload_path,$datetime="_"){
        $file = $this->dropbox_client->download($path);

        //File Contents
        $contents = $file->getContents();
        //Save file contents to disk
        $metadata = $file->getMetadata();
        $name = $metadata->getName();
        $name_arr = explode('/', $path);
       
        file_put_contents($upload_path.$datetime.$name, $contents);
        $result = $this->dropbox_client->delete($path);
    }

}
