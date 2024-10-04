<?php
require_once plugin_dir_path( __FILE__ ) . "config.php";
class ToolkitGitHubPluginUpdater {
   
    private $slug; // plugin slug
    private $gitHubUsername; // GitHub username
    private $gitHubProjectrepo; // GitHub repo name
    private $pluginFile; // __FILE__ of our plugin
    private $accessToken; // GitHub private repo token
    private $pluginData; // plugin data
    private $githubAPIResult; // holds data from GitHub

    function __construct( $pluginFile, $gitHubUsername, $gitHubProjectrepo, $accessToken = '' ) {
        add_filter( "pre_set_site_transient_update_plugins", array( $this, "getPluginUpdateInformation" ) ,10);
        add_filter( "plugins_api", array( $this,  "setPluginInfo" ) , 10, 3 );
        add_filter( "upgrader_post_install", array( $this, "postInstall" ), 10, 3 );

        $this->pluginFile = $pluginFile;
        $this->username = $gitHubUsername;
        $this->repo = $gitHubProjectrepo;
        $this->accessToken = $accessToken;
        // Add Authorization Token to authToken_download_package
        add_filter('upgrader_pre_download', function ($reply, $package, $upgrader) {
            // The slug of your custom plugin
            $plugin_slug = 'ss-toolkit'; 

            // Get the current plugin being upgraded
            if (isset($upgrader->skin->plugin) && strpos($upgrader->skin->plugin, $plugin_slug) !== false) {
                // Add the authToken_download_package filter only if it's your custom plugin
                add_filter('http_request_args', [$this, 'authToken_download_package'], 15, 2);
            }

            return $reply; // Return the default value
        }, 10, 3);
    }

    /**
     * Get information regarding our plugin from WordPress
     * 
     * @since 2.0.0
     */
    private function GetPluginData() {
        $this->slug = $this->pluginFile;
        $this->pluginData = get_plugin_data( WP_PLUGIN_DIR . '/' . $this->slug );
    }

    /**
     * Get information regarding our plugin from GitHub
     * 
     * @since 2.0.0
     */
    private function getPluginReleaseInfo() {
        // Only do this once
        if ( !empty( $this->githubAPIResult ) ) {
            return;
        }

        // Query the GitHub API
        $url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";

        // Initialize args
        $args = [];

        // Add Authorization header only for private repos
        if ( !empty( $this->accessToken ) ) {
            $args['headers']['Authorization'] = "bearer {$this->accessToken}";
        }

        // Get the results 
        $this->githubAPIResult = wp_remote_retrieve_body( wp_remote_get( $url , $args) );
        if ( !empty( $this->githubAPIResult ) ) {
            $this->githubAPIResult = @json_decode( $this->githubAPIResult );
        }

        // Use only the latest release
        if ( is_array( $this->githubAPIResult ) ) {
            $this->githubAPIResult = $this->githubAPIResult[0];
        }
        
    }

    /**
     * Push in plugin version information to get the update notification
     * 
     * @since 2.0.0
     */
    public function getPluginUpdateInformation( $transient ) {

        // If we have checked the plugin data before, don't re-check
        if ( empty( $transient->checked ) ) {
            return $transient;
        }

        // Get plugin & GitHub release information
        $this->GetPluginData();
        $this->getPluginReleaseInfo();

        // Check the versions if we need to do an update
        $doUpdate = version_compare($this->githubAPIResult->tag_name, $transient->checked[$this->slug]);

        // Update the transient to include our updated plugin data
        if ($doUpdate == 1) {
            $package = $this->githubAPIResult->zipball_url;
            $args = [];

            $obj = new stdClass();
            $obj->slug = $this->slug;
            $obj->new_version = $this->githubAPIResult->tag_name;
            $obj->url = $this->pluginData["PluginURI"];
            $obj->package = $package;
            $transient->response[$this->slug] = $obj;
        }
        
        return $transient;
    }

    /**
     * Push in plugin version information to display in the details lightbox
     * 
     * @since 2.0.0
     */
    public function setPluginInfo( $false, $action , $response ) {
        if ( $action !== 'plugin_information' ) {
            return false;
        }

        // If nothing is found, do nothing
        if ( empty( $response->slug ) || $response->slug != $this->pluginFile ) {
            return false;
        }

        // Get plugin & GitHub release information
        $this->GetPluginData();
        $this->getPluginReleaseInfo();

        // Add our plugin information
        $response->name  = $this->pluginData["Name"];
        $response->slug  = $this->pluginFile;
        $response->requires = '6.0.0';
        $response->tested = '6.3';
        $response->version = $this->githubAPIResult->tag_name;
        $response->author = $this->pluginData["AuthorName"];
        $response->author_profile = $this->pluginData["AuthorURI"];
        $response->last_updated = $this->githubAPIResult->published_at;
        $response->homepage = $this->pluginData["PluginURI"];
        $response->short_description = $this->pluginData["Description"];
        $response->sections['Description']  = $this->pluginData["Description"];
        $response->sections['Updates'] = $this->githubAPIResult->body;
        $response->download_link = $this->githubAPIResult->zipball_url;

        return $response;
    }

    /**
     * Perform additional actions to successfully install our plugin
     * 
     * @since 2.0.0
     */
    public function postInstall( $true, $hook_extra, $result ) {
        // Get plugin information
        $this->GetPluginData();

        // Remember if our plugin was previously activated
        $wasActivated = is_plugin_active( $this->slug );

        // Since we are hosted in GitHub, our plugin folder would have a dirname of
        // reponame-tagname change it to our original one:
        global $wp_filesystem;
        $pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname( $this->slug );
        $wp_filesystem->move( $result['destination'], $pluginFolder );
        $result['destination'] = $pluginFolder;

        // Re-activate plugin if needed
        if ( $wasActivated ) {
            $activate = activate_plugin( $this->slug );
        }

        return $result;
    }

    /**
     * Add Authorization Token to authToken_download_package
     * 
     * @since 2.0.0
     */
    public function authToken_download_package( $args, $url ) {
        // Check if a filename exists and add authorization if accessToken is available
        if ( null !== $args['filename'] ) {
            // Only add the Authorization header if an access token is provided
            if( !empty($this->accessToken) ) { 
                $args['headers'] = isset($args['headers']) ? $args['headers'] : [];
                $args['headers']['Authorization'] = "token {$this->accessToken}";
            }
        }
        
        // Remove the filter to prevent it from being applied multiple times
        remove_filter( 'http_request_args', [ $this, 'authToken_download_package' ] );

        return $args;
    }
}


