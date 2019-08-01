<?php

namespace App\Traits;

use App\Invantory;

trait InventoriesTrait
{
	private function createInventory( $data )
	{
		Invantory::create( $data );
	}

	/**
	 * @param $materials
	 */
	private function updateMaterials( $materials )
	{
		foreach ($materials as $key => $value)
		{
			Invantory::findOrFail( $key )->update([ 'mat_id' => $value ]);
		}
	}

	/**
	 * @param $purchasedAmounts
	 */
	private function updatePurchasedAmounts( $purchasedAmounts )
	{
		foreach ($purchasedAmounts as $key => $value)
		{
			Invantory::findOrFail( $key )->update([ 'purchased_amount' => $value ]);
		}
	}

	/**
	 * @param $endAmounts
	 */
	private function updateEndAmounts( $endAmounts )
	{
		foreach ( $endAmounts as $key => $value )
		{
			Invantory::findOrFail( $key )->update([ 'end_amount' => $value ]);
		}
	}

	/**
	 * @param $beginAmounts
	 */
	private function updateBeginAmounts( $beginAmounts )
	{
		foreach ( $beginAmounts as $key => $value )
		{
			Invantory::findOrFail( $key )->update([ 'begin_amount' => $value ]);
		}
	}

	/**
	 * @param $costs
	 */
	private function updateCosts( $costs )
	{
		foreach ( $costs as $key => $value )
		{
			Invantory::findOrFail( $key )->update([ 'cost' => $value ]);
		}
	}
}