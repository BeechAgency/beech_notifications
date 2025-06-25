<?php

class Beech_notifications_updater {
    private $file;    
    private $plugin;    
    private $basename;    
    private $active;    
    private $username;    
    private $repository;    
    private $authorize_token;
    private $github_response;

    public function __construct( $file ) {
        $this->file = $file;
        add_action( 'admin_init', array( $this, 'set_plugin_properties' ) );

        return $this;
    }

    public function set_plugin_properties() {
        $this->plugin	= get_plugin_data( $this->file );
        $this->basename = plugin_basename( $this->file );
        $this->active	= is_plugin_active( $this->basename );
    }

    public function set_username( $username ) {
        $this->username = $username;
    }

    public function set_repository( $repository ) {
        $this->repository = $repository;
    }

    public function authorize( $token ) {
        $this->authorize_token = $token;
    }

    private function get_repository_info() {
        if ( !is_null( $this->github_response ) ) {
            return; // We already have a response so bail.
        }
    
        $args = array();
        $request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases/latest', $this->username, $this->repository ); // Build URI
    
        $this->request_uri = $request_uri;
    
        $headers = array(
            'User-Agent: ' . $this->username,
        );
    
        if ($this->authorize_token) {
            $headers[] = 'Authorization: token ' . $this->authorize_token;
        }
    
        $ch = curl_init($request_uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($http_code == 200) {
            $this->github_response = json_decode($response);

        } 
    
        return;
    }

    public function initialize() {
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'modify_transient' ), 10, 1 );
        add_filter( 'plugins_api', array( $this, 'plugin_popup' ), 10, 3);
        add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );
        
        // Add Authorization Token to download_package
        add_filter( 'upgrader_pre_download',
            function() {
                add_filter( 'http_request_args', [ $this, 'download_package' ], 15, 2 );
                return false; // upgrader_pre_download filter default return value.
            }
        );
    }

    public function modify_transient( $transient ) {

        if( !property_exists( $transient, 'checked') ) {
            return $transient;
        }
        if( !$transient->checked ) {
            return $transient; // Did Wordpress check for updates?
        }

        $checked = $transient->checked;
        
        $this->get_repository_info(); // Get the repo info
        

        if( gettype($this->github_response) === "boolean" ) { 
            return $transient; 
        }

        $github_version = filter_var($this->github_response->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $out_of_date = version_compare( 
            $github_version, 
            $checked[ $this->basename ], 
            'gt' 
        ); // Check if we're out of date


        // If she not out of date get outta here.
        if( !$out_of_date )  {
            return $transient; 
        }

        $git_response = $this->github_response;

        $new_files = $this->github_response->zipball_url; // Get the ZIP

        // If there are theme assets attached, use those instead!
        if( isset($git_response->assets) && is_countable($git_response->assets) && count($git_response->assets) > 0 ) {
            $new_files = $git_response->assets[0]->browser_download_url;
        }

        if (isset($git_response->assets[0]->id)) {
            $asset_id = $this->github_response->assets[0]->id;
            $new_files = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases/assets/{$asset_id}";
        }

        $slug = current( explode('/', $this->basename ) ); // Create valid slug
        $this->package_url = $new_files;

        $theme = array( // setup our theme info
            'url' => 'https://github.com/'.$this->username.'/'.$this->repository,
            'slug' => 'beechagency2023',
            'package' => $new_files,
            'new_version' => $github_version
        );

        $transient->response[$this->basename] = $theme; // Return it in response

        return $transient; // Return filtered transient
    }

    public function plugin_popup( $result, $action, $args ) {

        if( ! empty( $args->slug ) ) { // If there is a slug
            
            if( $args->slug == current( explode( '/' , $this->basename ) ) ) { // And it's our slug

                $this->get_repository_info(); // Get our repo info
                
                $download_link = $this->github_response['zipball_url']; // Get the ZIP

                // If there are theme assets attached, use those instead!
                if( isset($this->git_response['assets']) && is_countable($this->git_response['assets']) && count($this->git_response['assets']) > 0 ) {
                    $download_link = $this->git_response['assets'][0]['browser_download_url'];
                }

                // Set it to an array
                $plugin = array(
                    'name'				=> $this->plugin["Name"],
                    'slug'				=> $this->basename,
                    'requires'					=> '5.1',
                    'tested'						=> '6.4.2',
                    'rating'						=> '100.0',
                    'num_ratings'				=> '5',
                    'downloaded'				=> '5',
                    'added'							=> '2024-03-01',
                    'version'			=> $this->github_response['tag_name'],
                    'author'			=> $this->plugin["AuthorName"],
                    'author_profile'	=> $this->plugin["AuthorURI"],
                    'last_updated'		=> $this->github_response['published_at'],
                    'homepage'			=> $this->plugin["PluginURI"],
                    'short_description' => $this->plugin["Description"],
                    'sections'			=> array(
                        'Description'	=> $this->plugin["Description"],
                        'Updates'		=> $this->github_response['body'],
                    ),
                    'download_link'		=> $download_link
                );

                return (object) $plugin; // Return the data
            }

        }
        return $result; // Otherwise return default
    }

    public function download_package( $args, $url ) {
        if (strpos($url, $this->username . '/' . $this->repository) === false) {
            return $args;
        }
    
        if ($this->authorize_token) {
            $this->log("Secure download required for $url");
            if (!isset($args['headers'])) {
                $args['headers'] = [];
            }
    
            $args['headers']['Authorization'] = "token {$this->authorize_token}";
            $args['headers']['Accept'] = "application/octet-stream"; // Important for GitHub asset downloads
        }
    
        remove_filter('http_request_args', [$this, 'download_package']);
    
        return $args;
    }

    public function after_install( $response, $hook_extra, $result ) {
        global $wp_filesystem; // Get global FS object

        $install_directory = plugin_dir_path( $this->file ); // Our plugin directory
        $wp_filesystem->move( $result['destination'], $install_directory ); // Move files to the plugin dir
        $result['destination'] = $install_directory; // Set the destination for the rest of the stack

        if ( $this->active ) { // If it was active
            activate_plugin( $this->basename ); // Reactivate
        }

        return $result;
    }
}
