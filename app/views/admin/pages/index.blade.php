<?php Orchestra\Site::set('header::add-button', true); ?>
@include('orchestra/foundation::layout.widgets.header')

<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Post</th>
			<th>Posted By</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@if ($pages->isEmpty())
		<tr>
			<td colspan="4">No records</td>
		</tr>
		@else
		@foreach ($pages as $page)
		<tr>
			<td><?php echo $page->id; ?></td>
			<td><?php echo $page->title; ?></td>
			<td><?php echo $page->author->fullname; ?></td>
			<td>
				<div class="btn-group">
					<a href="<?php echo handles("orchestra/foundation::resources/playground.pages/{$page->id}/edit"); ?>" 
						class="btn btn-mini btn-warning">Edit</a>
					<a href="<?php echo handles("orchestra/foundation::resources/playground.pages/{$page->id}/delete"); ?>" 
						class="btn btn-mini btn-danger">Delete</a>
				</div>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>

<?php echo $pages->links(); ?>
