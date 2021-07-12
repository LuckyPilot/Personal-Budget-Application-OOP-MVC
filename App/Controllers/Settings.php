<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\UserSettings;
use \App\Models\IncomeSettings;
use \App\Models\ExpenseSettings;

/**
 * Settings controller
 *
 * PHP version 7.4
 */
class Settings extends Authenticated
{
	
    /**
     * Show the settings page
     *
     * @return void
     */
    public function indexAction() {
		
        View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData] );
		
    }
	
	/**
     * Changing user name
     *
     * @return void
     */
	 public function changeNameAction() {
		 
		 $changeName = new UserSettings( $_POST );
		 $result = $changeName -> changeUserName();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changeNameSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileSettingsErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Changing user password
     *
     * @return void
     */
	 public function changePasswordAction() {
		 
		 $changePassword = new UserSettings( $_POST );
		 $result = $changePassword -> changeUserPassword();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changePasswordSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileSettingsErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Changing user login
     *
     * @return void
     */
	 public function changeEmailAction() {
		 
		 $changeEmail = new UserSettings( $_POST );
		 $result = $changeEmail -> changeUserEmail();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changeLoginSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileSettingsErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Adding new income category for user
     *
     * @return void
     */
	 public function addIncomeCategoryAction() {
		 
		 $addIncomeCategory = new IncomeSettings( $_POST );
		 $result = $addIncomeCategory -> addIncomeCategory();
		 
		 if ($result === true) {
			FlashModals::addModal( "addCategorySuccess" );
			$this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "incomeSettingsErrors" => true, "addIncomeCategoryErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Adding new expense category for user
     *
     * @return void
     */
	 public function addExpenseCategoryAction() {
		 
		 $addExpenseCategory = new ExpenseSettings( $_POST );
		 $result = $addExpenseCategory -> addExpenseCategory();
		 
		 if ($result === true) {
			FlashModals::addModal( "addCategorySuccess" );
			$this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "expenseSettingsErrors" => true, "addExpenseCategoryErrors" => $result] );
		 }
		 
	 }
	 
	/**
     * Modifying income category for user
     *
     * @return void
     */
	 public function modifyIncomeCategoryAction() {
		 
		 $addIncomeCategory = new IncomeSettings( $_POST );
		 $result = $addIncomeCategory -> modifyIncomeCategory();
		 
		 if ($result === true) {
			FlashModals::addModal( "modifyCategorySuccess" );
			$this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "incomeSettingsErrors" => true, "modifyIncomeCategoryErrors" => $result] );
		 }
		 
	 }
	 
	/**
     * Modifying expense category name for user
     *
     * @return void
     */
	 public function modifyExpenseCategoryNameAction() {
		 
		 $modifyExpenseCategory = new ExpenseSettings( $_POST );
		 $result = $modifyExpenseCategory -> modifyExpenseCategoryName();
		 
		 if ($result === true) {
			FlashModals::addModal( "modifyCategorySuccess" );
			$this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "expenseSettingsErrors" => true, "modifyExpenseCategoryNameErrors" => $result] );
		 }
		 
	 }
	 
	/**
     * Modifying expense category limit for user
     *
     * @return void
     */
	 public function modifyExpenseCategoryLimitAction() {
		 
		 $modifyExpenseCategory = new ExpenseSettings( $_POST );
		 $result = $modifyExpenseCategory -> modifyExpenseCategoryLimit();
		 
		 if ($result === true) {
			FlashModals::addModal( "modifyCategorySuccess" );
			$this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "expenseSettingsErrors" => true, "modifyExpenseCategoryLimitErrors" => $result] );
		 }
		 
	 }
	 
	/**
     * Deleting income category for user
     *
     * @return void
     */
	 public function deleteIncomeCategoryAction() {
		 
		 $deleteIncomeCategory = new IncomeSettings( $_POST );
		 $result = $deleteIncomeCategory -> deleteIncomeCategory();
		 
		 if ($result === true) {
			FlashModals::addModal( "deleteCategorySuccess" );
		 } 
		 
		 $this -> redirect( "/settings" ); 
	 }
	
	/**
     * Deleting expense category for user
     *
     * @return void
     */
	 public function deleteExpenseCategoryAction() {
		 
		 $deleteExpenseCategory = new ExpenseSettings( $_POST );
		 $result = $deleteExpenseCategory -> deleteExpenseCategory();
		 
		 if ($result === true) {
			FlashModals::addModal( "deleteCategorySuccess" );
		 } 
		 
		 $this -> redirect( "/settings" ); 
	 }
	 
}

?>