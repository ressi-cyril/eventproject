<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Event Occurrences List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Event Occurrences</h1>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        <a href="/admin/event-occurrences/create" class="btn btn-primary mb-3">Add New Occurrence</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event ID</th>
                    <th>Occurrence Date</th>
                    <th>Location</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($occurrences as $occurrence): ?>
                    <tr>
                        <td><?= esc($occurrence['id']) ?></td>
                        <td>
                            <a href="/admin/events/edit/<?= esc($occurrence['event_id']) ?>">
                                <?= esc($occurrence['event_slug']) ?>
                            </a>
                        </td>
                        <td><?= esc($occurrence['occurrence_date']) ?></td>
                        <td><?= esc($occurrence['location']) ?></td>
                        <td><img src="<?= base_url('/uploads/event_occurrences/' . esc($occurrence['image'])) ?>" alt="Occurrence Image" width="100"></td>
                        <td>
                            <a href="/admin/event-occurrences/edit/<?= $occurrence['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/admin/event-occurrences/delete/<?= $occurrence['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>