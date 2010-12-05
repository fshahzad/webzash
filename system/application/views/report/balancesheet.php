<?php
	$this->load->library('accountlist');

	echo "<table border=0>";
	echo "<tr valign=\"top\">";

	$liability = new Accountlist();
	echo "<td>";
	$liability->init(2);
	echo "<table border=0 cellpadding=5 class=\"generaltable\" width=\"450\">";
	echo "<thead><tr><th>Liabilities</th><th>Amount</th></tr></thead>";
	$liability->account_st_short(0);
	echo "</table>";
	echo "</td>";
	$liability_total = -$liability->total;

	$asset = new Accountlist();
	echo "<td>";
	$asset->init(1);
	echo "<table border=0 cellpadding=5 class=\"generaltable\" width=\"450\">";
	echo "<thead><tr><th>Assets</th><th>Amount</th></tr></thead>";
	$asset->account_st_short(0);
	echo "</table>";
	echo "</td>";
	$asset_total = $asset->total;

	echo "</tr>";

	$income = new Accountlist();
	$income->init(3);
	$expense = new Accountlist();
	$expense->init(4);

	$income_total = -$income->total;
	$expense_total = $expense->total;

	$pandl = $income_total - $expense_total;

	$diffop = $this->Ledger_model->get_diff_op_balance();

	/* Liability side */

	$total = $liability_total;

	echo "<tr style=\"background-color:#F8F8F8;\">";
	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"vouchertable\" width=\"450\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Liability Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($liability_total) . "</td>";
	echo "</tr>";

	/* If Profit then Liability side, If Loss then Asset side */
	if ($pandl != 0)
	{
		if ($pandl > 0)
		{
			$total += $pandl;
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Profit & Loss A/C (Net Profit)</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur($pandl) . "</td>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}

	/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
	if ($diffop != 0)
	{
		if ($diffop > 0)
		{
			$total += $diffop;
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Diff in O/P Balance</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur($diffop) . "</td>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}

	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($total) . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";

	/* Asset side */

	$total = $asset_total;

	echo "<td>";
	echo "<table border=0 cellpadding=5 class=\"vouchertable\" width=\"450\">";
	echo "<tr valign=\"top\">";
	echo "<td class=\"bold\">Asset Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($asset_total) . "</td>";
	echo "</tr>";

	/* If Profit then Liability side, If Loss then Asset side */
	if ($pandl != 0)
	{
		if ($pandl > 0)
		{
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		} else {
			$total += -$pandl;
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Profit & Loss A/C (Net Loss)</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$pandl) . "</td>";
			echo "</tr>";
		}
	}

	/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
	if ($diffop != 0)
	{
		if ($diffop > 0)
		{
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		} else {
			$total += -$diffop;
			echo "<tr valign=\"top\">";
			echo "<td class=\"bold\">Diff in O/P Balance</td>";
			echo "<td align=\"right\" class=\"bold\">" . convert_cur(-$diffop) . "</td>";
			echo "</tr>";
		}
	}

	echo "<tr valign=\"top\" class=\"tr-balance\">";
	echo "<td class=\"bold\">Total</td>";
	echo "<td align=\"right\" class=\"bold\">" . convert_cur($total) . "</td>";
	echo "</tr>";
	echo "</table>";

	echo "</td>";
	echo "</tr>";
	echo "</table>";

