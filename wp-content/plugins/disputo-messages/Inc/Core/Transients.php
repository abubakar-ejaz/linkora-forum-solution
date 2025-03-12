<?php namespace BBP_MESSAGES\Inc\Core;
class Transients
{
	protected static $instance;
	public $per_item
	     , $is_object
	     , $batches
	     , $timeout
	     , $key;
	function __construct() {
		$this->per_item = 750;
		$this->is_object = $this->batches = null;
	}
	
	static function set( $data, $timeout, $key, $per_item = null ) {
		$class = null == self::$instance ? new self : self::$instance;
		return $class->_set( $data, $timeout, $key, $per_item );
	}
	static function get( $key, $callback = null, $timeout = null, $per_item = null ) {
		$class = null == self::$instance ? new self : self::$instance;
		return $class->_get( $key, $callback, $timeout, $per_item );
	}
	static function delete( $key ) {
		$class = null == self::$instance ? new self : self::$instance;
		return $class->_delete( $key );
	}
	function _set( $data, $timeout, $key, $per_item = null ) {
		$this->timeout = $timeout;
		$this->key = $key;
		if ( $per_item ) {
			$this->per_item = (int) $per_item;
		}
		$data = $this->chunks( $data );
		if ( $this->batches ) {
			foreach ( $data as $i => $portion ) {
				$key = sprintf( "%s_%d", $this->key, $i );
				set_transient("se_transients__{$key}", $portion, $this->timeout);
			}
			update_option( "se_transients_{$this->key}_length", count($data) );
		} else {
			set_transient("se_transients__{$this->key}", $data, $this->timeout);
		}
		if ( $this->is_object ) {
			update_option( "se_transients_is_object_{$this->key}", true );			
		}
		return true;
	}
	function _get( $key, $callback = null, $timeout = null, $per_item = null ) {
		$this->key = $key;
		if ( $timeout ) {
			$this->timeout = (int) $timeout;
		}
		if ( false !== $batches = (int) get_option( "se_transients_{$this->key}_length" ) ) {
			$this->batches = $batches;
		}
		if ( false !== $is_object = get_option( "se_transients_is_object_{$this->key}" ) ) {
			$this->is_object = true;
		}
		if ( ! $this->batches ) {
			$data = get_transient( "se_transients__{$this->key}" );
		} else {
			$data = array();
			$last_key = 0;
			for ( $i=0; $i < $this->batches; $i++ ) {
				$portion = get_transient( "se_transients__{$key}_{$i}" );
				if ( is_array($portion) ) {
					
					if ( !is_array( $portion ) ) {
						$data[$last_key] = $portion;
						$last_key++;
					} else {
						
						foreach ( $portion as $item ) {
							$data[$last_key] = $item;
							$last_key++;
						}
					}
				}
			}
		}
		if ( $this->is_object ) {
			$data = (object) $data;
		}
		if ( false === $data && !empty( $callback ) && is_callable( $callback ) ) {
			$data = call_user_func( $callback );
			$this->_set( $data, $this->timeout, $this->key, $per_item );
		}
		return $data;
	}
	function _delete( $key ) {
		$this->key = $key;
		if ( false !== $batches = (int) get_option( "se_transients_{$this->key}_length" ) ) {
			$this->batches = $batches;
			delete_option( "se_transients_{$this->key}_length" );
		}
		delete_option( "se_transients_is_object_{$this->key}" );
		if ( ! $this->batches ) {
			$deleted = delete_transient( "se_transients__{$this->key}" );
		} else {
            $deleted = array();
			for ( $i=0; $i < $this->batches; $i++ ) {
				$deleted[] = delete_transient( "se_transients__{$key}_{$i}" );
			}
		}
        return $deleted; // bool|array
	}
	function chunks( $data ) {

		if ( 720000 > strlen( serialize( $data ) ) )
			return $data;

		$original_data = $data;
		if ( is_object( $data ) ) {
			$data = (array) $data;
			$this->is_object = true;
		}
		else if ( !is_array( $data ) ) {
			return $data; // only array|object types are processed
		}
		$chunks = array_chunk($data, $this->per_item);
		
		if ( count( $chunks ) < 2 ) {
			return $original_data; // no chunks required
		}
		$this->batches = true;
		return $chunks;
	}
}
?>