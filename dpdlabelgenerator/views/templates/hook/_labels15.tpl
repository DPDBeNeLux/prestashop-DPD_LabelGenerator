<!-- DPD block -->
<div class="clear" style="margin-top: 10px;"></div>
<fieldset>
	<legend><img src="../img/admin/delivery.gif" /> {l s='Labels'}</legend>

	<div class="clear" style="margin-bottom: 10px;"></div>
	<table class="table" width="100%" cellspacing="0" cellpadding="0" id="labels_table">
		<colgroup>
			<col width=""/>
			<col width="30%"/>
			<col width="15%"/>
		</colgroup>
		<thead>
			<tr>
				<th>{l s='Number'}</th>
				<th>{l s='Date'}</th>
				<th>{l s='Weight'}</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$labels item=label}
			<tr id="label_{$label->number}">
				<td><a href="{$downloadLink}&labelnumber={$label->number}">{$label->number}</a></td>
				<td>{$label->date_add}</td>
				<td>{$label->weight}</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3" class="list-empty">
					<div class="list-empty-msg">
						<i class="icon-warning-sign list-empty-icon"></i>
						{l s='There is no label available'}
					</div>
<!--					
					<a class="btn btn-default" href="">
						<i class="icon-repeat"></i>
						{l s='Generate label'}
					</a>
-->
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</fieldset>
<br />

