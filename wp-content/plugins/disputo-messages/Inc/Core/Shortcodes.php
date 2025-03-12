<?php namespace BBP_MESSAGES\Inc\Core;

class Shortcodes
{
    public $shortcodes;

    public function __construct()
    {
        $this->shortcodes = array(
            'bbpm-unread-count' => array(
                'callback' => array($this, 'unreadCount')
            ),
            'bbpm-contact-link' => array(
                'callback' => array($this, 'contactLink')
            ),
            'bbpm-messages-link' => array(
                'callback' => array($this, 'messagesLink')
            ),
            'bbpm-messages-count' => array(
                'callback' => array($this, 'messagesCount')
            ),
            'bbpm-chat-unread-count' => array(
                'callback' => array($this, 'chatUnreadCount')
            )
        );
    }

    public function init()
    {
        foreach ( $this->shortcodes as $t=>$s ) {
            add_shortcode($t, $s['callback'], 10);
        }
    }

    public function unreadCount($atts) {
        $atts = shortcode_atts(array(
            'user_id' => 0,
            'unique' => 0
        ), $atts);

        extract(array_map('intval', $atts));

        return (int) bbpm_messages()->getChatsUnreadCount($user_id, $unique);
    }
    
    public function contactLink($atts) {
        $atts = shortcode_atts(array(
            'user_id' => 0,
            'current_user' => 0
        ), $atts);

        extract(array_map('intval', $atts));

        if ( !$user_id )
            return;

        if ( !$current_user ) {
            global $current_user;
            $current_user = $current_user->ID;
        }

        global $bbpm_bases;

        if ( $current_user ) {
            return bbpm_messages_url(sprintf(
                '%s/%d',
                $bbpm_bases['with'],
                $user_id
            ), $current_user);
        } else {
            return apply_filters(
                'bbpm_redirect_login_url',
                wp_login_url()
            );
        }
    }
    
    public function messagesLink($atts) {
        $atts = shortcode_atts(array(
            'user_id' => 0,
        ), $atts);

        extract(array_map('intval', $atts));

        if ( !$user_id ) {
            global $current_user;

            if ( !$current_user->ID )
                return;

            $user_id = $current_user->ID;
        }

        return bbpm_messages_url(null, $user_id);
    }
    
    public function messagesCount($atts) {
        $atts = shortcode_atts(array(
            'user_id' => 0,
            'contact_or_chat_id' => null
        ), $atts);

        $atts['user_id'] = (int) $atts['user_id'];
        extract($atts);
        $m = bbpm_messages();

        if ( !$user_id ) {
            $user_id = $m->current_user;
        }

        if ( $contact_or_chat_id ) {
            if ( is_numeric($contact_or_chat_id) && get_userdata($contact_or_chat_id) ) {
                $chat_id = $m->getPrivateSharedChat($user_id, $contact_or_chat_id);
            } else {
                $chat_id = $contact_or_chat_id;
            }
        } else {
            $chat_id = null;
        }

        return (int) $m->getUserTotalMessages($user_id, $chat_id);
    }

    public function chatUnreadCount($atts) {
        $atts = shortcode_atts(array(
            'user_id' => 0,
            'contact_or_chat_id' => null
        ), $atts);

        $atts['user_id'] = (int) $atts['user_id'];
        extract($atts);
        $m = bbpm_messages();

        if ( !$user_id ) {
            $user_id = $m->current_user;
        }

        if ( $contact_or_chat_id ) {
            if ( is_numeric($contact_or_chat_id) && get_userdata($contact_or_chat_id) ) {
                $chat_id = $m->getPrivateSharedChat($user_id, $contact_or_chat_id);
            } else {
                $chat_id = $contact_or_chat_id;
            }
        } else {
            $chat_id = null;
        }

        if ( !$chat_id )
            return;

        return (int) $m->getChatUnreadCount($chat_id, $user_id);
    }

}
?>