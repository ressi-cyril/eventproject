<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Occurrences for Event ID <?= esc($eventId) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Occurrences for Event ID <?= esc($eventId) ?></h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <a href="<?= base_url('admin/events') ?>" class="btn btn-secondary mb-3">Back to Events</a>
        <a href="<?= base_url('admin/event-occurrences/create/' . esc($eventId)) ?>" class="btn btn-primary mb-3">
            Add New Occurrence
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($occurrences)): ?>
                    <?php foreach ($occurrences as $occurrence): ?>
                        <tr>
                            <td><?= esc($occurrence['id']) ?></td>
                            <td><?= esc($occurrence['occurrence_date']) ?></td>
                            <td><?= esc($occurrence['location']) ?></td>
                            <td>
                                <?php if (!empty($occurrence['image'])): ?>
                                    <img src="<?= base_url('uploads/event_occurrences/' . esc($occurrence['image'])) ?>" alt="Occurrence Image" width="100">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/event-occurrences/edit/<?= $occurrence['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="/admin/event-occurrences/delete/<?= $occurrence['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No occurrences found for this event.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
