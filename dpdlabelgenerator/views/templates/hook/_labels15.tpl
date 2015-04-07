<!-- DPD block -->
<div class="clear" style="margin-top: 10px;"></div>
<fieldset>
	<legend><img src="../img/admin/delivery.gif" /> {l s='Labels'}</legend>
	<form action="{$downloadLink}" method="post" class="form-horizontal well hidden-print">
		<div class="clear" style="margin-bottom: 10px;"></div>
		<table class="table" width="100%" cellspacing="0" cellpadding="0" id="labels_table">
			<colgroup>
				<col width="10%"/>
				<col width=""/>
				<col width="30%"/>
				<col width="15%"/>
			</colgroup>
			<thead>
				<tr>
					<th />
					<th>{l s='Number'}</th>
					<th>{l s='Date'}</th>
					<th>{l s='Weight'}</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$labels item=label}
				<tr id="label_{$label->number}">
					<td><input type="checkbox" name="selected_label[]" value="{$label->number}" /></td>
					<td><a href="{$downloadLink}&labelnumber={$label->number}">{$label->number}</a></td>
					<td>{$label->date_add}</td>
					<td>{$label->weight}</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="4" class="list-empty">
						<div class="list-empty-msg">
							<i class="icon-warning-sign list-empty-icon"></i>
							{l s='There is no label available'}
						</div>
					</td>
				</tr>
			{/foreach}
			{if $labels|@count}
				<tr>
					<td colspan="4" class="list-empty">
						<button type="submit" name="download_label" class="btn btn-primary" value="submit">
							{l s='Download Label(s)'}
						</button>
					</td>
				</tr>
			{/if}
			</tbody>
		</table>
	</form>
	{if $labels|@count}
	<form action="{$downloadLink}" method="post" class="form-horizontal well hidden-print">
		<div class="row">
			<div class="col-lg-1">
				<input type="text" name="label_count" value="1" />
				<input type="hidden" name="id_order" value="{$id_order}" />
			</div>
			<div class="col-lg-3">
				<button type="submit" name="generate_label" class="btn btn-primary" value="submit">
					{l s='Generate Label(s)'}
				</button>
			</div>
		</div>
	</form>
	{/if}
</fieldset>
<br />

