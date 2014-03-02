<?php
/**
 * Template helper for modules.
 * 
 * @author Maciej Nux Jaros
 */
class ModuleTemplate
{
	/**
	 * Set to template file name.
	 *
	 * This is a path relative to module dir.
	 *
	 * @var string
	 */
	public $file = '';
	/**
	 * HTML message to be displayed INSTEAD of the file.
	 * 
	 * @var string
	 */
	public $message = '';
	/**
	 * Data for the template (use in template as $tplData)
	 * @var string
	 */
	public $data = '';

	/**
	 * Extra tags (HTML) to be appended to head.
	 * @var string
	 */
	public $extraHeadTags = '';

	/**
	 * @var string
	 */
	private $moduleDir;

	/**
	 * @param string $moduleDir Set from ModuleController.
	 */
	public function __construct($moduleDir)
	{
		$this->moduleDir = $moduleDir;
	}

	/**
	 * Render (echo) the message or the file.
	 */
	public function render()
	{
		if (empty($this->message))
		{
			if (!empty($this->file))
			{
				$tplData = $this->data;
				include $this->moduleDir.'/'.$this->file;
				unset($tplData);
			}
		}
		else
		{
			echo $this->message;
		}
	}	

	/**
	 * Prints typical key->value array.
	 *
	 * @param array $rows
	 * @param array $columnToAliasArray An array for alias translation:
	 *		array('id' => 'l.p.'),
	 *		This should work as if SELECT statement contained: `id as "l.p."`
	 * @param array $columnExtraTransformationArray może wyglądać np. tak:
	 *		array('id' => function($value){ return parseEmails($value); }),
	 */
	function printArray($rows, $columnToAliasArray = array(), $columnExtraTransformationArray = array())
	{
		if (empty($rows))
		{
			//! @todo i18n
			echo 'brak danych do wy&#347;wietlenia';
			return;
		}

		echo '<table class="sortable">';

		//
		// nagłówek
		echo '<tr>';
		foreach ($rows as &$row)
		{
			foreach ($row as $column=>&$value)
			{
				if (!empty($columnToAliasArray) && !empty($columnToAliasArray[$column]))
				{
					$column = $columnToAliasArray[$column];
				}

				if ($column!='row_class')
				{
					echo '<th>'.$column.'</th>';

					$dateRows[$column] = (preg_match('/^[dD]ata\b/', $column)) ? true : false;
				}
			}
			break;
		}
		echo "</tr>\n";

		//
		// wnętrze
		foreach ($rows as &$row)
		{
			if (!empty($row['row_class']))
			{
				echo "\n".'<tr class="'.$row['row_class'].'">';
				unset($row['row_class']);
			}
			foreach ($row as $column=>&$value)
			{
				$originalName = $column;
				if (!is_array($value))
				{
					if (!empty($columnToAliasArray) && !empty($columnToAliasArray[$column]))
					{
						$column = $columnToAliasArray[$column];
					}

					if (isset($columnExtraTransformationArray[$originalName]))
					{
						echo '<td>'. $columnExtraTransformationArray[$originalName]($value) .'</td>';
					}
					else if ($dateRows[$column] && !empty($value))
					{
						echo '<td>'. date('Y-m-d H:i:s', $value) .'</td>';
					}
					else
					{
						echo '<td>'.strtr($value,array('  '=>' &nbsp;',"\n"=>'<br />')).'</td>';
					}
				}
				else
				{
					echo '<td>';
					pf_printArray($value);
					echo '</td>';
				}
			}
			echo '</tr>';
		}

		//
		// koniec
		echo '</table>';
	}
}
