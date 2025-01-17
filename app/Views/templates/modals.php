<div class="modal draggable fade" data-backdrop="static" id="modal_ajax">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>

			<div class="modal-body">

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="modal_close" data-dismiss="modal">Close</button>
				<button type="button" id="modal_reset" class="btn btn-danger modal_action_buttons">Reset</button>
				<button type="button" id="modal_save" data-item_id="" data-feature_plural="" class="btn btn-success modal_action_buttons">Save</button>
			</div>
		</div>
	</div>
</div>


<div class="modal draggable fade" data-backdrop="static" id="modal_list_ajax">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>

			<div class="modal-body">

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="modal_close" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Overlay HTML -->
<div id="overlay"><img src='<?php echo base_url() . "images/loaders/preloader4.gif"; ?>' /></div>


<div class="modal draggable fade" data-backdrop="static" id="delete_confirmation">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				Are you sure you want to delete this item?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
			</div>
		</div>
	</div>
</div>
