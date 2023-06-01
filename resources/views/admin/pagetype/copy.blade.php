<div class="modal fade" id="copy_page-types" tabindex="-1" role="dialog" aria-labelledby="copy_page-types_label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="copy-page-types-form" name="copy-page-types-form" action="{{ url('admin/page-types/copy') }}" class="" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" id="copy_id" value="">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>Are you sure?</h3>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6 text-right">
								<button class="btn btn-primary confirmcopy" type="submit">Yes</button>
							</div>
							<div class="col-md-6 text-left">
								<button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
							</div>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

