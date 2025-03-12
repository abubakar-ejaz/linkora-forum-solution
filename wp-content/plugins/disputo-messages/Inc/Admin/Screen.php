<?php namespace BBP_MESSAGES\Inc\Admin;

class Screen
{
    public $tabs;
    public $current_tab_id;
    public $current_tab;
    public $admin;

    public function setupPages()
    {
        add_menu_page(
            __('bbPress Messages', 'disputo'),
            __('Messages', 'disputo'),
            'manage_options',
            'bbpress-messages',
            array($this, 'screen'),
            'dashicons-email-alt'
        );
        return $this;
    }

    public function admin()
    {
        if ( !$this->admin || !($this->admin instanceof Admin) ) {
            $this->admin = new Admin;
        }
        
        return $this->admin;
    }

    public function getLink($tab)
    {
        if ( is_string($tab) ) {
            $id = $tab;
        } else if (is_array($tab) && isset($tab['id'])) {
            $id = $tab['id'];
        } else {
            $id = null;
        }

        $link = bbp_messages()->isNetworkActive() ? (
            network_admin_url('admin.php?page=')
        ) : (
            admin_url('admin.php?page=')
        );

        if ( trim($id) ) {
            $link .= 'bbpm-' . $id;
        } else {
            $link .= 'bbpress-messages';
        }

        return esc_url($link);
    }

    public function prepare()
    {
        $tabs = bbpm_admin_tabs();

        if ( !$tabs || !is_array($tabs) ) {
            wp_die(__('No tabs loaded yet.', 'disputo'));
        }

        $get_page = $this->admin()->get_page;
        $this->current_tab_id = $get_page;

        if ( 'bbpm-' === substr($this->current_tab_id, 0, 5) ) {
            $this->current_tab_id = substr($this->current_tab_id, 5);
        } else if ( 'bbpress-messages' === $this->current_tab_id ) {
            $this->current_tab_id = null;
        }

        foreach ( (array) $tabs as $tab ) {
            if ( $tab['id'] == $this->current_tab_id ) {
                $this->current_tab = $tab;
                break;
            }
        }
    }

    public function isCurrentTab($tab)
    {
        if ( empty($this->current_tab['name']) )
            return;

        $curr = (array) $this->current_tab;

        if ( !is_array($tab) )
            return;

        foreach ( (array) $tab as $prop=>$data ) {
            switch ($prop) {
                case 'id':
                case 'name':
                    break;
                
                default:
                    unset($tab[$prop]);
                    break;
            }
        }

        foreach ( $curr as $prop=>$data ) {
            switch ($prop) {
                case 'id':
                case 'name':
                    # code...
                    break;
                
                default:
                    unset($curr[$prop]);
                    break;
            }
        }

        return ($tab && $curr) && $tab == $curr;
    }

    public function screen()
    {
        // wrap
        print '<div class="wrap">';
        print '<h1>';
        print __('Disputo Messages Settings', 'disputo');
        print '</h1>';
        // print content
        $this->content();
        // close wrap
        print '</div>';
    }

    public function content()
    {
        if ( !empty($this->current_tab['content_callback']) && is_callable($this->current_tab['content_callback']) ) {
            // start buffer
            ob_start();
            // call content callback for this screen
            call_user_func($this->current_tab['content_callback']);
            // capture output
            $content = ob_get_clean();
            // append nonces
            $content = preg_replace_callback('/<\/form>/si', function($m){
                $html = wp_nonce_field('admin_post', 'bbpm_nonce', true, false) . PHP_EOL;
                $html .= '</form>';
                return $html;
            }, $content);
            // print
            printf ('<div class="bbpm-content" style="max-width:940px;">%s</div>', $content);

        } else {
            // print an error message
            $this->admin()->feedback(
                __('This custom tab does not appear to have a valid content callback.', 'disputo'),
                false
            )->uiFeedback();
        }
    }

    public function maybeUpdate()
    {
        $this->handleRequest();

        if ( !isset( $_POST['bbpm_nonce'] ) )
            return;

        if ( !wp_verify_nonce($_POST['bbpm_nonce'], 'admin_post') )
            return;

        return $this->update();
    }

    public function handleRequest()
    {
        if ( !empty($this->current_tab['request_handler']) && is_callable($this->current_tab['request_handler']) ) {
            call_user_func($this->current_tab['request_handler']);
        }
    }

    public function update()
    {
        if ( !empty($this->current_tab['update_callback']) && is_callable($this->current_tab['update_callback']) ) {
            call_user_func($this->current_tab['update_callback']);
        }
    }
}
?>