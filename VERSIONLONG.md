# Versions
---

## 2.0.12 2018-06-13
* Repair to the Utilities menu that was causing the main menu not to load
* Replaced the Notes field on the Account Edit form with a regular text field
* Repaired the Dates Display throughout the program
* Repaired an issue that was causing the dates to save as invalid when editing an Account
* Added the ability to print the Tax District List

## 2.0.11 2018-05-26
* Fix to all phone numbers in the system so they are masked properly when being input
* Fix to all date fields in the system so they are masked properly when being input
* Change to Account Creation and Edit so that when fountain cleaning is selected we offer both Bi-Monthly and Monthly options
* Fix to the CPR report so that Phone numbers are showing on one line
* Fix to the CPR report so that Frequency Data is shown on one line
* Complete refactor of the Data Transfer system.

## 2.0.10 2018-05-07
* Hit Tab or Enter to select a Material when creating a new FAR
* Add start date to Account Expiration Report
* Fixed the Account Reference list so the Sort By Account Number functions correctly

## 2.0.9 2018-05-11
* Hotfix to repair the status image on the FAR

## 2.0.8 2018-05-11
* Repair to status images for accounts so we are showing the green checkmark for active accounts
* Added filter functionality to the Account Reference List
* Repaired an issue that was causing the FAR to not reset when the user clicks close.

### 2.0.7 2018-05-01
* Allow Field Managers to Change Materials in the FAR
* Auto-populate the Tech Field when creating a new FAR
* Hit Tab or Enter to select a Material when creating a new FAR
* Clear FAR form once created
* Repaired an issue with the printing the CAR
* Fixed the Account Expiration Report to include other statuses as Active
* Add All Offices filter to Account Reference List
* Add start date to Account Expiration Report
* Fixed the data pull for the Global Expiration Report
* Fixed a layout issue when Printing All Global Expiration Reports
* Fixed the load speed of the Account Reference Report
* Added the ability to delete an entire FAR

### 2.0.6 2018-03-26
* Added Month Selection to Fountain Cleaning
* Added Missing Statuses

### 2.0.5 2018-03-21
* Removed the duplicate "Active" status from the status dropdown and alphabetized the rest of the options.
* Repaired and issue with them not being able to add FARs for the CT-P material.

### 2.0.4 2018-03-16
* Capitalize All Company Names:  In the Account View and Preview we now show all Company Names in full caps
* Field Activity Report: We have restored the Edit functionality and repaired the delete functionality so that everything updates correct and is removed correctly from the report.  Please see the video for details.
* Filtering Account Expiration Report:  Now at the top of the Account Expiration Report you can filter by Active, On Hold, Expired, or All.
* Edit Account: The salesman field is able to be changed based on permissions.  So those that do not have permission cannot change the salesman for an account.
* Global Expiration Report - Duplicate Data:  We found and repaired the issue that was reported about duplicated data showing up in the Global Expiration Report view.
* CPR Report:  There is now a "Both" option on the single CPR report, like there is on Global report.  Choosing the option prints the full report, followed immediately by the Budget Report
* Contact Title:  Now, if a title exists for a contact on the CPR report, we show it below the persons name.
* Site Contact Phone with Extension:  We have applied the same logic to this phone number as we did the contact phone number.  If the number has an extension, it appears below the phone number.

## 2.0.5 2018-03-21
* Removed the extra Active Status from the Status Dropdown and ordered the options alphabetically
* Repaired an issue that was preventing materials witha "-" in their code to be added to an FAR.

## 2.0.6 2018-03-28
* Added logic to allow the selection of a Frequency attribute when selecting "Fountain Cleaning" as the account type
* Fixed the status database table by adding "CJ, CK, CL, CR, CV" to the table and transferring all the status names from the old database over to the new one.