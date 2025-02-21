<?= helper('form') ?>
<?php
use App\Enum\GalleryTypeEnum;

// Ensure variables are defined
$eventId = isset($eventId) ? $eventId : 0;
$occurenceId = isset($occurenceId) ? $occurenceId : 0;
$eventSlug = isset($eventSlug) ? $eventSlug : '';

// Determine the gallery type based on the provided IDs:
if ($eventId > 0 && $occurenceId == 0) {
    $galleryType = GalleryTypeEnum::TYPE_MAIN->value;
} elseif ($occurenceId > 0) {
    $galleryType = GalleryTypeEnum::TYPE_OCCURRENCE->value;
} else {
    $galleryType = '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Create Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Create Gallery</h1>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <!-- Open form with multipart encoding for file uploads -->
        <?= form_open_multipart("/admin/galleries/create/{$eventId}/{$occurenceId}", ['class' => 'form']) ?>

        <!-- Event Information -->
        <div class="form-group">
            <label for="event_id">Event</label>
            <?php if ($eventId > 0): ?>
                <!-- If created from an event, show the event slug and disable editing -->
                <input type="text" class="form-control" id="event_id_display" value="<?= esc($eventSlug) ?>" disabled>
                <input type="hidden" name="event_id" value="<?= esc($eventId) ?>">
            <?php else: ?>
                <!-- If no event is provided (gallery created from an occurrence), disable the event field -->
                <input type="text" class="form-control" id="event_id_display" placeholder="N/A" disabled>
                <input type="hidden" name="event_id" value="">
            <?php endif; ?>
        </div>

        <!-- Occurrence Information -->
        <div class="form-group">
            <label for="occurrence_id">Occurrence</label>
            <?php if ($occurenceId > 0): ?>
                <!-- If created from an occurrence, show the occurrence id and disable editing -->
                <input type="text" class="form-control" id="occurrence_id_display" value="<?= esc($occurenceId) ?>" disabled>
                <input type="hidden" name="occurrence_id" value="<?= esc($occurenceId) ?>">
            <?php else: ?>
                <!-- If no occurrence is provided (gallery created from an event), disable the occurrence field -->
                <input type="text" class="form-control" id="occurrence_id_display" placeholder="N/A" disabled>
                <input type="hidden" name="occurrence_id" value="">
            <?php endif; ?>
        </div>

        <!-- Gallery Type -->
        <div class="form-group">
            <label for="gallery_type">Gallery Type</label>
            <input type="text" class="form-control" id="gallery_type_display" value="<?= esc($galleryType) ?>" disabled>
            <input type="hidden" name="gallery_type" value="<?= esc($galleryType) ?>">
        </div>

        <!-- Images Upload: Dynamic file inputs -->
        <div class="form-group">
            <label for="images">Upload Images</label>
            <div id="fileInputs">
                <input type="file" class="form-control mb-2" name="images[]" id="images">
            </div>
            <button type="button" id="addImageBtn" class="btn btn-secondary">Add Another Image</button>
        </div>

        <div class="form-group">
            <?= form_submit('submit', 'Create Gallery', ['class' => 'btn btn-success']) ?>
        </div>

        <?= form_close(); ?>
    </div>

    <script>
        document.getElementById('addImageBtn').addEventListener('click', function(){
            var container = document.getElementById('fileInputs');
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'images[]';
            newInput.className = 'form-control mb-2';
            container.appendChild(newInput);
        });
    </script>
</body>
</html>
