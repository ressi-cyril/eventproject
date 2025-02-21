<?= helper('form') ?>
<?php

// Ensure both variables are defined, defaulting to 0 if not
$eventId = isset($eventId) ? $eventId : 0;
$occurrenceId = isset($occurrenceId) ? $occurrenceId : 0;

// Determine context and return URL based on provided IDs.
$context = '';
$returnUrl = '';
if ($eventId > 0) {
    $context = 'Event';
    $identifier = $eventId;
    $returnUrl = base_url('admin/events');
    $headerInfo = "Event ID: " . esc($eventId);
} elseif ($occurrenceId > 0) {
    $context = 'Occurrence';
    $identifier = $occurrenceId;
    $returnUrl = base_url('admin/event-occurrences');
    $headerInfo = "Occurrence ID: " . esc($occurrenceId);
} else {
    $headerInfo = '';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gallery Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Gallery for <?= esc($context) ?> (<?= $headerInfo ?>)</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (empty($gallery)): ?>
            <p>No gallery exists for this <?= strtolower($context) ?>.</p>
            <!-- Link to create gallery using both eventId and occurrenceId -->
            <a href="<?= base_url("admin/galleries/create/" . esc($eventId) . "/" . esc($occurrenceId)) ?>" class="btn btn-primary">
                Create Gallery
            </a>
        <?php else: ?>
            <?php 
                // Decode the JSON images field.
                $images = json_decode($gallery['images'], true);
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $img): ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url('uploads/gallery/' . esc($img)) ?>" alt="Gallery Image" width="100">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>No images recorded.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Link to update the gallery record -->
            <a href="<?= base_url("admin/galleries/edit/" . esc($gallery['id'])) ?>" class="btn btn-warning">
                Update Gallery
            </a>
        <?php endif; ?>

        <a href="<?= esc($returnUrl) ?>" class="btn btn-secondary mt-3">Back to <?= esc($context) ?> List</a>
    </div>
</body>
</html>
