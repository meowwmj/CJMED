<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captured Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo $row['captured_photo']; ?>" alt="Zoomed Captured Photo" style="width: 100%; max-width: 100%; border-radius: 10px;" />
            </div>
        </div>
    </div>
</div>
