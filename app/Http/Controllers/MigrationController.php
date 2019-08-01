<?php namespace App\Http\Controllers;

use App\Services\DataMigrationService;

class MigrationController extends Controller
{

	private $_service;
	
	public function __construct(){
		set_time_limit ( 0 );
		ini_set('memory_limit','3.5G');

		$this->_service = new DataMigrationService;
	}

	public function run()
    {
        // Truncate Tables
        echo "<h3>Starting Table Truncation</h3>";

        $this->_service->truncateTables();

        echo "<h3>Completion of Truncated Tables</h3>";
        echo "=======================================================================\n";

        // Import Tax Districts
        echo "<h3>Starting Tax District Data Migration</h3>";

        $this->_service->migrateTaxDistricts();

        echo "<h3>Completing Tax District Data Migration</h3>";
        echo "=======================================================================\n";

        // Import Accounts
        echo "<h3>Starting Account Import</h3>";

        $this->_service->migrateAccounts();

        echo "<h3>Completed Account Data Transfer</h3>";

        echo "=======================================================================\n";

        // Import Technicians
        echo "<h3>Staring Technician Data Migration</h3>";

        $this->_service->migrateTechnicians();

        echo "<h3>Completed Technician Data Migration</h3>";
        echo "=======================================================================\n";

        // Import Materials
        echo "<h3>Starting Material Data Migration</h3>";

        $this->_service->migrateMaterials();

        echo "<h3>Completed Material Data Migration</h3>";
        echo "=======================================================================\n";

        // Importing Inventory
        echo "<h3>Starting Inventory Data Migration</h3>";

        $this->_service->migrateInventory();

        echo "<h3>Completed Inventory Data Migration</h3>";
        echo "=======================================================================\n";

        // Importing Users
        echo "<h3>Starting User Data Migration</h3>";

        $this->_service->migrateUsers();

        echo "<h3>Completed User Data Migration</h3>";
        echo "=======================================================================\n";

        // Import Field Report Data
        echo "<h3>Starting Field Data Import</h3>";

        $this->_service->migrateFieldData();

        echo '<h3>Completed Field and Data DB Transfer</h3>';

        echo "=======================================================================\n";
    }

	public function accounts()
    {

		echo "<h3>Starting Account Import</h3>";

		$this->_service->migrateAccounts();

		echo "<h3>Completed Account Data Transfer</h3>";
	}

 	public function fields()
    {
        echo "<h3>Starting Field Data Import</h3>";

        $this->_service->migrateFieldData();

        echo '<h3>Completed Field and Data DB Transfer</h3>';
	}

	public function inventoryMigrate()
    {
		echo "<h3>Starting Inventory Data Migration</h3>";

		$this->_service->migrateInventory();

		echo "<h3>Completed Inventory Data Migration</h3>";
	}

	public function materialMigrate()
    {
		echo "<h3>Starting Material Data Migration</h3>";

        $this->_service->migrateMaterials();

		echo "<h3>Completed Material Data Migration</h3>";
	}

	public function taxDistricts()
    {
		echo "<h3>Starting Tax District Data Migration</h3>";

        $this->_service->migrateTaxDistricts();

		echo "<h3>Completing Tax District Data Migration</h3>";
	}

	public function users()
    {
		echo "<h3>Starting User Data Migration</h3>";

        $this->_service->migrateUsers();

		echo "<h3>Completed User Data Migration</h3>";
	}

	public function techs(){
		echo "<h3>Staring Technician Data Migration</h3>";

		$this->_service->migrateTechnicians();

		echo "<h3>Completed Technician Data Migration</h3>";
	}
}
