<?php
$currentRoot = dirname(__FILE__);
require_once $currentRoot.'/dbbase.class.php';

/**
 * Presonal data class
 *
 * @note Connection need to be established before methods of this class are used.
 */
class dbPersonal extends dbBaseClass
{
	/**
	 * @see dbBaseClass
	 * @var string
	 */
	protected $pv_tableName = 'personal';

	/**
	 * @see dbBaseClass
	 * @var array
	 */
	protected $pv_aliasNames2colNames = array (
		'id' => 'id',
		'dt' => 'dt',
		
		'imie' => 'imie',
		'nazwisko' => 'nazwisko',
		'nr_tel' => 'nr_tel',
		'e_mail' => 'e_mail',
	);
}

?>