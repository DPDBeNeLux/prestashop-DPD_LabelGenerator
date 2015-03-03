<div class="tab-pane" id="labels">
	<h4 class="visible-print">{l s='Labels'} <span class="badge">{$labels|@count}</span></h4>
	<div class="table-responsive">
		<table class="table" id="labels_table">
			<thead>
				<tr>
					<th>
						<span class="title_box ">{l s='Number'}</span>
					</th>
					<th>
						<span class="title_box ">{l s='Date'}</span>
					</th>
					<th>
						<span class="title_box ">{l s='Weight'}</span>
					</th>
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
							<a class="btn btn-default" href="">
								<i class="icon-repeat"></i>
								{l s='Generate label'}
							</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>