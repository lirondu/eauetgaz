<div id="ok-message-box" class="ui-corner-all">DONE</div>

<div id="error-message-box" class="ui-corner-all">
	Something went wrong..<br>Please try to refresh the page...
</div>



<!-- BS Modals -->

<!-- Cancel Modal -->
<div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="Cancel all changes on this page">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Cancel all changes on this page</h4>
			</div>

			<div class="modal-body">
				Are you sure you want cancel all changes done on this page?<br><br>
				This action is irreversible!!
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-danger" id="cancel_page_changes">Cancel all Changes</button>
			</div>

		</div>

	</div>

</div>


<!-- Save Modal -->
<div class="modal fade" id="save_modal" tabindex="-1" role="dialog" aria-labelledby="Save all changes on this page">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Save all changes on this page</h4>
			</div>

			<div class="modal-body">
				Are you sure you want save all 'Article' changes done on this page?<br><br>
				This action is irreversible!!
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary" id="save_page_changes">Save Changes</button>
			</div>

		</div>

	</div>

</div>