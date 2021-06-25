<?php

namespace App;

/**
 * Flash notification message: mesage for one-time display as modal window, using the session for storage between requests
 *
 * PHP version 7.0
 */
class FlashModals
{
	
	 /**
     * Enable to add message to $_SESSION[modalController] which is controling modals display
     *
	 * @param string $modalName: Name of required modal to display
	 *
     * @return void
     */
	public static function addModal( $modalName ) {
		// Create an array in session if it doesn't already exist
		if (!isset( $_SESSION['modalController'] )) {
			$_SESSION['modalController'] = [];
		}
		
		// Append the message to the array
		$_SESSION['modalController'][$modalName] = true;
	}
	
	/**
     * Get all the modal's names
	 *
     * @return An array with all the modal's names or null if none set
     */
	 public static function getModals() {
		 if (isset( $_SESSION['modalController'] )) {
			 $modal = $_SESSION['modalController'];
			 unset( $_SESSION['modalController'] );
			return $modal;
		}
	 }
}

?>